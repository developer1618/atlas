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
use Illuminate\Support\Facades\Validator;
class BookingController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();
            $bookings = $user->bookings()->get();
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

//    public function store(Request $request)
//    {
//        try {
//            $bookingData = $request->all(); // Получаем данные из запроса
//
//            $booking = Booking::create($bookingData); // Создаем бронирование
//
//            // Получаем пользователя, совершившего бронирование
//            $user = Auth::user();
//
//            // Вычисляем сумму бонусов на основе 5% от стоимости бронирования
//            $bonusPoints = floor($bookingData['amount'] * 0.05);
//
//            // Зачисляем бонусы пользователю
//            $user->update([
//                'bonuses' => $user->bonuses + $bonusPoints,
//            ]);
//
//            return response()->json([
//                'message' => 'Booking created successfully',
//                'data' => $booking,
//                'bonuses_added' => $bonusPoints,
//            ], 200);
//        } catch (\Exception $e) {
//            return response()->json(['message' => 'Failed to create booking'], 500);
//        }
//    }

    public function postBookingAPI(InitBookingRequest $request)
    {
        $room = Room::query()
            ->with(['currency', 'category'])
            ->findOrFail($request->input('room_id'));

        $token = md5(Str::random(40));

        // Сохраняем данные бронирования по ключу, соответствующему токену
        session()->put($token, $request->except(['_token']));
        session()->put('checkout_token', $token);

        return ['token' => $token];
    }

    public function getBookingAPI(string $token)
    {
        $customer = new Customer();

        if (Auth::guard('customer')->check()) {
            $customer = Auth::guard('customer')->user();
        }

        // Получаем данные бронирования по ключу, соответствующему токену
        $sessionData = session()->get($token);

        if (empty($sessionData)) {
            return response()->json(['error' => 'Error Data'], 404);
        }

        $startDate = Carbon::createFromFormat('d-m-Y', Arr::get($sessionData, 'start_date'));
        $endDate = Carbon::createFromFormat('d-m-Y', Arr::get($sessionData, 'end_date'));
        $adults = Arr::get($sessionData, 'adults');

        $room = Room::query()
            ->with([
                'currency',
                'category',
                'activeBookingRooms',
                'activeRoomDates',
            ])
            ->findOrFail(Arr::get($sessionData, 'room_id'));
        if (!$room->isAvailableAt(['start_date' => $startDate, 'end_date' => $endDate])) {
            return response()->json([
                'error' => 'Room not available for booking',
                'message' => 'This room is not available for booking from ' . $startDate->toDateString() . ' to ' . $endDate->toDateString(),
            ], 400);
        }

        $room->total_price = $room->getRoomTotalPrice($startDate, $endDate);

        $taxAmount = $room->tax->percentage * $room->total_price / 100;

        $services = Service::query()
            ->wherePublished()
            ->get();

        return [
            'room' => $room,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'adults' => $adults,
            'total' => $room->total_price + $taxAmount,
            'taxAmount' => $taxAmount,
            'services' => $services,
            'token' => $token,
            'customer' => $customer,
        ];
    }

    public function postCheckoutAPI(Request $request)
    {
        $room = Room::query()->findOrFail($request->input('room_id'));

        if ($request->input('register_customer') == 1) {
            $request->validate([
                'email' => 'required|max:60|min:6|email|unique:ht_customers,email',
            ]);

            $customer = Customer::query()->create([
                'first_name' => BaseHelper::clean($request->input('first_name')),
                'last_name' => BaseHelper::clean($request->input('last_name')),
                'email' => BaseHelper::clean($request->input('email')),
                'phone' => BaseHelper::clean($request->input('phone')),
                'password' => Hash::make($request->input('password')),
            ]);

            Auth::guard('customer')->loginUsingId($customer->getKey());
            }
        $booking = new Booking();
        $booking->fill($request->input());

        $startDate = Carbon::createFromFormat('d-m-Y', $request->input('start_date'));
        $endDate = Carbon::createFromFormat('d-m-Y', $request->input('end_date'));

        $room->total_price = $room->getRoomTotalPrice($startDate, $endDate);

        $serviceIds = $request->input('services', []);

        [$amount, $discountAmount] = $this->calculateBookingAmount($room, $serviceIds);

        $taxAmount = $room->tax->percentage * ($amount - $discountAmount) / 100;

        $booking->coupon_amount = $discountAmount;
        $booking->coupon_code = Session::get('coupon_code', '');
        $booking->amount = ($amount - $discountAmount) + $taxAmount;
        $booking->sub_total = $amount;
        $booking->tax_amount = $taxAmount;
        $booking->transaction_id = Str::upper(Str::random(32));

        if (Auth::guard('customer')->check()) {
            $booking->customer_id = Auth::guard('customer')->user()->getKey();
            $user = Auth::guard('customer')->user();
            $bonusPoints = floor($amount * 0.05);

            // Зачисляем бонусы пользователю
            $user->update([
                'bonuses' => $user->bonuses + $bonusPoints,
            ]);
            // Передаем количество зачисленных бонусов в ответе
            $bonusesAdded = $bonusPoints;
        } else {
            $bonusesAdded = 0; // Не залогиненному пользователю не начисляются бонусы
        }

        $booking->save();

        if ($serviceIds) {
            $booking->services()->attach($serviceIds);
        }

        session()->put('booking_transaction_id', $booking->transaction_id);

        BookingRoom::query()->create([
            'room_id' => $room->getKey(),
            'room_name' => $room->name,
            'room_image' => Arr::first($room->images),
            'booking_id' => $booking->getKey(),
            'price' => $room->total_price,
            'currency_id' => $room->currency_id,
            'number_of_rooms' => 1,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ]);

        $bookingAddress = new BookingAddress();
        $bookingAddress->fill($request->input());
        $bookingAddress->booking_id = $booking->getKey();
        $bookingAddress->save();

        $request->merge([
            'order_id' => $booking->getKey(),
        ]);

        $data = [
            'error' => false,
            'message' => false,
            'amount' => $booking->amount,
            'currency' => strtoupper(get_application_currency()->title),
            'type' => $request->input('payment_method'),
            'charge_id' => null,
        ];
        return [
            'booking_transaction_id' => $booking->transaction_id,
            // Include other necessary data here
        ];
    }
    public function checkoutSuccessAPI(string $transactionId)
    {
        $booking = Booking::query()
            ->where('transaction_id', $transactionId)
            ->firstOrFail();

        return ['booking' => $booking];
    }

