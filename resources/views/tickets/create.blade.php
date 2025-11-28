<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Novo Chamado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 relative min-h-screen pb-10">

    <!-- Fundo Geral (Blobs) -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] rounded-full bg-red-600/5 blur-[100px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] rounded-full bg-orange-500/5 blur-[100px]"></div>
    </div>

    <!-- Container Principal -->
    <div class="container mx-auto px-4 py-12 max-w-3xl">
        
        <!-- Botão Voltar -->
        <div class="mb-6">
            <a href="{{ route('tickets.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-red-600 transition-colors p-2 -ml-2 rounded-lg hover:bg-slate-100/50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Voltar
            </a>
        </div>
        
        <!-- Cabeçalho -->
        <div class="mb-10 text-center">
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Criar Novo Chamado</h1>
            <p class="text-slate-500 mt-2">Preencha os detalhes abaixo para abrir uma nova solicitação de suporte.</p>
        </div>

        <!-- Card do Formulário -->
        <div class="bg-white/80 backdrop-blur-xl border border-white/50 p-8 rounded-3xl shadow-xl relative overflow-hidden">
            <!-- Barra superior colorida -->
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-orange-500 opacity-80"></div>

            <form action="{{ route('tickets.store') }}" method="POST" class="space-y-8">
                @csrf
                
                <!-- Seção 1: Informações Básicas -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Cliente -->
                    <div class="space-y-2">
                        <label for="user_id" class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Cliente
                        </label>
                        <div class="relative">
                            <select id="user_id" name="user_id" required class="w-full appearance-none rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-3 px-4 pr-10">
                                <option value="">Selecione um Cliente</option>
                                <option value="1">Acme Corp</option>
                                <option value="2">Wayne Enterprises</option>
                                <option value="3">Stark Industries</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Categoria -->
                    <div class="space-y-2">
                        <label for="category_id" class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            Categoria
                        </label>
                        <div class="relative">
                            <select id="category_id" name="category_id" required class="w-full appearance-none rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-3 px-4 pr-10">
                                <option value="">Selecione uma Categoria</option>
                                <option value="1">Suporte Técnico</option>
                                <option value="2">Financeiro</option>
                                <option value="3">Infraestrutura</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Título -->
                <div class="space-y-2">
                    <label for="title" class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Título do Chamado
                    </label>
                    <input id="title" type="text" name="title" placeholder="Ex: Erro ao acessar o painel..." required 
                        class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 placeholder-slate-400 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-3 px-4">
                </div>

                <!-- Seção 2: Detalhes -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Prioridade -->
                    <div class="space-y-2">
                        <label for="priority" class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Prioridade
                        </label>
                        <div class="relative">
                            <select id="priority" name="priority" class="w-full appearance-none rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-3 px-4 pr-10">
                                <option value="normal" selected>Normal</option>
                                <option value="alta">Alta</option>
                                <option value="baixa">Baixa</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Status (Readonly visualmente melhorado) -->
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Status Inicial
                        </label>
                        <div class="w-full rounded-xl border border-slate-200 bg-slate-100 text-slate-500 py-3 px-4 cursor-not-allowed select-none font-medium flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            Aberto
                        </div>
                    </div>
                </div>

                <!-- Descrição -->
                <div class="space-y-2">
                    <label for="description" class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                        Descrição Detalhada
                    </label>
                    <textarea id="description" name="description" required rows="5" placeholder="Descreva o problema com o máximo de detalhes possível..."
                        class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 placeholder-slate-400 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-3 px-4 resize-none"></textarea>
                </div>

                <!-- Botões -->
                <div class="pt-6 flex flex-col-reverse md:flex-row justify-end items-center gap-4 border-t border-slate-100">
                    <a href="{{ route('tickets.index') }}" class="w-full md:w-auto px-6 py-3 rounded-xl text-slate-600 font-medium hover:bg-slate-50 hover:text-slate-900 transition-colors text-center border border-transparent hover:border-slate-200">
                        Cancelar
                    </a>
                    <button type="submit" class="w-full md:w-auto px-8 py-3 rounded-xl bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold shadow-lg shadow-red-500/30 hover:shadow-red-500/40 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Criar Chamado
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>