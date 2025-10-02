<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // Récupérer toutes les notifications d’un utilisateur
    public function index($userId)
    {
        $notifications = Notification::where('id_user', $userId)
                                     ->orderBy('dateEnvoi')
                                     ->get();

        return response()->json($notifications);
    }

    // Marquer une notification comme lue
    public function markAsRead($id)
    {
        $notif = Notification::findOrFail($id);
        $notif->update(['lu' => true]);

        return response()->json([
            'message' => 'Notification marquée comme lue',
            'notification' => $notif
        ]);
    }

    // Supprimer une notification
    public function destroy($id)
    {
        $notif = Notification::findOrFail($id);
        $notif->delete();

        return response()->json(['message' => 'Notification supprimée']);
    }
}
