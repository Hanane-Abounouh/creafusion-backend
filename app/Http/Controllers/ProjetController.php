<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class ProjetController extends Controller
{
    /**
     * Crée un nouveau projet.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'statut' => 'required|in:En cours,Terminé,Annulé',
            'date_limite' => 'required|date|after_or_equal:today',
        ]);

        $projet = Projet::create([
            'nom' => $request->nom,
            'description' => $request->description,
            'proprietaire_id' => Auth::id(),
            'statut' => $request->statut,
            'date_limite' => $request->date_limite,
        ]);

        return response()->json([
            'message' => 'Projet créé avec succès!',
            'projet' => $projet,
        ], 201);
    }

    /**
     * Affiche la liste des projets.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $projets = Projet::where('proprietaire_id', Auth::id())->get();

        return response()->json($projets);
    }

    /**
     * Affiche un projet spécifique.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $projet = Projet::where('proprietaire_id', Auth::id())->findOrFail($id);

        return response()->json($projet);
    }

    /**
     * Met à jour un projet existant.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'statut' => 'required|in:En cours,Terminé,Annulé',
            'date_limite' => 'required|date|after_or_equal:today',
        ]);

        $projet = Projet::where('proprietaire_id', Auth::id())->findOrFail($id);

        $projet->update([
            'nom' => $request->nom,
            'description' => $request->description,
            'statut' => $request->statut,
            'date_limite' => $request->date_limite,
        ]);

        return response()->json([
            'message' => 'Projet mis à jour avec succès!',
            'projet' => $projet,
        ]);
    }

    /**
     * Supprime un projet.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $projet = Projet::where('proprietaire_id', Auth::id())->findOrFail($id);
        $projet->delete();

        return response()->json([
            'message' => 'Projet supprimé avec succès!',
        ]);
    }
}
