<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * UserService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     */
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Get all users with roles
     *
     * @return mixed
     */
    public function getAllUsers()
    {
        return $this->userRepository->getUsersWithRoles();
    }

    /**
     * Create a new user
     *
     * @param array $data
     * @return mixed
     * @throws ValidationException
     */
    public function createUser(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|exists:roles,name'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ];

        $user = $this->userRepository->create($userData);
        $this->userRepository->assignRole($user->id, $data['role']);

        return $user;
    }

    /**
     * Update user
     *
     * @param array $data
     * @param int $userId
     * @return mixed
     * @throws ValidationException
     */
    public function updateUser(array $data, $userId)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $userId,
            'role' => 'required|exists:roles,name'
        ]);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];

        $this->userRepository->update($userData, $userId);
        $this->userRepository->syncRoles($userId, [$data['role']]);

        return $this->userRepository->find($userId);
    }

    /**
     * Delete user
     *
     * @param int $userId
     * @return bool
     */
    public function deleteUser($userId)
    {
        return $this->userRepository->delete($userId);
    }

    /**
     * Find user by ID
     *
     * @param int $userId
     * @return mixed
     */
    public function findUser($userId)
    {
        return $this->userRepository->find($userId);
    }
} 