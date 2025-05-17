@extends('layouts.app')

@section(section: 'content')
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Painel Administrativo</h1>

        <!-- Seção de Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Usuários Ativos</h3>
                <p class="text-3xl center font-bold text-gray-600">{{ $totalUsers }}</p>
            </div>
            <!-- Total de Tickets -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Total de Chamados</h3>
                <p class="text-3xl center font-bold text-gray-600">{{ $total_tickets }}</p>
            </div>

            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-lg font-semibold mb-2">Categorias</h3>
                <p class="text-3xl center font-bold text-gray-600">{{ $totalCategories }}</p>
            </div>
        </div>

        <!-- Seção de Gerenciamento de Usuários -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Gerenciamento de Usuários</h2>
                <a href="{{ route('admin.users.create') }}"
                    class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    + Novo Usuário
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($users as $user)
                            <tr>
                                <td class="px-6 py-4">{{ $user->name }}</td>
                                <td class="px-6 py-4">{{ $user->email }}</td>
                                <td class="px-6 py-4 flex space-x-2">
                                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900"
                                            onclick="return confirm('Tem certeza que deseja excluir este usuário?')">
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Seção de Gerenciamento de Categorias -->
        <!-- Seção de Gerenciamento de Categorias -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold">Gerenciamento de Categorias</h2>
            </div>

            <form action="{{ route('categories.store') }}" method="POST" class="mb-6">
                @csrf
                <div class="flex gap-4">
                    <input type="text" name="name" placeholder="Nova categoria" class="border rounded w-full px-3 py-2"
                        required>
                    <button type="submit" class="bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                        Adicionar
                    </button>
                </div>
            </form>

            @if($categories->isEmpty())
                <p class="text-gray-500">Nenhuma categoria cadastrada.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($categories as $category)
                        <div class="bg-gray-50 p-4 rounded flex justify-between items-center">
                            <span>{{ $category->name }}</span>
                            <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">
                                    Excluir
                                </button>
                            </form>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
@endsection