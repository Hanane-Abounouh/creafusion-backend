<?php

namespace App\Http\Controllers;

use App\Models\Collaboration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollaborationController extends Controller
{
    /**
     * Crée une nouvelle collaboration.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'projet_id' => 'required|exists:projets,id',
            'utilisateur_id' => 'required|exists:users,id',
            'role_dans_projet' => 'required|string|max:255',
        ]);

        $collaboration = Collaboration::create([
            'projet_id' => $request->projet_id,
            'utilisateur_id' => $request->utilisateur_id,
            'role_dans_projet' => $request->role_dans_projet,
        ]);

        return response()->json([
            'message' => 'Collaboration créée avec succès!',
            'collaboration' => $collaboration,
        ], 201);
    }

    /**
     * Affiche la liste des collaborations pour un projet donné.
     *
     * @param int $projet_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($projet_id)
    {
        $collaborations = Collaboration::where('projet_id', $projet_id)->get();

        return response()->json($collaborations);
    }

    /**
     * Affiche une collaboration spécifique.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $collaboration = Collaboration::findOrFail($id);

        return response()->json($collaboration);
    }

    /**
     * Met à jour une collaboration existante.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'projet_id' => 'required|exists:projets,id',
            'utilisateur_id' => 'required|exists:users,id',
            'role_dans_projet' => 'required|string|max:255',
        ]);

        $collaboration = Collaboration::findOrFail($id);

        $collaboration->update([
            'projet_id' => $request->projet_id,
            'utilisateur_id' => $request->utilisateur_id,
            'role_dans_projet' => $request->role_dans_projet,
        ]);

        return response()->json([
            'message' => 'Collaboration mise à jour avec succès!',
            'collaboration' => $collaboration,
        ]);
    }

    /**
     * Supprime une collaboration.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $collaboration = Collaboration::findOrFail($id);
        $collaboration->delete();

        return response()->json([
            'message' => 'Collaboration supprimée avec succès!',
        ]);
    }
}
