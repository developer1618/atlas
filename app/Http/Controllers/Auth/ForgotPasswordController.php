<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Botble\Hotel\Models\Customer;
use Illuminate\Support\Facades\Password;
use Botble\ACL\Traits\SendsPasswordResetEmails;
use Illuminate\Contracts\Auth\PasswordBroker;
class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;
    public function __construct()
    {
        $this->middleware('guest');
    }
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Reset link sent to your email'])
            : response()->json(['error' => 'Unable to send reset link'], 400);
    }
    public function broker(): PasswordBroker
    {
        return Password::broker('customers');
    }
}