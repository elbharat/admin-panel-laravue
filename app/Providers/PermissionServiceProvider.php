<?php

namespace App\Providers;

use App\Services\PermissionService;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Only register permissions if the tables exist
        if (Schema::hasTable('permissions') && Schema::hasTable('permission_groups')) {
            $this->registerUserPermissions();
        }
    }

    /**
     * Register user management permissions.
     */
    protected function registerUserPermissions(): void
    {
        $permissionService = app(PermissionService::class);

        // Register User Management permissions
        $permissionService->registerFeature('User Management', [
            [
                'name' => 'view users',
                'display_name' => 'View Users',
                'description' => 'Can view users list',
            ],
            [
                'name' => 'create users',
                'display_name' => 'Create Users',
                'description' => 'Can create new users',
            ],
            [
                'name' => 'edit users',
                'display_name' => 'Edit Users',
                'description' => 'Can edit existing users',
            ],
            [
                'name' => 'delete users',
                'display_name' => 'Delete Users',
                'description' => 'Can delete users',
            ],
            [
                'name' => 'manage users',
                'display_name' => 'Manage Users',
                'description' => 'Can manage all aspects of users',
            ],
        ]);

        // Register Role & Permission Management permissions
        $permissionService->registerFeature('Role & Permission Management', [
            [
                'name' => 'view roles',
                'display_name' => 'View Roles',
                'description' => 'Can view roles list',
            ],
            [
                'name' => 'create roles',
                'display_name' => 'Create Roles',
                'description' => 'Can create new roles',
            ],
            [
                'name' => 'edit roles',
                'display_name' => 'Edit Roles',
                'description' => 'Can edit existing roles',
            ],
            [
                'name' => 'delete roles',
                'display_name' => 'Delete Roles',
                'description' => 'Can delete roles',
            ],
            [
                'name' => 'assign permissions',
                'display_name' => 'Assign Permissions',
                'description' => 'Can assign permissions to roles',
            ],
            [
                'name' => 'manage permissions',
                'display_name' => 'Manage Permissions',
                'description' => 'Can manage all aspects of permissions',
            ],
        ]);

        // Register Nama Fitur Baru permissions
        $permissionService->registerFeature('Nama Fitur Baru', [
            [
                'name' => 'nama_permission',
                'display_name' => 'Nama Tampilan Permission',
                'description' => 'Deskripsi permission',
            ],
            // Tambahkan permission lain untuk fitur ini
        ]);
    }
} 