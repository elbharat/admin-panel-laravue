<?php

namespace App\Repositories\Eloquent;

use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Cache;

class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Get users with roles
     * 
     * @return mixed
     */
    public function getUsersWithRoles()
    {
        // Menggunakan cache untuk meningkatkan performa
        return Cache::remember(
            config('cache-keys.users.with_roles'), 
            config('cache-keys.ttl.medium'), 
            function () {
                return $this->model->with('roles')->get();
            }
        );
    }

    /**
     * Assign role to user
     * 
     * @param int $userId
     * @param string $roleName
     * @return mixed
     */
    public function assignRole($userId, $roleName)
    {
        $user = $this->find($userId);
        $result = $user->assignRole($roleName);
        
        // Hapus cache setelah perubahan
        Cache::forget(config('cache-keys.users.with_roles'));
        Cache::forget(config('cache-keys.dashboard.admin_data'));
        
        return $result;
    }

    /**
     * Sync roles for user
     * 
     * @param int $userId
     * @param array $roles
     * @return mixed
     */
    public function syncRoles($userId, array $roles)
    {
        $user = $this->find($userId);
        $result = $user->syncRoles($roles);
        
        // Hapus cache setelah perubahan
        Cache::forget(config('cache-keys.users.with_roles'));
        Cache::forget(config('cache-keys.dashboard.admin_data'));
        
        return $result;
    }
} 