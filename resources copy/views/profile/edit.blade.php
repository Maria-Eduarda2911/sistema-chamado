@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações da Conta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold mb-6">Configurações da Conta</h1>

        <!-- Seção de Informações Pessoais -->
        <div class="bg-white p-6 rounded-lg shadow-sm mb-6">
            <h2 class="text-lg font-semibold mb-4">Informações Pessoais</h2>
            <form action="/users/update-self" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PATCH">
                <input type="hidden" name="_csrf" value="CSRF_TOKEN_PLACEHOLDER">

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="name" class="block text-gray-700 mb-2">Nome</label>
                        <input id="name" type="text" name="name" value="Seu Nome" required
                               class="border rounded w-full px-3 py-2">
                    </div>

                    <div>
                        <label for="email" class="block text-gray-700 mb-2">Email</label>
                        <input id="email" type="email" name="email" value="seuemail@example.com" required
                               class="border rounded w-full px-3 py-2">
                    </div>
                </div>

                <!-- Avatar -->
                <div class="mt-4 flex items-center space-x-4">
                    <img src="avatar-placeholder.png" alt="Avatar" class="w-16 h-16 rounded-full">
                    <div>
                        <label for="avatar" class="block text-gray-700 mb-2">Alterar Avatar</label>
                        <input id="avatar" type="file" name="avatar" accept=".jpg,.png,.ico"
                               class="border rounded w-full px-3 py-2">
                    </div>
                </div>

                <!-- Botão para salvar alterações -->
                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                        Salvar Alterações
                    </button>
                </div>
            </form>
        </div>

        <!-- Seção para Alterar Senha -->
        <div class="bg-white p-6 rounded-lg shadow-sm">
            <h2 class="text-lg font-semibold mb-4">Alterar Senha</h2>
            <form action="/users/change-password" method="POST">
                <input type="hidden" name="_csrf" value="CSRF_TOKEN_PLACEHOLDER">

                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <label for="current-password" class="block text-gray-700 mb-2">Senha Atual</label>
                        <input id="current-password" type="password" name="current-password" required
                               class="border rounded w-full px-3 py-2">
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6 mt-4">
                    <div>
                        <label for="new-password" class="block text-gray-700 mb-2">Nova Senha</label>
                        <input id="new-password" type="password" name="new-password" required
                               class="border rounded w-full px-3 py-2">
                    </div>

                    <div>
                        <label for="confirm-password" class="block text-gray-700 mb-2">Confirmar Nova Senha</label>
                        <input id="confirm-password" type="password" name="confirm-password" required
                               class="border rounded w-full px-3 py-2">
                    </div>
                </div>

                <!-- Botão para alterar senha -->
                <div class="flex justify-end mt-6">
                    <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded hover:bg-blue-600">
                        Alterar Senha
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
@endsection