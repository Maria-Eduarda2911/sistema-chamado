{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-4">Criar Novo Usuário</h1>
            
            <form method="POST" action="{{ route('admin.users.store') }}">
                @csrf

                <!-- Nome -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Nome</label>
                    <input type="text" name="name" class="border rounded w-full py-2 px-3" required>
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" name="email" class="border rounded w-full py-2 px-3" required>
                </div>

                <!-- Senha -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Senha</label>
                    <input type="password" name="password" class="border rounded w-full py-2 px-3" required>
                </div>

                <!-- Confirmar Senha -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">Confirmar Senha</label>
                    <input type="password" name="password_confirmation" class="border rounded w-full py-2 px-3" required>
                </div>

                <!-- Checkbox Admin -->
                <div class="mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_admin" class="form-checkbox">
                        <span class="ml-2">Usuário Administrador</span>
                    </label>
                </div>

                <!-- Botões -->
                <div class="flex items-center justify-end">
                    <a href="{{ route('admin.users.index') }}" class="text-gray-600 hover:text-gray-800 mr-4">Cancelar</a>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Criar Usuário
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection