<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_tickets' => Ticket::count(),
            'abertos' => Ticket::where('status', 'open')->count(),
            'pendentes' => Ticket::where('status', 'in_progress')->count(),
            'resolvidos' => Ticket::where('status', 'closed')->count(),
            'sem_responsavel' => Ticket::whereNull('assigned_to')->count()
        ];

        $chartLabels = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        $chartData = [
            'abertos' => Ticket::where('status', 'open')->selectRaw('MONTH(created_at) as month, COUNT(*) as total')->groupBy('month')->pluck('total')->toArray(),
            'pendentes' => Ticket::where('status', 'in_progress')->selectRaw('MONTH(created_at) as month, COUNT(*) as total')->groupBy('month')->pluck('total')->toArray(),
            'fechados' => Ticket::where('status', 'closed')->selectRaw('MONTH(created_at) as month, COUNT(*) as total')->groupBy('month')->pluck('total')->toArray(),
            'totais' => Ticket::selectRaw('MONTH(created_at) as month, COUNT(*) as total')->groupBy('month')->pluck('total')->toArray(),
        ];

        $assignedUsers = User::selectRaw('users.id, users.name, COUNT(tickets.id) as assigned_tickets_count')
            ->join('tickets', 'users.id', '=', 'tickets.assigned_to')
            ->whereNotNull('tickets.assigned_to')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('assigned_tickets_count')
            ->take(10)
            ->get();

        return view('dashboard.index', compact('stats', 'chartLabels', 'chartData', 'assignedUsers'));
    }
}
