<?php

namespace App\Http\Controllers\Auth;

use Botble\ACL\Traits\ResetsPasswords;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function reset(Request $request)
    {
        try {
            $this->validateReset($request);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
        }

        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $user->password = Hash::make($password); // Используйте Hash::make для хеширования пароля
                $user->save();
            }
        );

        return $response == Password::PASSWORD_RESET
            ? response()->json(['message' => 'Password has been reset'])
            : response()->json(['error' => 'Unable to reset password'], 400);
    }

    public function broker(): PasswordBroker
    {
        return Password::broker('customers');
    }

    protected function validateReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required|string',
            'password' => 'required|string|min:8|confirmed',
        ]);
    }

    protected function credentials(Request $request)
    {
        return $request->only('email', 'password', 'password_confirmation', 'token');
    }
}