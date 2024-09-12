<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Enregistre un nouvel utilisateur et lui assigne un rôle par défaut.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crée un nouvel utilisateur avec un rôle par défaut
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => 2, // Assigne un rôle par défaut (2 pour 'user')
        ]);

        // Crée un token pour l'utilisateur
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        return response()->json([
            'message' => 'Utilisateur créé avec succès!',
            'user' => $user,
            'token' => $token,
        ], 201);
    }

    /**
     * Authentifie un utilisateur et retourne un token d'accès.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Les informations d\'identification sont incorrectes.',
            ], 401);
        }

        $user = Auth::user();
        $token = $user->createToken('Personal Access Token')->plainTextToken;

        // Récupère le rôle de l'utilisateur
        $role = $user->role;

        return response()->json([
            'message' => 'Connexion réussie!',
            'user' => [
                'email' => $user->email,
                'role' => [
                    'id' => $role ? $role->id : null,
                    'name' => $role ? $role->name : 'user', // Défaut à 'user' si le rôle n'est pas trouvé
                ],
            ],
            'token' => $token,
        ]);
    }

    /**
     * Déconnecte l'utilisateur authentifié et révoque ses tokens.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();

        return response()->json([
            'message' => 'Déconnexion réussie!',
        ]);
    }
}
