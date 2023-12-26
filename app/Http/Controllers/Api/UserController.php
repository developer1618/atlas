<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Botble\Hotel\Models\Customer;
use Illuminate\Support\Facades\Validator;
class UserController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::check()) {
            $user = Auth::user();

            // Получение всех данных о пользователе из базы данных
            $userData = Customer::where('id', $user->id)->first();

            if (!$userData) {
                return response()->json(['error' => 'User not found'], 404);
            }

            return response()->json(['user' => $userData]);
        }

        return response()->json(['error' => 'Not authenticated'], 401);

    }

    public function update(Request $request)
    {
        // Валидация входных данных
//        $validatedData = $request->validate([
//
//        ]);

        // Проверка аутентификации пользователя
        if (Auth::check()) {
            $user = Auth::user();

            // Находим пользователя в базе данных
            $userData = Customer::find($user->id);

            if (!$userData) {
                return response()->json(['error' => 'User not found'], 404);
            }
            $rules = [
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'nullable|string|email|max:255|unique:customers,email,' . Auth::id(),
                'password' => 'nullable|string|max:191',
                'avatar' => 'nullable|string|max:255',
                'dob' => 'nullable|date',
                'phone' => 'required|regex:/^\+?[0-9]+$/|max:25',
                'address' => 'nullable|string|max:191',
                'zip' => 'nullable|string|max:10',
                'city' => 'nullable|string|max:120',
                'state' => 'nullable|string|max:120',
                'country' => 'nullable|string|max:120',
            ];

            // Создание экземпляра валидатора
            $validator = Validator::make($request->all(), $rules);

            // Проверка валидации
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 422);
            }

            // Обновление данных текущего пользователя
            $user->update($request->all());

            return response()->json(['message' => 'User data updated successfully', 'user' => $user]);
        }
    }
}