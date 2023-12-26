<?php

namespace App\Http\Controllers\Api;

use Botble\Hotel\Models\Food;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Botble\Base\Http\Responses\BaseHttpResponse;

class RestaurantController extends Controller
{
    public function index()
    {
        // Получение всех номеров
        $foods = Food::all();

        return response()->json($foods);
    }

    public function show($id)
    {
        // Получение данных конкретного номера по его ID
        $food = Food::findOrFail($id);

        return response()->json($food);
    }

    public function orderFood(Request $request, BaseHttpResponse $response)
    {
        // Получаем данные о заказе из запроса
        $foodId = $request->input('food_id');
        $quantity = $request->input('quantity');
        $firstName = $request->input('first_name');
        $lastName = $request->input('last_name');
        $roomNumber = $request->input('room_number');

        // Находим блюдо по ID
        $food = Food::findOrFail($foodId);

        // Создаем новый заказ с информацией о клиенте и номере комнаты
        $order = new Order([
            'food_id' => $foodId,
            'quantity' => $quantity,
            'first_name' => $firstName,
            'last_name' => $lastName,
            'room_number' => $roomNumber,
            // Здесь может быть дополнительная информация о заказе
        ]);

        // Сохраняем заказ в базе данных
        $order->save();

        // Возвращаем ответ о успешном создании заказа
        return $response->setMessage('Order placed successfully');
    }
}