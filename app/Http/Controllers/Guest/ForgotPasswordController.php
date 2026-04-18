<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guest\ForgotPassword\SubmitEmailRequest;
use App\Http\Requests\Guest\ResetPassword\ResetPasswordRequest;
use App\Models\User;
use App\Utils\TransactionUtil;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Password;
use Str;
use Symfony\Component\HttpFoundation\Response;

class ForgotPasswordController extends Controller
{
    /**
     * Summary of submit_email
     * @param SubmitEmailRequest $request
     * @return JsonResponse
     */
    public function submit_email(SubmitEmailRequest $request): JsonResponse
    {
        return TransactionUtil::transact($request, [], function() use ($request) {
            $email = $request->email;

            $status = Password::sendResetLink(['email' => $email]);
            return $status === Password::RESET_LINK_SENT
                ? response()->json(['status' => 'success', 'message' => __($status)], Response::HTTP_OK)
                : response()->json(['status' => 'error', 'message' => __($status)], Response::HTTP_BAD_REQUEST);
        });
    }

    /**
     * Summary of reset_password
     * @param ResetPasswordRequest $request
     */
    public function reset_password(ResetPasswordRequest $request): JsonResponse
    {
        return TransactionUtil::transact($request, [], function () use ($request) {
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function (User $user, string $password) use ($request) {
                    $user->forceFill([ 'password' => bcrypt($password) ])->setRememberToken(Str::random(60));
                    $user->save();

                    event(new PasswordReset($user));
                }
            );

            return $status == Password::PASSWORD_RESET
                ? response()->json(['status' => 'success', 'message' => __($status)], 200)
                : response()->json(['status' => 'error', 'message' => __($status)], 400);
        });
    }
}
