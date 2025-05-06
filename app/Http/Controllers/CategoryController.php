<?php

// app/Http/Controllers/CategoryController.php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Ticket;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:categories']);
        Category::create($request->all());
        return back()->with('success', 'Categoria criada!');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return back()->with('success', 'Categoria excluída!');
    }

    // app/Http/Controllers/AdminUserController.php

    public function index()
    {
        return view('admin.users.index', [
            'users' => User::paginate(10),
            'categories' => Category::all(),
            'totalUsers' => User::count(),
            'openTickets' => Ticket::where('status', 'open')->count(),
            'totalCategories' => Category::count()
        ]);
    }
    
}