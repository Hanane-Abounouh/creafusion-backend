<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TacheController extends Controller
{
    /**
     * Crée une nouvelle tâche.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'projet_id' => 'required|exists:projets,id',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'statut' => 'required|in:À faire,En cours,Fait',
            'assigné_a' => 'required|exists:users,id',
            'date_limite' => 'required|date',
        ]);

        $tache = Tache::create([
            'projet_id' => $request->projet_id,
            'titre' => $request->titre,
            'description' => $request->description,
            'statut' => $request->statut,
            'assigné_a' => $request->assigné_a,
            'date_limite' => $request->date_limite,
        ]);

        return response()->json([
            'message' => 'Tâche créée avec succès!',
            'tache' => $tache,
        ], 201);
    }

    /**
     * Affiche la liste des tâches pour un projet donné.
     *
     * @param int $projet_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($projet_id)
    {
        $taches = Tache::where('projet_id', $projet_id)->get();

        return response()->json($taches);
    }

    /**
     * Affiche une tâche spécifique.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $tache = Tache::findOrFail($id);

        return response()->json($tache);
    }

    /**
     * Met à jour une tâche existante.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'projet_id' => 'required|exists:projets,id',
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'statut' => 'required|in:À faire,En cours,Fait',
            'assigné_a' => 'required|exists:users,id',
            'date_limite' => 'required|date',
        ]);

        $tache = Tache::findOrFail($id);

        $tache->update([
            'projet_id' => $request->projet_id,
            'titre' => $request->titre,
            'description' => $request->description,
            'statut' => $request->statut,
            'assigné_a' => $request->assigné_a,
            'date_limite' => $request->date_limite,
        ]);

        return response()->json([
            'message' => 'Tâche mise à jour avec succès!',
            'tache' => $tache,
        ]);
    }

    /**
     * Supprime une tâche.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $tache = Tache::findOrFail($id);
        $tache->delete();

        return response()->json([
            'message' => 'Tâche supprimée avec succès!',
        ]);
    }
}
