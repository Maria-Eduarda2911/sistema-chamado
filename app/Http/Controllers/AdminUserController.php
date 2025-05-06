<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Ticket;

class AdminUserController extends Controller
{
    // Método para listar usuários
    // app/Http/Controllers/AdminUserController.php
public function index()
{
    return view('admin.users.index', [
        'users' => User::paginate(10),
        'totalUsers' => User::count(),
        'openTickets' => Ticket::where('status', 'open')->count(),
        'categories' => Category::all(),
        'totalCategories' => Category::count(),
        'total_tickets' => Ticket::count(), // Contagem total de tickets
    ]);
}
    // Método para exibir formulário de criação
    public function create()
    {
        return view('admin.users.create');
    }

    // Método para salvar novo usuário
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'is_admin' => 'sometimes|boolean'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => $request->has('is_admin')
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Usuário criado!');
    }

    // Método para exibir formulário de edição
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Método para atualizar usuário
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
            'password' => 'nullable|confirmed|min:8',
            'is_admin' => 'sometimes|boolean'
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->has('is_admin')
        ]);

        if ($request->password) {
            $user->update(['password' => bcrypt($request->password)]);
        }

        return redirect()->route('admin.users.index')->with('success', 'Usuário atualizado!');
    }

    // Método para alternar status de admin
    public function toggleAdmin(User $user)
    {
        $user->update(['is_admin' => !$user->is_admin]);
        return back()->with('success', 'Status de admin atualizado!');
    }

    // Método para excluir usuário
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Usuário excluído!');
    }
}