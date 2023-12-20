<?php

namespace App\Http\Controllers\Api;

use Botble\Hotel\Http\Requests\BookingRequest;
use Botble\Hotel\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

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

    public function store(Request $request)
    {
        try {
            $bookingData = $request->all(); // Получаем данные из запроса

            $booking = Booking::create($bookingData); // Создаем бронирование

            // Получаем пользователя, совершившего бронирование
            $user = Auth::user();

            // Вычисляем сумму бонусов на основе 5% от стоимости бронирования
            $bonusPoints = $bookingData['amount'] * 0.05;

            // Зачисляем бонусы пользователю
            $user->update([
                'bonuses' => $user->bonuses + $bonusPoints,
            ]);

            return response()->json([
                'message' => 'Booking created successfully',
                'data' => $booking,
                'bonuses_added' => $bonusPoints,
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create booking'], 500);
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

}