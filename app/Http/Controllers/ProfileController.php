<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Crée un nouveau profil.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lien_reseau_social' => 'nullable|url',
        ]);

        $user = Auth::user();
        $photoPath = null;

        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profiles', 'public');
        }

        $profile = Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'description' => $request->description,
                'photo' => $photoPath,
                'lien_reseau_social' => $request->lien_reseau_social,
            ]
        );

        return response()->json([
            'message' => 'Profil créé ou mis à jour avec succès!',
            'profile' => $profile,
        ], 201);
    }

    /**
     * Affiche le profil de l'utilisateur connecté.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        if (!$profile) {
            return response()->json(['message' => 'Profil non trouvé'], 404);
        }

        return response()->json($profile);
    }

    /**
     * Met à jour le profil de l'utilisateur connecté.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string|max:500',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'lien_reseau_social' => 'nullable|url',
        ]);

        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        if (!$profile) {
            return response()->json(['message' => 'Profil non trouvé'], 404);
        }

        $photoPath = $profile->photo;

        if ($request->hasFile('photo')) {
            // Supprimer l'ancienne photo si elle existe
            if ($photoPath && Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }
            $photoPath = $request->file('photo')->store('profiles', 'public');
        }

        $profile->update([
            'description' => $request->description,
            'photo' => $photoPath,
            'lien_reseau_social' => $request->lien_reseau_social,
        ]);

        return response()->json([
            'message' => 'Profil mis à jour avec succès!',
            'profile' => $profile,
        ]);
    }

    /**
     * Supprime le profil de l'utilisateur connecté.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();

        if (!$profile) {
            return response()->json(['message' => 'Profil non trouvé'], 404);
        }

        // Supprimer la photo si elle existe
        if ($profile->photo && Storage::disk('public')->exists($profile->photo)) {
            Storage::disk('public')->delete($profile->photo);
        }

        $profile->delete();

        return response()->json([
            'message' => 'Profil supprimé avec succès!',
        ]);
    }
}
