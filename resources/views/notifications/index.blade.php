<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Suas Notificações</title>
    <!-- Carregando Tailwind via CDN para funcionar direto no navegador -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 relative overflow-x-hidden">

    <!-- Navbar Simulada (Apenas visual) -->
    <nav class="bg-white/80 backdrop-blur-xl border-b border-slate-200 h-16 mb-8"></nav>

    <!-- Fundo Geral com elementos visuais do tema (Gradient Blobs) -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] rounded-full bg-red-600/5 blur-[100px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] rounded-full bg-orange-500/5 blur-[100px]"></div>
    </div>

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        
        <!-- Cabeçalho da Página -->
        <div class="flex flex-col md:flex-row justify-between items-end md:items-center mb-10 gap-6">
            <div>
                <h2 class="text-3xl font-bold text-slate-900 tracking-tight">
                    Suas Notificações
                </h2>
                <p class="text-slate-500 mt-2 text-base">
                    Fique por dentro das atualizações dos seus chamados.
                </p>
            </div>

            <div class="flex items-center gap-4">
                <!-- Contador -->
                <div class="bg-white/80 backdrop-blur-md border border-red-100 shadow-sm px-4 py-2 rounded-2xl flex items-center gap-2">
                    <div class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></div>
                    <span class="text-sm font-semibold text-slate-700">
                        3 não lidas
                    </span>
                </div>
                
                <button class="group relative overflow-hidden bg-red-600 hover:bg-red-700 text-white text-sm font-semibold px-6 py-2.5 rounded-xl transition-all shadow-lg shadow-red-500/30 hover:shadow-red-500/40 hover:-translate-y-0.5">
                    <span class="relative z-10 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Marcar todas como lidas
                    </span>
                </button>
            </div>
        </div>

        <!-- Lista de Notificações (Exemplos Estáticos) -->
        <div class="space-y-4">
            
            <!-- Exemplo 1: Notificação de Alta Prioridade (Não Lida) -->
            <div class="group relative bg-white border border-red-100 shadow-sm ring-1 ring-red-50 p-6 rounded-2xl transition-all duration-300 hover:shadow-xl hover:shadow-red-500/5 hover:-translate-y-1">
                <div class="flex gap-5">
                    <!-- Ícone -->
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 rounded-2xl flex items-center justify-center bg-gradient-to-br from-red-500 to-red-600 text-white shadow-lg shadow-red-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>

                    <!-- Conteúdo -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="inline-block w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                            <span class="text-xs font-bold text-red-600 uppercase tracking-wide">Nova</span>
                            <span class="text-xs font-medium text-slate-400">• há 5 minutos</span>
                        </div>
                        
                        <h4 class="text-lg font-bold text-slate-800 leading-snug group-hover:text-red-700 transition-colors">
                            Ticket Crítico #1234 precisa de atenção urgente
                        </h4>

                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div class="bg-slate-50 rounded-lg p-2.5 border border-slate-100 flex flex-col">
                                <span class="text-[10px] uppercase text-slate-400 font-bold tracking-wider">Referente ao Ticket</span>
                                <span class="text-sm font-medium text-slate-700 truncate">#1234 - Servidor indisponível</span>
                            </div>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border bg-red-50 text-red-700 border-red-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span>
                                    Prioridade Alta
                                </span>
                                <span class="text-xs text-slate-500 bg-white border border-slate-200 px-2 py-1 rounded-full flex items-center gap-1">
                                    <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    João Silva
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Ações -->
                    <div class="flex flex-col items-end gap-2 pl-4 border-l border-slate-100 border-dashed">
                        <button class="p-2 rounded-lg bg-slate-50 text-slate-500 hover:bg-green-50 hover:text-green-600 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </button>
                        <button class="p-2 rounded-lg bg-slate-50 text-slate-500 hover:bg-red-50 hover:text-red-600 transition-colors mt-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Exemplo 2: Notificação Média (Lida) -->
            <div class="group relative bg-white/70 backdrop-blur-xl border border-slate-200/60 p-6 rounded-2xl transition-all duration-300 opacity-80 hover:opacity-100 hover:bg-white hover:shadow-lg">
                <div class="flex gap-5">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 rounded-2xl flex items-center justify-center bg-slate-100 text-slate-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                        </div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-slate-400">há 2 horas</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 leading-snug">
                            Novo comentário no ticket #1230
                        </h4>
                        <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                             <div class="bg-slate-50 rounded-lg p-2.5 border border-slate-100 flex flex-col">
                                <span class="text-[10px] uppercase text-slate-400 font-bold tracking-wider">Referente ao Ticket</span>
                                <span class="text-sm font-medium text-slate-700 truncate">#1230 - Erro no login</span>
                            </div>
                             <div class="flex items-center gap-2 mt-1">
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-medium border bg-orange-50 text-orange-700 border-orange-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                    Prioridade Média
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-end gap-2 pl-4 border-l border-slate-100 border-dashed">
                        <button class="p-2 rounded-lg bg-slate-50 text-slate-500 hover:bg-red-50 hover:text-red-600 transition-colors mt-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

             <!-- Exemplo 3: Notificação Sistema (Lida) -->
            <div class="group relative bg-white/70 backdrop-blur-xl border border-slate-200/60 p-6 rounded-2xl transition-all duration-300 opacity-80 hover:opacity-100 hover:bg-white hover:shadow-lg">
                <div class="flex gap-5">
                    <div class="flex-shrink-0">
                        <div class="h-12 w-12 rounded-2xl flex items-center justify-center bg-slate-100 text-slate-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-slate-400">há 1 dia</span>
                        </div>
                        <h4 class="text-lg font-bold text-slate-800 leading-snug">
                            Manutenção programada concluída
                        </h4>
                        <p class="text-sm text-slate-500 mt-2">O sistema foi atualizado para a versão 2.0. Novas funcionalidades disponíveis.</p>
                    </div>

                    <div class="flex flex-col items-end gap-2 pl-4 border-l border-slate-100 border-dashed">
                        <button class="p-2 rounded-lg bg-slate-50 text-slate-500 hover:bg-red-50 hover:text-red-600 transition-colors mt-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

        </div>

        <!-- Paginação Simulada -->
        <div class="mt-10 flex justify-center">
            <nav class="flex gap-2">
                <span class="px-4 py-2 rounded-lg bg-slate-100 text-slate-400 text-sm font-medium">Anterior</span>
                <span class="px-4 py-2 rounded-lg bg-red-600 text-white text-sm font-medium shadow-lg shadow-red-500/30">1</span>
                <span class="px-4 py-2 rounded-lg bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 text-sm font-medium transition cursor-pointer">2</span>
                <span class="px-4 py-2 rounded-lg bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 text-sm font-medium transition cursor-pointer">3</span>
                <span class="px-4 py-2 rounded-lg bg-white text-slate-600 hover:bg-slate-50 border border-slate-200 text-sm font-medium transition cursor-pointer">Próximo</span>
            </nav>
        </div>
    </div>
</body>
</html>