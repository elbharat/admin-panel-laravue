<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreUserRequest;

class UserController extends Controller
{
    /**
     * @var UserService
     */
    protected $userService;

    /**
     * UserController constructor.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Users/Index', [
            'users' => $this->userService->getAllUsers(),
            'roles' => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return Inertia::render('Users/Create', [
            'roles' => Role::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {
            // Log raw request data
            Log::info('Raw request data:', [
                'all' => $request->all(),
                'headers' => $request->headers->all(),
                'method' => $request->method(),
                'ajax' => $request->ajax(),
                'wantsJson' => $request->wantsJson(),
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'is_active' => true
            ]);

            $user->assignRole($request->role);

            Log::info('User created successfully', [
                'id' => $user->id,
                'email' => $user->email
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'User berhasil dibuat',
                    'redirect' => route('users.index')
                ]);
            }

            return redirect()
                ->route('users.index')
                ->with('message', 'User berhasil dibuat');

        } catch (\Exception $e) {
            Log::error('Failed to create user:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->except(['password', 'password_confirmation'])
            ]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal membuat user',
                    'errors' => ['general' => $e->getMessage()]
                ], 422);
            }

            return back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->withErrors(['error' => 'Gagal membuat user: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user->load('roles');

        return Inertia::render('Users/Show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $user->load('roles');
        
        return Inertia::render('Users/Edit', [
            'user' => $user,
            'roles' => Role::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            Log::info('Updating user with ID: ' . $user->id, $request->except(['password', 'password_confirmation']));
            
            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
                'role' => ['required', 'string', 'exists:roles,name']
            ];

            // Only validate password if it's provided
            if ($request->filled('password')) {
                $rules['password'] = ['confirmed', Rules\Password::defaults()];
            }

            $validated = $request->validate($rules);
            Log::info('Validated data:', array_diff_key($validated, ['password' => '', 'password_confirmation' => '']));

            $updatedUser = $this->userService->updateUser($validated, $user->id);
            Log::info('User updated with ID: ' . $updatedUser->id);
            
            return redirect()
                ->route('users.index')
                ->with('success', 'Pengguna berhasil diperbarui.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Validation failed when updating user:', [
                'user_id' => $user->id,
                'errors' => $e->errors(),
                'request_data' => $request->except(['password', 'password_confirmation'])
            ]);
            throw $e;
        } catch (\Exception $e) {
            Log::error('Error updating user: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => $user->id,
                'request_data' => $request->except(['password', 'password_confirmation'])
            ]);
            
            return redirect()
                ->back()
                ->withInput($request->except(['password', 'password_confirmation']))
                ->with('error', 'Gagal memperbarui pengguna: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            Log::info('Deleting user with ID: ' . $user->id);
            
            // Prevent deleting yourself
            if (auth()->id() === $user->id) {
                Log::warning('Attempted to delete own account', ['user_id' => $user->id]);
                return redirect()->back()->with('error', 'You cannot delete your own account.');
            }
            
            $this->userService->deleteUser($user->id);
            Log::info('User deleted successfully');
            
            return redirect()->route('users.index')->with('success', 'User deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage(), [
                'exception' => $e,
                'user_id' => $user->id
            ]);
            
            return redirect()->back()->withErrors([
                'error' => 'Error deleting user: ' . $e->getMessage()
            ]);
        }
    }
} 