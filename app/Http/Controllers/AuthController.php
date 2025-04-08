<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $UserService;

    public function __construct(UserService $UserService)
    {
        $this->UserService = $UserService;
    }
    /**
     * Register a new user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $data = $request->only(['name', 'email', 'password', 'password_confirmation']);

        try {
            $response = $this->UserService->register($data);
            return response()->json($response, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
    /**
     * Login a user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $data = $request->only(['email', 'password']);

        try {
            $response = $this->UserService->login($data);
            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
    /**
     * Logout a user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        try {
            $this->UserService->logout($user);
            return response()->json(['message' => 'Successfully logged out'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
    /**
     * Get the authenticated user
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function user(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            return response()->json($user, 200);
        }

        return response()->json(['error' => 'Unauthenticated'], 401);
    }
    /**
     * Refresh the authenticated user's token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function refreshToken(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            $token = $user->createToken('auth_token')->plainTextToken;
            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Unauthenticated'], 401);
    }
    /**
     * Delete the authenticated user's token
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteToken(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();
            return response()->json(['message' => 'Token deleted'], 200);
        }

        return response()->json(['error' => 'Unauthenticated'], 401);
    }
    /**
     * Get all users
     *
     * @return JsonResponse
     */
    public function getAllUsers(): JsonResponse
    {
        try {
            $users = $this->UserService->getAllUsers();
            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * find a user by ID
     *
     * @param int $id
     * @return JsonResponse
     */

    public function findUserById(int $id): JsonResponse
    {
        try {
            $user = $this->UserService->findUserById($id);
            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    /**
     * find a user by Email
     *
     * @param string $email
     * @return JsonResponse
     */

    public function findUserByEmail(string $email): JsonResponse
    {
        try {
            $user = $this->UserService->findUserByEmail($email);
            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}
