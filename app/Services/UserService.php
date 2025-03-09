<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserService
{
    /**
     * Get all users with their roles
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllUsers()
    {
        return User::with('roles')->get();
    }

    /**
     * Create a new user
     *
     * @param array $data
     * @return User
     * @throws \Exception
     */
    public function createUser(array $data)
    {
        try {
            \DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'is_active' => true,
            ]);

            // Assign role
            if (isset($data['role'])) {
                $role = Role::where('name', $data['role'])->firstOrFail();
                $user->assignRole($role);
            }

            \DB::commit();
            
            return $user->load('roles');
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error creating user: ' . $e->getMessage(), [
                'data' => array_except($data, ['password', 'password_confirmation']),
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Update a user
     *
     * @param array $data
     * @param int $userId
     * @return User
     * @throws \Exception
     */
    public function updateUser(array $data, int $userId)
    {
        try {
            \DB::beginTransaction();

            $user = User::findOrFail($userId);

            $userData = [
                'name' => $data['name'],
                'email' => $data['email'],
            ];

            // Only update password if it's provided
            if (!empty($data['password'])) {
                $userData['password'] = Hash::make($data['password']);
            }

            $user->update($userData);

            // Update role if provided
            if (isset($data['role'])) {
                $role = Role::where('name', $data['role'])->firstOrFail();
                $user->syncRoles([$role]);
            }

            \DB::commit();
            
            return $user->load('roles');
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error updating user: ' . $e->getMessage(), [
                'user_id' => $userId,
                'data' => array_except($data, ['password', 'password_confirmation']),
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Delete a user
     *
     * @param int $userId
     * @return bool
     * @throws \Exception
     */
    public function deleteUser(int $userId)
    {
        try {
            \DB::beginTransaction();
            
            $user = User::findOrFail($userId);
            
            // Remove all roles first
            $user->roles()->detach();
            
            $result = $user->delete();
            
            \DB::commit();
            
            return $result;
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('Error deleting user: ' . $e->getMessage(), [
                'user_id' => $userId,
                'exception' => $e
            ]);
            throw $e;
        }
    }

    /**
     * Get user by ID with roles
     *
     * @param int $userId
     * @return User
     */
    public function getUserById(int $userId)
    {
        return User::with('roles')->findOrFail($userId);
    }
} 