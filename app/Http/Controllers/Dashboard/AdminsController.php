<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminsController extends Controller
{

    // public function __construct()
    // {
    //     $this->authorizeResource(Admin::class, 'admin');    
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('admins.view');
        $request = request();
        $admins = Admin::with(['store'])
            ->filter($request->query())
            ->paginate();
        return view('dashboard.admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Admin $admin)
    {
        Gate::authorize('admins.create');
        return view('dashboard.admins.create', [
            'roles' => Role::all(),
            'admin' => new Admin(),
            'admin_roles' => $admin->roles()->pluck('id')->toArray(),
            'pass' => 'pass'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Gate::authorize('admins.create');
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
            'store_id' => ['nullable', 'int', 'exists:stores,id'],
            'name' => ['required', 'string', 'max:32', 'unique:admins,name'],
            'phone_number' => 'required|min:9|numeric|unique:admins,phone_number',
            'status' => 'in:active,inactive',
            'password' => ['nullable', 'min:9'],
            'roles' => 'array',
        ]);

        $admin = Admin::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'store_id' => $request['store_id'],
            'name' => $request['name'],
            'status' => $request['status'],
            'phone_number' => $request['phone_number'],
            'password' => Hash::make($request['password']),
        ]);

        $admin->roles()->attach($request->roles);

        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin created successfully');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        Gate::authorize('admins.update');
        $roles = Role::all();
        $admin_roles = $admin->roles()->pluck('id')->toArray();

        return view('dashboard.admins.edit', compact('admin', 'roles', 'admin_roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Admin $admin)
    {
        Gate::authorize('admins.update');
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => ['nullable', 'string', 'email', 'max:255', Rule::unique('admins', 'email')->ignore($admin)],
            'name' => ['nullable', 'string', 'max:32', Rule::unique('admins', 'name')->ignore($admin)],
            'phone_number' => 'nullable|min:9|numeric',
            'status' => 'in:active,inactive',
            'store_id' => ['nullable', 'int', 'exists:stores,id'],
            'password' => ['nullable', 'min:9'],
            'roles' => 'array',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $admin->update($validated);
        $admin->roles()->sync($request->roles);

        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Gate::authorize('admins.delete');
        Admin::destroy($id);
        return redirect()
            ->route('dashboard.admins.index')
            ->with('success', 'Admin deleted successfully');
    }
}
