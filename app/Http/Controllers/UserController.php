<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::when($request->role, function (Builder $query, string $role_value) {
            $role = Role::where('id', $role_value)->orWhere('name', $role_value)->get();
            if ($role) {
                $query->role($role)->with('roles');
            } elseif (Str::lower($role) == 'all') {
                $query->with('roles');
            }
        })
        ->with('roles')
        ->get();
        return response()->json([
            'result' => $users,
            'msg' => __('success'),
            'status' => 200,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            if ($request->password) {
                $password = $request->password;
            } else {
                $password = Setting::where('setting_name', 'default password')->value('setting_value') || 'user@123';
            }
            $request->merge([
                'password' => Hash::make($password),
            ]);
            $user = User::create($request->all());
            if ($user && $user->assignRole($request->role)) {
                $result = $user;
                $msg = __('success.add');
                $status = 200;
            } else {
                $result = null;
                $msg = __('failure.add');
                $status = 500;
            }
            return response()->json([
                'result' => $result,
                'msg' => $msg,
                'status' => $status,
            ], $status);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, User $user)
    {
        $request->whenHas('role', function (string $role_value) use($user) {
            $user->load('roles');
        });
        return response()->json([
            'result' => $user,
            'msg' => __('success'),
            'status' => 200,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            $request->whenFilled('password', function (string $password) use(&$request) {
                $request->merge([
                    'password' => Hash::make($password),
                ]);
            });
            if ($user->update($request->all()) && $user->syncRoles($request->role)) {
                $result = $user;
                $msg = __('success.update');
                $status = 200;
            } else {
                $result = null;
                $msg = __('failure.update');
                $status = 500;
            }
            return response()->json([
                'result' => $result,
                'msg' => $msg,
                'status' => $status,
            ], $status);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            if ($user->delete()) {
                $result = $user;
                $msg = __('success.delete');
                $status = 200;
            } else {
                $result = null;
                $msg = __('failure.delete');
                $status = 500;
            }
            return response()->json([
                'result' => $result,
                'msg' => $msg,
                'status' => $status,
            ], $status);
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
