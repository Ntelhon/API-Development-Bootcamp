<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request) {
        $validate = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => $validate['password']
        ]);

        return response()->json($user);
    }

    public function login(Request $request) {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $validate['email'])->first();

        if (!$user || !Hash::check($validate['password'], $user->password)) {
            return response()->json(['message' => 'Invalid credentials']);
        }

        $token = $user->createToken('token')->plainTextToken;

        return response()->json($token);
    }

    public function showUser(Request $request) {
        return response()->json($request->user());
    }
}
