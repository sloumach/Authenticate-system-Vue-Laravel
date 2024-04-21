<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Envoyer l'email de confirmation
        Mail::to($user->email)->send(new VerificationMail($user));

        return response()->json([
            'status' => 'success',
            'message' => 'Registration successful, please check your email to verify your account.'
        ], 201);
    }

    public function verifyEmail($id)
    {
        $user = User::findOrFail($id);
        $user->email_verified_at = now();
        $user->save();

        return response()->json(['message' => 'Email successfully verified!']);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!auth()->attempt($request->only('email', 'password'))) {
            return response()->json([
                'status' => 'error',
                'message' => 'Credentials not match our records.'
            ], 401);
        }

        $user = auth()->user();
        $token = $user->createToken('auth_token')->plainTextToken; // Génération du token
        $imageUrl = $user->image ? url('images/' . $user->image) : null;
        return response()->json([
            'status' => 'success',
            'message' => 'Logged in successfully.',
            'access_token' => $token, // Retour du token
            'image' => $imageUrl,
            'data' => $user
        ], 200);
    }

    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = auth()->user(); // ou User::find($request->user_id); si vous n'utilisez pas d'authentification

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        $user->image = $imageName;
        $user->save();

        return response()->json(['message' => 'Image uploaded successfully', 'image' => $imageName]);
    }
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();  // Révoquez tous les tokens de l'utilisateur
        return response()->json(['message' => 'Logged out successfully']);
    }




}
