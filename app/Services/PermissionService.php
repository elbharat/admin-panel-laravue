<?php

namespace App\Services;

use App\Models\PermissionGroup;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionService
{
    /**
     * Get all permission groups with permissions
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllGroupsWithPermissions()
    {
        return Cache::remember('permission.groups.with.permissions', 60, function () {
            // Ambil semua grup permission dengan relasi permissions
            $groups = PermissionGroup::with('permissions')->get();
            
            // Ambil semua permission yang tidak memiliki grup (group_id = null)
            $ungroupedPermissions = Permission::whereNull('group_id')->get();
            
            // Buat grup virtual untuk permission yang tidak memiliki grup
            if ($ungroupedPermissions->isNotEmpty()) {
                $virtualGroup = new PermissionGroup();
                $virtualGroup->id = null;
                $virtualGroup->name = 'ungrouped';
                $virtualGroup->display_name = 'Ungrouped Permissions';
                $virtualGroup->permissions = $ungroupedPermissions;
                
                // Tambahkan grup virtual ke koleksi grup
                $groups->push($virtualGroup);
            }
            
            return $groups;
        });
    }

    /**
     * Get all roles with permissions
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllRolesWithPermissions()
    {
        return Cache::remember('roles.with.permissions', 60, function () {
            return Role::with('permissions')->get();
        });
    }

    /**
     * Create a new permission group
     *
     * @param array $data
     * @return PermissionGroup
     */
    public function createPermissionGroup(array $data)
    {
        $group = PermissionGroup::create([
            'name' => $data['name'],
            'display_name' => $data['display_name'],
            'description' => $data['description'] ?? null,
        ]);

        $this->clearPermissionCache();

        return $group;
    }

    /**
     * Update a permission group
     *
     * @param int $id
     * @param array $data
     * @return PermissionGroup
     */
    public function updatePermissionGroup(int $id, array $data)
    {
        $group = PermissionGroup::findOrFail($id);
        
        $group->update([
            'name' => $data['name'],
            'display_name' => $data['display_name'],
            'description' => $data['description'] ?? null,
        ]);

        $this->clearPermissionCache();

        return $group;
    }

    /**
     * Delete a permission group
     *
     * @param int $id
     * @return bool
     */
    public function deletePermissionGroup(int $id)
    {
        $group = PermissionGroup::findOrFail($id);
        
        // Set group_id to null for all permissions in this group
        $group->permissions()->update(['group_id' => null]);
        
        $result = $group->delete();
        
        $this->clearPermissionCache();
        
        return $result;
    }

    /**
     * Create a new permission
     *
     * @param array $data
     * @return Permission
     */
    public function createPermission(array $data)
    {
        $permission = Permission::create([
            'name' => $data['name'],
            'display_name' => $data['display_name'] ?? $data['name'],
            'description' => $data['description'] ?? null,
            'group_id' => $data['group_id'] ?? null,
            'guard_name' => $data['guard_name'] ?? 'web',
        ]);

        $this->clearPermissionCache();

        return $permission;
    }

    /**
     * Update a permission
     *
     * @param int $id
     * @param array $data
     * @return Permission
     */
    public function updatePermission(int $id, array $data)
    {
        $permission = Permission::findOrFail($id);
        
        $permission->update([
            'name' => $data['name'],
            'display_name' => $data['display_name'] ?? $data['name'],
            'description' => $data['description'] ?? null,
            'group_id' => $data['group_id'] ?? null,
        ]);

        $this->clearPermissionCache();

        return $permission;
    }

    /**
     * Delete a permission
     *
     * @param int $id
     * @return bool
     */
    public function deletePermission(int $id)
    {
        $permission = Permission::findOrFail($id);
        $result = $permission->delete();
        
        $this->clearPermissionCache();
        
        return $result;
    }

    /**
     * Assign permissions to a role
     *
     * @param int $roleId
     * @param array $permissionIds
     * @return Role
     */
    public function assignPermissionsToRole(int $roleId, array $permissionIds)
    {
        $role = Role::findOrFail($roleId);
        $permissions = Permission::whereIn('id', $permissionIds)->get();
        
        $role->syncPermissions($permissions);
        
        $this->clearPermissionCache();
        
        return $role->load('permissions');
    }

    /**
     * Register a new feature with permissions
     *
     * @param string $featureName
     * @param array $permissions
     * @return PermissionGroup
     */
    public function registerFeature(string $featureName, array $permissions)
    {
        // Create or find the permission group
        $group = PermissionGroup::firstOrCreate(
            ['name' => strtolower(str_replace(' ', '_', $featureName))],
            [
                'display_name' => $featureName,
                'description' => "Permissions for {$featureName} feature",
            ]
        );

        // Create permissions for the feature
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                [
                    'display_name' => $permission['display_name'] ?? $permission['name'],
                    'description' => $permission['description'] ?? null,
                    'group_id' => $group->id,
                    'guard_name' => $permission['guard_name'] ?? 'web',
                ]
            );
        }

        $this->clearPermissionCache();

        return $group->load('permissions');
    }

    /**
     * Clear permission related cache
     */
    private function clearPermissionCache()
    {
        Cache::forget('permission.groups.with.permissions');
        Cache::forget('roles.with.permissions');
        Cache::forget('users.with_roles');
    }
} 