<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Crée un nouveau message.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'contenu' => 'required|string|max:255',
            'destinataire_id' => 'required|exists:users,id',
            'date_envoi' => 'required|date',
        ]);

        $message = Message::create([
            'contenu' => $request->contenu,
            'auteur_id' => Auth::id(), // Utilisateur connecté comme auteur
            'destinataire_id' => $request->destinataire_id,
            'date_envoi' => $request->date_envoi,
        ]);

        return response()->json([
            'message' => 'Message envoyé avec succès!',
            'message_data' => $message,
        ], 201);
    }

    /**
     * Affiche la liste des messages envoyés et reçus par l'utilisateur connecté.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $userId = Auth::id();
        $messages = Message::where('auteur_id', $userId)
                            ->orWhere('destinataire_id', $userId)
                            ->get();

        return response()->json($messages);
    }

    /**
     * Affiche un message spécifique.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $message = Message::findOrFail($id);

        // Optionnel: Assurez-vous que l'utilisateur connecté est l'auteur ou le destinataire du message
        if ($message->auteur_id !== Auth::id() && $message->destinataire_id !== Auth::id()) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        return response()->json($message);
    }

    /**
     * Met à jour un message spécifique.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'contenu' => 'required|string|max:255',
        ]);

        $message = Message::findOrFail($id);

        // Optionnel: Assurez-vous que l'utilisateur connecté est l'auteur du message
        if ($message->auteur_id !== Auth::id()) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        $message->update([
            'contenu' => $request->contenu,
        ]);

        return response()->json([
            'message' => 'Message mis à jour avec succès!',
            'message_data' => $message,
        ]);
    }

    /**
     * Supprime un message spécifique.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        // Optionnel: Assurez-vous que l'utilisateur connecté est l'auteur du message
        if ($message->auteur_id !== Auth::id()) {
            return response()->json(['message' => 'Accès non autorisé'], 403);
        }

        $message->delete();

        return response()->json([
            'message' => 'Message supprimé avec succès!',
        ]);
    }
}
