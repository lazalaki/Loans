<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ActiveUserRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\NewPasswordRequest;
use Exception;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService) {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request) {
        try {
            $loginResponse = $this->authService->login($request->email, $request->password);
            return $loginResponse;
        } catch(Exception $exception) {
            return response()->json(['error' => $exception->getMessage()],400);
        }
    }

    public function createUser(RegisterRequest $request) {
        try {
            $this->authService->createUser($request);
            return response()->json([], 201);
        } catch(Exception $exception) {
            return response()->json(['error' => $exception->getMessage()],400);
        }
    }

    public function activateUser(ActiveUserRequest $request) {
        try {
            $this->authService->activateUser($request->token, $request->password);
            return response()->json([], 200);
        } catch(Exception $exception) {
            return response()->json(['error' => $exception->getMessage()],400);
        }
    }

    public function resetPassword(ResetPasswordRequest $request) {
        try {
            $this->authService->resetPassword($request->email);
            return response()->json([], 200);
        } catch(Exception $exception) {
            return response()->json(['error' => $exception->getMessage()], 400);
        }
    }

    public function newPassword(NewPasswordRequest $request) {
        try {
            $this->authService->newPassword($request->token, $request->password);
            return response()->json([], 200);
        } catch(Exception $exception) {
            return response()->json(['error'=> $exception->getMessage()], 400);
        }
    }
}
