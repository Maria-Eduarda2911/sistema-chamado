<x-app-layout>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white p-8 rounded-lg shadow-lg text-center">
            <h1 class="text-2xl font-bold text-red-600 mb-4">Erro 403</h1>
            <p class="text-gray-600">Acesso negado - Você não tem permissão para acessar esta página</p>
            <a href="{{ url()->previous() }}" 
               class="mt-4 inline-block text-blue-600 hover:text-blue-800">
                Voltar
            </a>
        </div>
    </div>
</x-app-layout>