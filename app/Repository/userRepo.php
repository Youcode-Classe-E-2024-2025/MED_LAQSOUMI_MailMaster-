<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    /**
     * Get all users.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers()
    {
        return User::all();
    }
    /**
     * Find a user by ID.
     *
     * @param int $id
     * @return \App\Models\User|null
     */
    public function findUserById($id)
    {
        return User::find($id);
    }
    /**
     * Create a new user.
     *
     * @param array $data
     * @return \App\Models\User
     */
    public function createUser(array $data)
    {
        return User::create($data);
    }
    /**
     * Update an existing user.
     *
     * @param \App\Models\User $user
     * @param array $data
     * @return \App\Models\User
     */
    public function updateUser(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }
    /**
     * Delete a user.
     *
     * @param \App\Models\User $user
     * @return bool|null
     */
    public function deleteUser(User $user)
    {
        return $user->delete();
    }
    /**
     * Find a user by email.
     *
     * @param string $email
     * @return \App\Models\User|null
     */
    public function findUserByEmail($email)
    {
        return User::where('email', $email)->first();
    }

}
