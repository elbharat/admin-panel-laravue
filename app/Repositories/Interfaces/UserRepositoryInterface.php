<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface extends RepositoryInterface
{
    /**
     * Get users with roles
     * 
     * @return mixed
     */
    public function getUsersWithRoles();

    /**
     * Assign role to user
     * 
     * @param int $userId
     * @param string $roleName
     * @return mixed
     */
    public function assignRole($userId, $roleName);

    /**
     * Sync roles for user
     * 
     * @param int $userId
     * @param array $roles
     * @return mixed
     */
    public function syncRoles($userId, array $roles);
} 