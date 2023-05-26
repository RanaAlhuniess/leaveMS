<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\Api\UserResource;
use App\Services\UserService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends BaseController
{
    public UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('guest')->except('logout');
        $this->userService = $userService;
    }

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:8|max:255|confirmed'
        ]);

        if ($validator->fails()) {
            return $this->respondError($validator->errors(), 422);
        }
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password
            ]);
            $scope = $this->userService->getUserRoleScope($user);
            $token = $this->userService->generateUserAccessToken($user, $scope)->accessToken;
            return $this->respond((new UserResource($user))->withToken($token));
        } catch (Exception $e) {
            $message = 'Oops! Unable to create a new user.';

            return $this->respondError($message, 500);
        }
    }

    public function login(Request $request): JsonResponse
    {
        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];
        if (!auth()->attempt($data)) {
            return $this->respondError('Unauthorised', 401);
        }

        $user = auth()->user();
        $scope = $this->userService->getUserRoleScope($user);
        $token = $this->userService->generateUserAccessToken($user, $scope)->accessToken;
        return $this->respond((new UserResource($user))->withToken($token));
    }

    public function logout()
    {
        auth()->logout();
        return $this->respond(null, 204);
    }
}
