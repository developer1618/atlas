<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Botble\Hotel\Models\Customer;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
class UserAuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->only(['first_name', 'last_name', 'email', 'password', 'password_confirmation']);

        $requiredFields = ['first_name', 'last_name', 'email', 'password', 'password_confirmation'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field])) {
                return response()->json(['error' => 'Missing required fields.'], 422);
            }
        }

        if ($data['password'] !== $data['password_confirmation']) {
            return response()->json(['error' => 'The password confirmation does not match.'], 422);
        }

        // Проверка на существующего пользователя с той же почтой
        if (Customer::where('email', $data['email'])->exists()) {
            return response()->json(['error' => 'User with this email already exists.'], 422);
        }

        $customer = Customer::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        Auth::login($customer); // Войти после создания пользователя

        return response()->json(['message' => __('Registered successfully!'), 'customer' => $customer]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = Customer::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json(['message' => 'Logged in successfully', 'user' => $user, 'token' => $token]);
    }



    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
}