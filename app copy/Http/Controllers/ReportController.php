<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
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

return view('reports.index', compact('stats'));
    }
}
