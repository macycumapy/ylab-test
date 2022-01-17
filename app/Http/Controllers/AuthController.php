<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthenticateRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        print_r($request->validated());
        $data = $request->validated();
        $data['password'] = bcrypt($request->password);
        /** @var User $user */
        $user = User::create($data);
        $user->roles()->attach(Role::ofUser()->first());

        return response()->json([
            'token' => $user->createToken('tokens')->plainTextToken,
            'user' => $user,
        ]);
    }

    /**
     * @param AuthenticateRequest $request
     * @return JsonResponse
     * @throws AuthenticationException
     */
    public function authenticate(AuthenticateRequest $request): JsonResponse
    {
        if (!auth()->attempt($request->validated())) {
            throw new AuthenticationException();
        }

        /** @var User $user */
        $user = auth()->user();
        return response()->json([
            'token' => $user->createToken('tokens')->plainTextToken,
            'user' => $user,
        ]);
    }
}
