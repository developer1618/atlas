<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendFormMail;
use App\Mail\SendOrderMail;

class SendController extends Controller
{
    public function sendForm(Request $request)
    {
        // Лог
        Log::info('Received form data:', $request->all());

        // Проверка, если данные пришли из формы
        if ($request->has(['lastName', 'firstName', 'room', 'food'])) {
            $lastName = $request->input('lastName');
            $firstName = $request->input('firstName');
            $room = $request->input('room');
            $food = $request->input('food'); // массив

            // Общая информация о заказе
            $orderDetails = [
                'lastName' => $lastName,
                'firstName' => $firstName,
                'room' => $room,
                'food' => $food,
            ];

            // Вычисление общей стоимости заказа
            $totalPrice = 0;
            foreach ($food as $item) {
                $totalPrice += $item['foodPrice'] * $item['foodCount'];
            }

            // общая стоимость к информации о заказе
            $orderDetails['totalPrice'] = $totalPrice;

            // Лог
            Log::info('Data before sending email:', $orderDetails);

            // Отправка письма
            try {
                Mail::to('atlastj11@gmail.com')->send(new SendOrderMail($orderDetails));

                if ($request->expectsJson()) {
                    // Возвращаем JSON-ответ
                    return response()->json(['message' => 'Данные успешно обработаны']);
                } else {
                    return redirect()->back()->with('success', 'Форма успешно отправлена!');
                }
            } catch (\Exception $e) {
                Log::error('Ошибка при отправке формы: ' . $e->getMessage());
                if ($request->expectsJson()) {
                    return response()->json(['error' => 'Произошла ошибка при отправке формы'], 500);
                } else {
                    return redirect()->back()->with('error', 'Произошла ошибка при отправке формы');
                }
            }
        } else {
            return redirect()->back()->with('error', 'Произошла ошибка. Не хватает данных из формы.');
        }
    }
}
