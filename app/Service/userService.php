<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Register a new user
     *
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public function register(array $data): array
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $data['password'] = Hash::make($data['password']);
        $user = $this->userRepository->createUser($data);

        return [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ];
    }
    /**
     * Login a user
     *
     * @param array $data
     * @return array
     * @throws ValidationException
     */
    public function login(array $data): array
    {
        $validator = Validator::make($data, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        if (!Auth::attempt($data)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user = Auth::user();

        return [
            'user' => $user,
            'token' => $user->createToken('auth_token')->plainTextToken,
        ];
    }
    /**
     * Logout a user
     *
     * @return void
     */
    public function logout(): void
    {
        $user = Auth::user();
        $user->tokens()->delete();
    }
    /**
     * Get authenticated user
     *
     * @return \App\Models\User|null
     */
    public function getAuthenticatedUser(): ?User
    {
        return Auth::user();
    }
    /**
     * Update user profile
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function updateProfile(array $data): User
    {
        $user = Auth::user();

        $validator = Validator::make($data, [
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'sometimes|required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->updateUser($user, $data);
    }
    /**
     * Delete user account
     *
     * @return void
     */
    public function deleteAccount(): void
    {
        $user = Auth::user();
        $this->userRepository->deleteUser($user);
    }
    /**
     * Find user by email
     *
     * @param string $email
     * @return \App\Models\User|null
     */
    public function findUserByEmail(string $email): ?User
    {
        return $this->userRepository->findUserByEmail($email);
    }
    /**
     * Find user by ID
     *
     * @param int $id
     * @return \App\Models\User|null
     */
    public function findUserById(int $id): ?User
    {
        return $this->userRepository->findUserById($id);
    }
    /**
     * Get all users
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }
}
