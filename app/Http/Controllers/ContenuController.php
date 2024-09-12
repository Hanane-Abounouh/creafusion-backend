<?php

namespace App\Http\Controllers;

use App\Models\Contenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContenuController extends Controller
{
    /**
     * Crée un nouveau contenu.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'projet_id' => 'required|exists:projets,id',
            'nom_fichier' => 'required|string|max:255',
            'chemin_fichier' => 'required|file|mimes:jpg,png,pdf,docx', // Vous pouvez ajouter d'autres types de fichiers ici
            'uploadé_par' => 'required|exists:users,id',
        ]);

        // Stocker le fichier
        $path = $request->file('chemin_fichier')->store('contenus');

        // Créer le contenu
        $contenu = Contenu::create([
            'projet_id' => $request->projet_id,
            'nom_fichier' => $request->nom_fichier,
            'chemin_fichier' => $path,
            'uploadé_par' => $request->uploadé_par,
        ]);

        return response()->json([
            'message' => 'Contenu créé avec succès!',
            'contenu' => $contenu,
        ], 201);
    }

    /**
     * Affiche la liste des contenus pour un projet donné.
     *
     * @param int $projet_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($projet_id)
    {
        $contenus = Contenu::where('projet_id', $projet_id)->get();

        return response()->json($contenus);
    }

    /**
     * Affiche un contenu spécifique.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $contenu = Contenu::findOrFail($id);

        return response()->json($contenu);
    }

    /**
     * Met à jour un contenu existant.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'projet_id' => 'required|exists:projets,id',
            'nom_fichier' => 'required|string|max:255',
            'chemin_fichier' => 'nullable|file|mimes:jpg,png,pdf,docx',
            'uploadé_par' => 'required|exists:users,id',
        ]);

        $contenu = Contenu::findOrFail($id);

        // Mise à jour du fichier si un nouveau fichier est fourni
        if ($request->hasFile('chemin_fichier')) {
            // Supprimer l'ancien fichier
            Storage::delete($contenu->chemin_fichier);

            // Stocker le nouveau fichier
            $path = $request->file('chemin_fichier')->store('contenus');
            $contenu->chemin_fichier = $path;
        }

        $contenu->update([
            'projet_id' => $request->projet_id,
            'nom_fichier' => $request->nom_fichier,
            'uploadé_par' => $request->uploadé_par,
        ]);

        return response()->json([
            'message' => 'Contenu mis à jour avec succès!',
            'contenu' => $contenu,
        ]);
    }

    /**
     * Supprime un contenu.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $contenu = Contenu::findOrFail($id);

        // Supprimer le fichier du stockage
        Storage::delete($contenu->chemin_fichier);

        $contenu->delete();

        return response()->json([
            'message' => 'Contenu supprimé avec succès!',
        ]);
    }
}
