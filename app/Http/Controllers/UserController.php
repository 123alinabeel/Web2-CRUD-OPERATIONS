<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function getUserById($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user, 200);
    }

    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:8',
            'first_name' => 'required|string|min:3',
            'last_name'  => 'required|string|min:3'
        ]);

        $user = User::create([
            'email'      => $validated['email'],
            'password'   => Hash::make($validated['password']),
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name']
        ]);

        return response()->json($user, 201);
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'email'      => 'sometimes|email|unique:users,email,' . $user->id,
            'password'   => 'sometimes|string|min:8',
            'first_name' => 'sometimes|string|min:3',
            'last_name'  => 'sometimes|string|min:3'
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return response()->json($user, 200);
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.'], 204);
    }
}
