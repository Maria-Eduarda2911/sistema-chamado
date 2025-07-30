<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Category;
use App\Models\User;
use App\Events\TicketCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Priority;


class TicketController extends Controller
{
    public function index(Request $request)
{
    $query = Ticket::query()->with('assignedUser'); // Carregar relacionamento

    // Filtros
    if ($request->has('id') && $request->id != '') {
        $query->where('id', $request->id);
    }

    if ($request->has('category_id') && $request->category_id != '') {
        $query->where('category_id', $request->category_id);
    }

    if ($request->has('priority') && $request->priority != '') {
        $query->where('priority', $request->priority);
    }

    if ($request->has('assigned_to') && $request->assigned_to != '') {
        $query->where('assigned_to', $request->assigned_to);
    }

    $tickets = $query->orderBy('created_at', 'desc')->paginate(10);
    $users = User::all();
    $categories = Category::all();
    $priorities = Ticket::select('priority')->distinct()->get();

    return view('tickets.index', compact('tickets', 'users', 'categories', 'priorities'));
}

    public function create()
    {
        $users = User::all();
        $categories = Category::all();
        return view('tickets.create', compact('users', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'priority' => 'required|string',
            'description' => 'required|string',
            'assigned_to' => 'nullable|exists:users,id', // Permitir NULL ou um usuário válido
        ]);

        $ticket = Ticket::create([
            'user_id' => $request->user_id,
            'category_id' => $request->category_id,
            'title' => $request->title,
            'priority' => $request->priority,
            'description' => $request->description,
            'status' => 'open',
        ]);

        // Disparar evento para notificar técnicos
        $creator = User::find($request->user_id);
        event(new TicketCreated($ticket, $creator));

        return redirect()->route('tickets.index')->with('success', 'Chamado criado com sucesso!');
    }



    public function edit(Ticket $ticket)
    {
        $categories = Category::all();
        $users = User::all();

        return view('tickets.edit', compact('ticket', 'categories', 'users'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'priority' => 'required|string',
            'description' => 'required|string',
            'assigned_to' => 'nullable|exists:users,id', // Correção aqui também
        ]);

        $ticket->update($validatedData);

        return redirect()->route('tickets.index')->with('success', 'Chamado atualizado com sucesso!');
    }



    public function destroy(Ticket $ticket)
    {
        if (Auth::id() !== $ticket->creator_id && !Auth::user()->is_admin) {
            abort(403);
        }

        $ticket->delete();

        return redirect()
            ->route('tickets.index')
            ->with('success', 'Chamado excluído com sucesso!');
    }
}
