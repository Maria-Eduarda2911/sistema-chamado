@extends('layouts.app')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Cabeçalho -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-semibold text-gray-800">Gerenciamento de Chamados</h1>
            <a href="{{ route('tickets.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow focus:outline-none focus:shadow-outline transition-all">
                <i class="fas fa-plus mr-2"></i> Novo Chamado
            </a>
        </div>

        <!-- Filtros -->
        <div class="bg-white shadow-md rounded-lg p-4 mb-4">
            <form action="{{ route('tickets.index') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-4 gap-2 items-end">

                <!-- ID -->
                <div>
                    <label for="filter_id" class="block text-gray-700 text-sm font-bold mb-1">ID:</label>
                    <input type="number" name="id" id="filter_id" value="{{ request('id') }}" placeholder="Digite o ID"
                        class="shadow border rounded w-full py-1 px-2 text-gray-700 focus:outline-none focus:shadow-outline transition-all">
                </div>

                <!-- Categoria -->
                <div>
                    <label for="filter_category" class="block text-gray-700 text-sm font-bold mb-1">Categoria:</label>
                    <select name="category_id" id="filter_category"
                        class="shadow border rounded w-full py-1 px-2 text-gray-700 focus:outline-none focus:shadow-outline">
                        <option value="">Todas</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Prioridade -->
                <div>
                    <label for="filter_priority" class="block text-gray-700 text-sm font-bold mb-1">Prioridade:</label>
                    <select name="priority" id="filter_priority"
                        class="shadow border rounded w-full py-1 px-2 text-gray-700 focus:outline-none focus:shadow-outline">
                        <option value="">Todas</option>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->priority }}" {{ request('priority') == $priority->priority ? 'selected' : '' }}>
                                {{ ucfirst($priority->priority) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <!-- Filtro de Usuário Atribuído -->
<div>
    <label for="assigned_to" class="block text-gray-700 text-sm font-bold mb-1">Usuário Atribuído</label>
    <select name="assigned_to" id="assigned_to" class="shadow border rounded w-full py-1 px-2 text-gray-700">
        <option value="">Todos</option>
        @foreach($users as $user)
            <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>
                {{ $user->name }}
            </option>
        @endforeach
    </select>
</div>

                <!-- Botões -->
                <div class="flex justify-center items-center space-x-2">
                    <button type="submit"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-1 px-3 rounded shadow focus:outline-none focus:shadow-outline transition-all">
                        <i class="fas fa-filter mr-1"></i> Filtrar
                    </button>
                    <a href="{{ route('tickets.index') }}"
                        class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold py-1 px-3 rounded shadow focus:outline-none focus:shadow-outline transition-all">
                        <i class="fas fa-times mr-1"></i> Limpar
                    </a>
                </div>

            </form>
        </div>

        <!-- Tabela de Chamados -->
<div class="bg-white shadow-md rounded-lg overflow-hidden">
    <table class="min-w-full leading-normal">
        <thead class="bg-gray-100">
            <tr class="text-center">
                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Título</th>
                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Prioridade</th>
                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Categoria</th>
                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">User Atribuido</th>
                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Descrição</th>
                <th class="px-4 py-3 text-xs font-semibold text-gray-600 uppercase tracking-wider">Ações</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($tickets as $ticket)
                <tr class="text-center">
                    <td class="px-4 py-2">{{ $ticket->id }}</td>
                    <td class="px-4 py-2 font-semibold">{{ $ticket->title }}</td>
                    <td class="px-4 py-2">
                        <span class="px-2 py-1 text-xs font-semibold rounded 
                            @if($ticket->status == 'open') bg-green-500 text-white
                            @elseif($ticket->status == 'in_progress') bg-yellow-500 text-black
                            @elseif($ticket->status == 'closed') bg-red-500 text-white
                            @endif">
                            @if($ticket->status == 'open') Aberto
                            @elseif($ticket->status == 'in_progress') Em andamento
                            @elseif($ticket->status == 'closed') Fechado
                            @endif
                        </span>
                    </td>
                    <td class="px-4 py-2">{{ ucfirst($ticket->priority) }}</td>
                    <td class="px-4 py-2">{{ $ticket->category->name }}</td>
                    <td class="px-4 py-2">
                        {{ $ticket->assignedUser ? $ticket->assignedUser->name : 'Não atribuído' }} <!-- Exibe usuário atribuido -->
                    </td>
                    <td class="px-4 py-2">
                        {{ strlen($ticket->description) > 50 ? substr($ticket->description, 0, 20) . '...' : $ticket->description }}
                    </td>
                    <td class="px-4 py-2">
                        <div class="flex justify-center space-x-2">
                            <a href="{{ route('tickets.edit', $ticket) }}"
                                class="bg-blue-100 hover:bg-blue-200 text-blue-700 font-semibold py-2 px-3 rounded text-sm shadow transition-all">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <form action="{{ route('tickets.destroy', $ticket) }}" method="POST"
                                onsubmit="return confirm('Tem certeza que deseja excluir?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="bg-red-100 hover:bg-red-200 text-red-700 font-semibold py-2 px-3 rounded text-sm shadow transition-all">
                                    <i class="fas fa-trash-alt"></i> Excluir
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="px-4 py-2 text-center text-sm text-gray-500">Nenhum chamado encontrado.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>


        <!-- Paginação -->
        <div class="mt-6">
            {{ $tickets->withQueryString()->links() }}
        </div>
    </main>
@endsection