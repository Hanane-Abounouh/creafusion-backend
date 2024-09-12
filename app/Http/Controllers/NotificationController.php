<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Crée une nouvelle notification.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'utilisateur_id' => 'required|exists:users,id',
            'projet_id' => 'nullable|exists:projets,id',
            'contenu' => 'required|string|max:255',
        ]);

        $notification = Notification::create([
            'utilisateur_id' => $request->utilisateur_id,
            'projet_id' => $request->projet_id,
            'contenu' => $request->contenu,
        ]);

        return response()->json([
            'message' => 'Notification créée avec succès!',
            'notification' => $notification,
        ], 201);
    }

    /**
     * Affiche la liste des notifications de l'utilisateur connecté.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $userId = Auth::id();
        $notifications = Notification::where('utilisateur_id', $userId)->get();

        return response()->json($notifications);
    }

    /**
     * Affiche une notification spécifique.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $notification = Notification::findOrFail($id);

        // Optionnel: Assurez-vous que l'utilisateur connecté est le destinataire de la notification
        if ($notification->utilisateur_id !== Auth::id()) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        return response()->json($notification);
    }

    /**
     * Met à jour une notification spécifique.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'contenu' => 'sometimes|string|max:255',
            'lu' => 'sometimes|boolean',
        ]);

        $notification = Notification::findOrFail($id);

        // Optionnel: Assurez-vous que l'utilisateur connecté est le destinataire de la notification
        if ($notification->utilisateur_id !== Auth::id()) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        $notification->update($request->only(['contenu', 'lu']));

        return response()->json([
            'message' => 'Notification mise à jour avec succès!',
            'notification' => $notification,
        ]);
    }

    /**
     * Supprime une notification spécifique.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);

        // Optionnel: Assurez-vous que l'utilisateur connecté est le destinataire de la notification
        if ($notification->utilisateur_id !== Auth::id()) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        $notification->delete();

        return response()->json([
            'message' => 'Notification supprimée avec succès!',
        ]);
    }
}
