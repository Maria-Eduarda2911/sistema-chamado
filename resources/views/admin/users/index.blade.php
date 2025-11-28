@extends('layouts.app')

@section('content')
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel Administrativo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 relative min-h-screen pb-20">

    <!-- Fundo Geral (Blobs) -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] rounded-full bg-red-600/5 blur-[100px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] rounded-full bg-orange-500/5 blur-[100px]"></div>
    </div>

    <!-- Container Principal -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        
        <!-- Cabeçalho -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Painel Administrativo</h1>
            <p class="text-slate-500 mt-2">Visão geral e gerenciamento do sistema.</p>
        </div>

        <!-- Estatísticas (Cards Modernos) -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <!-- Card 1: Usuários -->
            <div class="relative bg-white/70 backdrop-blur-xl border border-slate-200/60 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Usuários Ativos</p>
                        <p class="text-3xl font-bold text-slate-800 mt-2">1,234</p>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Card 2: Tickets -->
            <div class="relative bg-white/70 backdrop-blur-xl border border-slate-200/60 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Total de Chamados</p>
                        <p class="text-3xl font-bold text-slate-800 mt-2">856</p>
                    </div>
                    <div class="p-3 bg-orange-50 rounded-xl text-orange-600 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Card 3: Categorias -->
            <div class="relative bg-white/70 backdrop-blur-xl border border-slate-200/60 p-6 rounded-2xl shadow-sm hover:shadow-md transition-all group">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Categorias</p>
                        <p class="text-3xl font-bold text-slate-800 mt-2">12</p>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-xl text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- Coluna Esquerda: Usuários (Ocupa 2/3) -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Seção Usuários -->
                <div class="bg-white/80 backdrop-blur-xl border border-white/50 rounded-2xl shadow-xl overflow-hidden">
                    <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50 flex justify-between items-center">
                        <h2 class="text-lg font-bold text-slate-800">Gerenciamento de Usuários</h2>
                        <a href="#" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold rounded-lg transition-colors shadow-sm">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            Novo Usuário
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-slate-100">
                            <thead class="bg-slate-50/30">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Usuário</th>
                                    <th class="px-6 py-3 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-slate-50">
                                <!-- Item 1 -->
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">JS</div>
                                            <span class="text-sm font-medium text-slate-700">João Silva</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-500">joao@exemplo.com</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-right text-sm">
                                        <button class="text-red-500 hover:text-red-700 p-1 rounded hover:bg-red-50 transition-colors" title="Excluir">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Item 2 -->
                                <tr class="hover:bg-slate-50/80 transition-colors">
                                    <td class="px-6 py-3 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">MA</div>
                                            <span class="text-sm font-medium text-slate-700">Maria Almeida</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-3 whitespace-nowrap text-sm text-slate-500">maria@exemplo.com</td>
                                    <td class="px-6 py-3 whitespace-nowrap text-right text-sm">
                                        <button class="text-red-500 hover:text-red-700 p-1 rounded hover:bg-red-50 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Coluna Direita: Categorias (Ocupa 1/3) -->
            <div class="lg:col-span-1">
                <div class="bg-white/80 backdrop-blur-xl border border-white/50 rounded-2xl shadow-xl p-6 sticky top-6">
                    <h2 class="text-lg font-bold text-slate-800 mb-4">Categorias</h2>
                    
                    <!-- Form Nova Categoria -->
                    <form action="#" class="mb-6">
                        <div class="flex gap-2">
                            <input type="text" placeholder="Nova Categoria..." class="w-full rounded-lg border-slate-200 text-sm focus:border-green-500 focus:ring-green-500 focus:ring-opacity-20 transition-all px-3 py-2">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white p-2 rounded-lg transition-colors shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                    </form>

                    <!-- Lista de Categorias -->
                    <div class="space-y-2 max-h-[400px] overflow-y-auto pr-1">
                        <!-- Item -->
                        <div class="flex items-center justify-between p-3 bg-slate-50 border border-slate-100 rounded-lg group hover:border-slate-200 transition-all">
                            <span class="text-sm font-medium text-slate-700">Suporte Técnico</span>
                            <button class="text-slate-400 hover:text-red-500 transition-colors p-1 opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                        <!-- Item -->
                        <div class="flex items-center justify-between p-3 bg-slate-50 border border-slate-100 rounded-lg group hover:border-slate-200 transition-all">
                            <span class="text-sm font-medium text-slate-700">Financeiro</span>
                            <button class="text-slate-400 hover:text-red-500 transition-colors p-1 opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                        <!-- Item -->
                        <div class="flex items-center justify-between p-3 bg-slate-50 border border-slate-100 rounded-lg group hover:border-slate-200 transition-all">
                            <span class="text-sm font-medium text-slate-700">Vendas</span>
                            <button class="text-slate-400 hover:text-red-500 transition-colors p-1 opacity-0 group-hover:opacity-100">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>
</body>
</html>
@endsection