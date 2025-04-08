<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 * name="auth",
 * description="Authentication operations"
 * )
 */
/**
 * @OA\Info(
 * title="User Authentication API",
 * version="1.0.0",
 * description="API for user authentication and management"
 * )
 */
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

    /**
     * @OA\Post(
     * path="/api/register",
     * summary="Register a new user",
     * tags={"auth"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="name", type="string", example="John Doe"),
     * @OA\Property(property="email", type="string", example="johndoe@example.com"),
     * @OA\Property(property="password", type="string", example="password123"),
     * @OA\Property(property="password_confirmation", type="string", example="password123")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="User registered successfully"
     * ),
     * @OA\Response(
     * response=422,
     * description="Validation error"
     * )
     * )
     **/


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
     * @OA\Post(
     * path="/api/login",
     * summary="Login a user",
     * tags={"auth"},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * @OA\Property(property="email", type="string", example="user@example.com"),
     * @OA\Property(property="password", type="string", example="password123")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Successful login",
     * @OA\JsonContent(
     * @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Validation error"
     * )
     * )
     **/



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
     * @OA\Post(
     * path="/api/logout",
     * summary="Logout a user",
     * tags={"auth"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Successfully logged out"
     * ),
     * @OA\Response(
     * response=422,
     * description="Validation error"
     * )
     **/

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
     * @OA\Get(
     * path="/api/user",
     * summary="Get authenticated user",
     * tags={"auth"},
     * @OA\Response(
     * response=200,
     * description="Authenticated user data"
     * ),
     * @OA\Response(
     * response=401,
     * description="Unauthenticated"
     * )
     * )
     **/

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
     * @OA\Post(
     * path="/api/refresh-token",
     * summary="Refresh user token",
     * tags={"auth"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Token refreshed successfully"
     * ),
     * @OA\Response(
     * response=401,
     * description="Unauthenticated"
     * )
     * )
     **/


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
     * @OA\Delete(
     * path="/api/delete-token",
     * summary="Delete user token",
     * tags={"auth"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Token deleted successfully"
     * ),
     * @OA\Response(
     * response=401,
     * description="Unauthenticated"
     * )
     * )
     **/

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
     * @OA\Get(
     * path="/api/users",
     * summary="Get all users",
     * tags={"auth"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="List of users"
     * ),
     * @OA\Response(
     * response=422,
     * description="Validation error"
     * )
     * )
     **/
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
     * @OA\Get(
     * path="/api/user/{id}",
     * summary="Find user by ID",
     * tags={"auth"},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="User ID",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="User found"
     * ),
     * @OA\Response(
     * response=422,
     * description="Validation error"
     * )
     * )
     **/


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
     * @OA\Get(
     * path="/api/user/email/{email}",
     * summary="Find user by email",
     * tags={"auth"},
     * @OA\Parameter(
     * name="email",
     * in="path",
     * required=true,
     * description="User email",
     * @OA\Schema(type="string")
     * ),
     * @OA\Response(
     * response=200,
     * description="User found"
     * ),
     * @OA\Response(
     * response=422,
     * description="Validation error"
     * )
     * )
     **/
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
