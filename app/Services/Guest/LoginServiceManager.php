<?php

namespace App\Services\Guest;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginServiceManager {
    /**
     * Summary of loginUser
     * @param string $email
     * @param string $password
     * @return array{message: array{role: mixed, text: string, token: string, status: int}|array{message: string, status: int}}
     */
    public function loginUser(string $email, string $password): array
    {
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();

            if ($this->isEmailUnverified($user)) {
                Auth::logout();
                return [
                    'message' => 'Your email address is not yet verified. Please check your inbox.',
                    'status'  => Response::HTTP_FORBIDDEN
                ];
            }

            return [
                'message' => [
                    'text'  => "Success!",
                    'token' => $user->createToken('auth_token')->plainTextToken,
                    'role'  => $user->role
                ],
                'status' => Response::HTTP_OK
            ];
        }

        return [
            'message' => 'Invalid credentials. Please try again',
            'status'  => Response::HTTP_UNAUTHORIZED
        ];
    }

    /**
     * Summary of isEmailUnverified
     * @param User $user
     * @return bool
     */
    protected function isEmailUnverified(User $user): bool
    {
        $user->sendEmailVerificationNotification();
        return \is_null($user->email_verified_at);
    }
}
