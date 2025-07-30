<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    /**
     * Listar todas as notificações do usuário autenticado
     */
    public function index()
    {
        $notifications = Auth::user()->notifications()->paginate(10);
        
        return view('notifications.index', compact('notifications'));
    }

    /**
     * Marcar uma notificação como lida
     */
    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        
        if ($notification) {
            $notification->markAsRead();
            
            return response()->json([
                'success' => true,
                'message' => 'Notificação marcada como lida'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Notificação não encontrada'
        ], 404);
    }

    /**
     * Marcar todas as notificações como lidas
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return response()->json([
            'success' => true,
            'message' => 'Todas as notificações foram marcadas como lidas'
        ]);
    }

    /**
     * Buscar notificações não lidas (para AJAX)
     */
    public function getUnreadNotifications()
    {
        $notifications = Auth::user()->unreadNotifications()->limit(5)->get();
        $unreadCount = Auth::user()->unreadNotifications()->count();
        
        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $unreadCount
        ]);
    }

    /**
     * Deletar uma notificação
     */
    public function destroy($id)
    {
        $notification = Auth::user()->notifications()->where('id', $id)->first();
        
        if ($notification) {
            $notification->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Notificação removida'
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Notificação não encontrada'
        ], 404);
    }
}
