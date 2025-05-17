@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Editar Chamado</h1>

    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST"
        class="bg-white p-6 rounded-lg shadow-md space-y-6">
        @csrf
        @method('PUT')

        <!-- Cliente & Categoria -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Cliente -->
            <div>
                <label for="user_id" class="block text-gray-700 mb-2 font-semibold">Cliente</label>
                <select id="user_id" name="user_id" required class="border rounded w-full px-3 py-2 bg-white">
                    @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ $ticket->user_id == $user->id ? 'selected' : '' }}>
                            {{ $user->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Categoria -->
            <div>
                <label for="category_id" class="block text-gray-700 mb-2 font-semibold">Categoria</label>
                <select id="category_id" name="category_id" required class="border rounded w-full px-3 py-2 bg-white">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $ticket->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Título -->
        <div>
            <label for="title" class="block text-gray-700 mb-2 font-semibold">Título do Chamado</label>
            <input id="title" type="text" name="title" value="{{ $ticket->title }}" required
                class="border rounded w-full px-3 py-2">
        </div>

        <!-- Prioridade & Status -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Prioridade -->
            <div>
                <label for="priority" class="block text-gray-700 mb-2 font-semibold">Prioridade</label>
                <select id="priority" name="priority" class="border rounded w-full px-3 py-2 bg-white">
                    <option value="normal" {{ $ticket->priority == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="alta" {{ $ticket->priority == 'alta' ? 'selected' : '' }}>Alta</option>
                    <option value="baixa" {{ $ticket->priority == 'baixa' ? 'selected' : '' }}>Baixa</option>
                </select>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-gray-700 mb-2 font-semibold">Status</label>
                <select id="status" name="status" class="border rounded w-full px-3 py-2 bg-white">
                    <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Aberto</option>
                    <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>Em andamento</option>
                    <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Fechado</option>
                </select>
            </div>
        </div>

        <!-- Usuário Responsável -->
        <div>
            <label for="assigned_to" class="block text-gray-700 mb-2 font-semibold">Usuário Responsável</label>
            <select id="assigned_to" name="assigned_to" class="border rounded w-full px-3 py-2 bg-white">
                <option value="">Selecione um Usuário</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $ticket->assigned_to == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Descrição -->
        <div>
            <label for="description" class="block text-gray-700 mb-2 font-semibold">Descrição Detalhada</label>
            <textarea id="description" name="description" required
                class="border rounded w-full px-3 py-2 h-32">{{ $ticket->description }}</textarea>
        </div>

        <!-- Botões -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('tickets.index') }}"
                class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400">
                Cancelar
            </a>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 font-semibold">
                Atualizar Chamado
            </button>
        </div>
    </form>
</div>
@endsection
