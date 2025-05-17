@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 max-w-3xl">
    <h1 class="text-3xl font-semibold text-gray-600 text-center">Criar Novo Chamado</h1>
    
    <form action="{{ route('tickets.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md space-y-6">
        @csrf

        <!-- Cliente & Categoria -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Cliente -->
            <div>
                <label for="user_id" class="block text-gray-700 mb-2 font-semibold">Cliente</label>
                <select id="user_id" name="user_id" required class="border rounded w-full px-3 py-2 bg-white">
                    <option value="">Selecione um Cliente</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Categoria -->
            <div>
                <label for="category_id" class="block text-gray-700 mb-2 font-semibold">Categoria</label>
                <select id="category_id" name="category_id" required class="border rounded w-full px-3 py-2 bg-white">
                    <option value="">Selecione uma Categoria</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Título -->
        <div>
            <label for="title" class="block text-gray-700 mb-2 font-semibold">Título do Chamado</label>
            <input id="title" type="text" name="title" required class="border rounded w-full px-3 py-2">
        </div>

        <!-- Prioridade & Status -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Prioridade -->
            <div>
                <label for="priority" class="block text-gray-700 mb-2 font-semibold">Prioridade</label>
                <select id="priority" name="priority" class="border rounded w-full px-3 py-2 bg-white">
                    <option value="normal" selected>Normal</option>
                    <option value="alta">Alta</option>
                    <option value="baixa">Baixa</option>
                </select>
            </div>

            <!-- Status -->
            <div>
                <label class="block text-gray-700 mb-2 font-semibold">Status</label>
                <input type="text" readonly value="Aberto" class="border rounded w-full px-3 py-2 bg-gray-100">
            </div>
        </div>

        <!-- Descrição -->
        <div>
            <label for="description" class="block text-gray-700 mb-2 font-semibold">Descrição Detalhada</label>
            <textarea id="description" name="description" required class="border rounded w-full px-3 py-2 h-32"></textarea>
        </div>

        <!-- Botões -->
        <div class="flex justify-end space-x-4">
            <a href="{{ route('tickets.index') }}" class="bg-gray-300 text-gray-800 px-6 py-2 rounded hover:bg-gray-400">
                Cancelar
            </a>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 font-semibold">
                Criar Chamado
            </button>
        </div>
    </form>
</div>
@endsection
