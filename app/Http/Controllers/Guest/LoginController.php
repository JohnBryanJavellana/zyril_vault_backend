<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Http\Requests\Guest\LoginRequest;
use App\Services\Guest\LoginServiceManager;
use App\Utils\TransactionUtil;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __construct(
        public LoginServiceManager $loginServiceManager
    ) {}

    /**
     * Summary of login_user
     * @param LoginRequest $request
     * @return JsonResponse
     */
    public function login_user(LoginRequest $request): JsonResponse
    {
        return TransactionUtil::transact($request, [], function() use ($request) {
            $email = $request->email;
            $password = $request->password;

            $result = $this->loginServiceManager->loginUser($email, $password);
            return response()->json(['message' => $result['message']], $result['status']);
        });
    }
}
