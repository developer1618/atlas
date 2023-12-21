<?php

namespace App\Http\Controllers\Api;

use Botble\Base\Facades\BaseHelper;
use Botble\Base\Facades\Html;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Hotel\Enums\ReviewStatusEnum;
use Botble\Hotel\Enums\ServicePriceTypeEnum;
use Botble\Hotel\Events\BookingCreated;
use Botble\Hotel\Facades\HotelHelper;
use Botble\Hotel\Http\Requests\CalculateBookingAmountRequest;
use Botble\Hotel\Http\Requests\CheckoutRequest;
use Botble\Hotel\Http\Requests\InitBookingRequest;
use Botble\Hotel\Models\Booking;
use Botble\Hotel\Models\BookingAddress;
use Botble\Hotel\Models\BookingRoom;
use Botble\Hotel\Models\Currency;
use Botble\Hotel\Models\Customer;
use Botble\Hotel\Models\Place;
use Botble\Hotel\Models\Room;
use Botble\Hotel\Models\Service;
use Botble\Hotel\Repositories\Interfaces\RoomInterface;
use Botble\Hotel\Services\BookingService;
use Botble\Hotel\Services\CouponService;
use Botble\Media\Facades\RvMedia;
use Botble\Payment\Enums\PaymentMethodEnum;
use Botble\Payment\Services\Gateways\BankTransferPaymentService;
use Botble\Payment\Services\Gateways\CodPaymentService;
use Botble\Payment\Supports\PaymentHelper;
use Botble\SeoHelper\Facades\SeoHelper;
use Botble\SeoHelper\SeoOpenGraph;
use Botble\Slug\Facades\SlugHelper;
use Botble\Theme\Facades\Theme;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
class BookingController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $bookings = $user->bookings()->with('room')->get();
            return response()->json($bookings);
        }

        return response()->json(['error' => 'Not authenticated'], 401);
    }


    public function show($id)
    {
        // Получение данных конкретного номера по его ID
        $room = Booking::findOrFail($id);

        return response()->json($room);
    }

    public function store(Request $request)
    {
        try {
            $bookingData = $request->all();
            $bookingData['transaction_id'] = Str::upper(Str::random(32));
            // Создаем бронирование и заполняем его данными из запроса
            $booking = Booking::create([
                'status' => $bookingData['status'],
                'amount' => $bookingData['amount'],
                'sub_total' => $bookingData['sub_total'],
//                'coupon_amount' => $bookingData['coupon_amount'],
//                'coupon_code' => $bookingData['coupon_code'],
                'customer_id' => $bookingData['customer_id'],
                'currency_id' => $bookingData['currency_id'],
                'requests' => $bookingData['requests'],
                'arrival_time' => $bookingData['arrival_time'],
                'number_of_guests' => $bookingData['number_of_guests'],
                'payment_id' => $bookingData['payment_id'],
                'transaction_id' => $bookingData['transaction_id'],
//                'tax_amount' => $bookingData['tax_amount'],
            ]);
            $roomData = Room::findOrFail($bookingData['room_id']); // Получаем данные о комнате
            $room = BookingRoom::create([
                'booking_id' => $booking->id,
                'room_id' => $bookingData['room_id'],
                'room_name' => $roomData->name, // Предположим, что название комнаты хранится в столбце 'name'
//                'room_image' => $bookingData['images'], // Предположим, что URL изображения хранится в столбце 'image_url'
                'price' => $roomData->price, // Предположим, что цена хранится в столбце 'price'
                'currency_id' => $bookingData['currency_id'],
                'number_of_rooms' => $roomData->number_of_rooms,
                'start_date' => $bookingData['start_date'],
                'end_date' => $bookingData['end_date'],
            ]);
           $address = BookingAddress::create([
                'first_name' => $bookingData['first_name'],
                'last_name' => $bookingData['last_name'],
                'phone' => $bookingData['phone'],
                'email' => $bookingData['email'],
                'country' => $bookingData['country'],
//                'state' => $bookingData['state'], // Если есть
//                'city' => $bookingData['city'], // Если есть
//                'address' => $bookingData['address'], // Если есть
//                'zip' => $bookingData['zip'], // Если есть
                'booking_id' => $booking->id,
            ]);
            $serviceIds = $request->input('services', []);
          //  $selectedServices = Service::whereIn('id', $serviceIds)->sum('price'); // Находим общую стоимость выбранных услуг
            $selectedServices = Service::whereIn('id', $serviceIds)->get();
            // Проверяем, было ли успешно создано бронирование
            if ($booking) {
                $user = Auth::user();
                $currentBonuses = $user->bonuses;
                // Вычисляем и добавляем бонусы пользователю
                $bonusPoints = number_format(round($roomData->price * 0.05, 2), 2);
                $user->update([
                    'bonuses' => $user->bonuses + $bonusPoints,
                ]);
                // Проверяем, достаточно ли у пользователя бонусов для оплаты услуг
                if (!$selectedServices->isEmpty()) {
                    $serviceTotal = $selectedServices->sum('price');
                    if ($currentBonuses < $serviceTotal) {
                        // Если бонусов недостаточно, откатываем изменения и возвращаем ошибку
                        $user->update([
                            'bonuses' => $currentBonuses, // Откатываем изменения баланса бонусов
                        ]);

                        throw new \Exception('Insufficient bonuses to pay for selected services');
                    }

                    // Вычитаем стоимость выбранных услуг из бонусов пользователя
                    $user->update([
                        'bonuses' => max(0, $user->bonuses - $serviceTotal),
                    ]);
                }

                return response()->json([
                    'message' => 'Booking created successfully',
                    'data' => [
                        'booking' => $booking,
                        'room' => $room,
                        'address' => $address,
                        'services' => $selectedServices, // Добавляем информацию о выбранных услугах
                    ],
                    'bonuses_added' => $bonusPoints,
                ], 200);
            } else {
                throw new \Exception('Failed to create booking');
            }
        } catch (\Exception $e) {
            Log::error('Ошибка: ' . $e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }


    public function update(BookingRequest $request, $id)
    {
        try {
            $booking = Booking::findOrFail($id);

            // Обновляем данные бронирования на основе данных из запроса
            $booking->fill($request->all());
            $booking->save();

            // Возвращаем успешный ответ после обновления
            return response()->json(['message' => 'Booking updated successfully'], 200);
        } catch (\Exception $e) {
            // Обработка ошибок, если бронирование не найдено или возникла другая проблема при обновлении
            return response()->json(['error' => 'Failed to update booking'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $booking = Booking::findOrFail($id);
            $booking->delete();

            // Возвращаем успешный ответ после удаления
            return response()->json(['message' => 'Booking deleted successfully'], 200);
        } catch (\Exception $e) {
            // Обработка ошибок, если бронирование не найдено или возникла другая проблема при удалении
            return response()->json(['error' => 'Failed to delete booking'], 500);
        }
    }
    public function getServices()
    {
        $services = Service::query()->wherePublished()->get();

        return response()->json($services);
    }
}
