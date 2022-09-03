<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        if (Gate::denies('create-user')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->only('name', 'email', 'password', 'role', 'password_confirmation'), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:Basic,Manager,Admin']
        ]);
        if ($validator->fails()) {
            return response()->json(['Errors' => $validator->errors()], 403);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);
        event(new Registered($user));

        return response()->noContent();
    }
    public function deleteUser($id)
    {
        if (Gate::denies('create-user')) {
            abort(403, 'Unauthorized action.');
        }
        $user = User::findOrFail($id);
        $user->delete;
        return response()->noContent();
    }
}
