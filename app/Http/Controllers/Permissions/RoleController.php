<?php

namespace App\Http\Controllers\Permissions;

use App\Http\Controllers\Controller;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    protected $permissionService;

    public function __construct(PermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    /**
     * Display the role management page.
     */
    public function index()
    {
        return Inertia::render('Permissions/Roles', [
            'roles' => $this->permissionService->getAllRolesWithPermissions(),
            'permissionGroups' => $this->permissionService->getAllGroupsWithPermissions(),
        ]);
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        return Inertia::render('Permissions/Create', [
            'permissionGroups' => $this->permissionService->getAllGroupsWithPermissions(),
        ]);
    }

    /**
     * Store a new role.
     */
    public function store(Request $request)
    {
        try {
            Log::info('Creating new role with data:', $request->all());
            
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:roles,name',
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            Log::info('Validated data:', $validated);
            
            $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);
            Log::info('Role created with ID: ' . $role->id);

            if (!empty($validated['permissions'])) {
                $this->permissionService->assignPermissionsToRole($role->id, $validated['permissions']);
                Log::info('Permissions assigned to role: ' . implode(', ', $validated['permissions']));
            }

            return redirect()->route('roles.index')->with('success', 'Role created successfully.');
        } catch (\Exception $e) {
            Log::error('Error creating role: ' . $e->getMessage(), [
                'exception' => $e,
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()->withErrors([
                'error' => 'Error creating role: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Show the form for editing a role.
     */
    public function edit($id)
    {
        $role = Role::with('permissions')->findOrFail($id);
        
        return Inertia::render('Permissions/Edit', [
            'role' => $role,
            'permissionGroups' => $this->permissionService->getAllGroupsWithPermissions(),
        ]);
    }

    /**
     * Update a role.
     */
    public function update(Request $request, $id)
    {
        try {
            Log::info('Updating role with ID: ' . $id, $request->all());
            
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:roles,name,' . $id,
                'permissions' => 'nullable|array',
                'permissions.*' => 'exists:permissions,id',
            ]);

            Log::info('Validated data:', $validated);
            
            $role = Role::findOrFail($id);
            
            // Don't allow changing admin role name
            if ($role->name === 'admin' && $validated['name'] !== 'admin') {
                return redirect()->back()->withErrors(['error' => 'Cannot change the admin role name.']);
            }
            
            $role->update(['name' => $validated['name']]);
            Log::info('Role name updated to: ' . $validated['name']);

            if (isset($validated['permissions'])) {
                $this->permissionService->assignPermissionsToRole($role->id, $validated['permissions']);
                Log::info('Permissions updated for role: ' . implode(', ', $validated['permissions']));
            }

            return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
        } catch (\Exception $e) {
            Log::error('Error updating role: ' . $e->getMessage(), [
                'exception' => $e,
                'role_id' => $id,
                'request_data' => $request->all()
            ]);
            
            return redirect()->back()->withErrors([
                'error' => 'Error updating role: ' . $e->getMessage()
            ])->withInput();
        }
    }

    /**
     * Delete a role.
     */
    public function destroy($id)
    {
        try {
            Log::info('Deleting role with ID: ' . $id);
            
            $role = Role::findOrFail($id);
            
            // Don't allow deleting admin role
            if ($role->name === 'admin') {
                return redirect()->back()->withErrors(['error' => 'Cannot delete the admin role.']);
            }
            
            $role->delete();
            Log::info('Role deleted successfully');

            return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting role: ' . $e->getMessage(), [
                'exception' => $e,
                'role_id' => $id
            ]);
            
            return redirect()->back()->withErrors([
                'error' => 'Error deleting role: ' . $e->getMessage()
            ]);
        }
    }
} 