//    public function createBooking(Request $request)
//    {
//        $validator = Validator::make($request->all(), [
//            'room_id' => 'required|exists:ht_rooms,id',
//            'start_date' => 'required|date_format:d-m-Y',
//            'end_date' => 'required|date_format:d-m-Y|after:start_date',
//            'adults' => 'required|integer|min:1',
//        ]);
//
//        if ($validator->fails()) {
//            return response()->json(['error' => $validator->errors()], 400);
//        }
//
//        $room = Room::findOrFail($request->input('room_id'));
//
//        // Создаем уникальный токен
//        $token = md5(Str::random(40));
//
//        // Сохраняем данные запроса в сессии по этому токену (в данном случае, заменяем на сохранение в базе или во временном хранилище для API)
//        $bookingData = [
//            'token' => $token,
//            'room_id' => $room->id
////            'start_date' => $startDate, // Добавление start_date
////            'end_date' => $endDate, // Добавление end_date
//        ];
//
//        // Сохраняем данные бронирования в базу (или временное хранилище для API)
//        $createdBooking = Booking::create($bookingData);
//
//        // Создаем и сохраняем адрес бронирования (если это необходимо)
////        $addressData = [
////            'booking_id' => $createdBooking->id,
////            // Добавьте данные адреса здесь
////        ];
////        BookingAddress::create($addressData);
//
//        // Отправляем ответ об успешном создании бронирования и возвращаем данные бронирования
//        return response()->json([
//            'message' => 'Booking created successfully',
//            'booking' => $createdBooking,
//        ], 201);
//    }

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

}