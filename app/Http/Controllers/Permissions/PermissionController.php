<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use App\Models\PermissionGroup;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Display the permission management page.
     */
    public function index()
    {
        return Inertia::render('Permissions/Index', [
            'permissionGroups' => $this->permissionService->getAllGroupsWithPermissions(),
            'roles' => $this->permissionService->getAllRolesWithPermissions(),
        ]);
    }

    /**
     * Show the form for creating a new permission group.
     */
    public function createGroup()
    {
        return Inertia::render('Permissions/CreateGroup');
    }

    /**
     * Store a new permission group.
     */
    public function storeGroup(Request $request)
    {
        try {
            Log::info('Creating new permission group with data:', $request->all());
            
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:permission_groups,name',
                'display_name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            Log::info('Validated data:', $validated);
            
            $group = $this->permissionService->createPermissionGroup($validated);
            Log::info('Permission group created with ID: ' . $group->id);

            return redirect()->route('permissions.index')->with('success', 'Permission group created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating permission group: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()->withErrors([
                'error' => 'Error creating permission group: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Show the form for editing a permission group.
     */
    public function editGroup($id)
    {
        $group = PermissionGroup::findOrFail($id);
        
        return Inertia::render('Permissions/EditGroup', [
            'group' => $group,
        ]);
    }

    /**
     * Update a permission group.
     */
    public function updateGroup(Request $request, $id)
    {
        try {
            Log::info('Updating permission group with ID: ' . $id, $request->all());
            
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:permission_groups,name,' . $id,
                'display_name' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            Log::info('Validated data:', $validated);
            
            $group = $this->permissionService->updatePermissionGroup($id, $validated);
            Log::info('Permission group updated with ID: ' . $group->id);

            return redirect()->route('permissions.index')->with('success', 'Permission group updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating permission group: ' . $e->getMessage(), [
                'exception' => $e,
                'group_id' => $id,
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()->withErrors([
                'error' => 'Error updating permission group: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Delete a permission group.
     */
    public function destroyGroup($id)
    {
        try {
            Log::info('Deleting permission group with ID: ' . $id);
            
            $result = $this->permissionService->deletePermissionGroup($id);
            Log::info('Permission group deleted successfully');

            return redirect()->route('permissions.index')->with('success', 'Permission group deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting permission group: ' . $e->getMessage(), [
                'exception' => $e,
                'group_id' => $id
            ]);
            
            return redirect()->back()->withErrors([
                'error' => 'Error deleting permission group: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show the form for creating a new permission.
     */
    public function createPermission(Request $request)
    {
        return Inertia::render('Permissions/CreatePermission', [
            'groups' => $this->permissionService->getAllGroupsWithPermissions(),
            'groupId' => $request->input('group_id'),
        ]);
    }

    /**
     * Store a new permission.
     */
    public function storePermission(Request $request)
    {
        try {
            Log::info('Creating new permission with data:', $request->all());
            
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:permissions,name',
                'display_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'group_id' => 'nullable|exists:permission_groups,id',
            ]);

            Log::info('Validated data:', $validated);
            
            $permission = $this->permissionService->createPermission($validated);
            Log::info('Permission created with ID: ' . $permission->id);

            return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating permission: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()->withErrors([
                'error' => 'Error creating permission: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Show the form for editing a permission.
     */
    public function editPermission($id)
    {
        $permission = Permission::findOrFail($id);
        
        return Inertia::render('Permissions/EditPermission', [
            'permission' => $permission,
            'groups' => $this->permissionService->getAllGroupsWithPermissions(),
        ]);
    }

    /**
     * Update a permission.
     */
    public function updatePermission(Request $request, $id)
    {
        try {
            Log::info('Updating permission with ID: ' . $id, $request->all());
            
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:permissions,name,' . $id,
                'display_name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'group_id' => 'nullable|exists:permission_groups,id',
            ]);

            Log::info('Validated data:', $validated);
            
            $permission = $this->permissionService->updatePermission($id, $validated);
            Log::info('Permission updated with ID: ' . $permission->id);

            return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating permission: ' . $e->getMessage(), [
                'exception' => $e,
                'permission_id' => $id,
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()->withErrors([
                'error' => 'Error updating permission: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Delete a permission.
     */
    public function destroyPermission($id)
    {
        try {
            Log::info('Deleting permission with ID: ' . $id);
            
            $result = $this->permissionService->deletePermission($id);
            Log::info('Permission deleted successfully');

            return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting permission: ' . $e->getMessage(), [
                'exception' => $e,
                'permission_id' => $id
            ]);
            
            return redirect()->back()->withErrors([
                'error' => 'Error deleting permission: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Assign permissions to a role.
     */
    public function assignPermissions(Request $request, $roleId)
    {
        try {
            Log::info('Assigning permissions to role with ID: ' . $roleId, $request->all());
            
            $validated = $request->validate([
                'permissions' => 'required|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            Log::info('Validated data:', $validated);
            
            $role = $this->permissionService->assignPermissionsToRole($roleId, $validated['permissions']);
            Log::info('Permissions assigned to role with ID: ' . $role->id);

            return redirect()->route('roles.index')->with('success', 'Permissions assigned successfully.');
        } catch (\Exception $e) {
            Log::error('Error assigning permissions to role: ' . $e->getMessage(), [
                'exception' => $e,
                'role_id' => $roleId,
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()->withErrors([
                'error' => 'Error assigning permissions to role: ' . $e->getMessage()
            ])->withInput();
        }
    }
} 