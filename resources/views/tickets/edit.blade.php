@extends('layouts.app')

@section('content')
<!-- Fundo Abstrato -->
<div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
    <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] rounded-full bg-red-600/5 blur-[100px]"></div>
    <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] rounded-full bg-orange-500/5 blur-[100px]"></div>
</div>

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
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Editar Chamado <span class="text-red-600">#{{ $ticket->id }}</span></h1>
        <p class="text-slate-500 mt-2">Atualize as informações do ticket abaixo.</p>
    </div>

    <!-- Card do Formulário -->
    <div class="bg-white/80 backdrop-blur-xl border border-white/50 p-8 rounded-3xl shadow-xl relative overflow-hidden">
        <!-- Barra superior colorida -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-orange-500 opacity-80"></div>

        <form action="{{ route('tickets.update', $ticket->id) }}" method="POST" class="space-y-8">
            @csrf
            @method('PUT')
            
            <!-- Seção 1: Cliente e Categoria -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Cliente -->
                <div class="space-y-2">
                    <label for="user_id" class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Cliente
                    </label>
                    <div class="relative">
                        <select id="user_id" name="user_id" required class="w-full appearance-none rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-3 px-4 pr-10">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}" {{ $ticket->user_id == $user->id ? 'selected' : '' }}>
                                    {{ $user->name }}
                                </option>
                            @endforeach
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
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $ticket->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
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
                <input id="title" type="text" name="title" value="{{ old('title', $ticket->title) }}" required 
                    class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 placeholder-slate-400 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-3 px-4">
            </div>

            <!-- Seção 2: Prioridade e Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Prioridade -->
                <div class="space-y-2">
                    <label for="priority" class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Prioridade
                    </label>
                    <div class="relative">
                        <select id="priority" name="priority" class="w-full appearance-none rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-3 px-4 pr-10">
                            <option value="normal" {{ $ticket->priority == 'normal' ? 'selected' : '' }}>Normal</option>
                            <option value="alta" {{ $ticket->priority == 'alta' ? 'selected' : '' }}>Alta</option>
                            <option value="baixa" {{ $ticket->priority == 'baixa' ? 'selected' : '' }}>Baixa</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Status -->
                <div class="space-y-2">
                    <label for="status" class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Status
                    </label>
                    <div class="relative">
                        <select id="status" name="status" class="w-full appearance-none rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-3 px-4 pr-10">
                            <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Aberto</option>
                            <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>Em andamento</option>
                            <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Fechado</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Usuário Responsável -->
            <div class="space-y-2">
                <label for="assigned_to" class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    Usuário Responsável
                </label>
                <div class="relative">
                    <select id="assigned_to" name="assigned_to" class="w-full appearance-none rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-3 px-4 pr-10">
                        <option value="">Selecione um Usuário</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $ticket->assigned_to == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    <div class="absolute inset-y-0 right-0 flex items-center px-4 pointer-events-none text-slate-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Descrição -->
            <div class="space-y-2">
                <label for="description" class="text-sm font-semibold text-slate-700 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"></path></svg>
                    Descrição Detalhada
                </label>
                <textarea id="description" name="description" required rows="6" 
                    class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 placeholder-slate-400 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-3 px-4 resize-none">{{ old('description', $ticket->description) }}</textarea>
            </div>

            <!-- Botões -->
            <div class="pt-6 flex flex-col-reverse md:flex-row justify-end items-center gap-4 border-t border-slate-100">
                <a href="{{ route('tickets.index') }}" class="w-full md:w-auto px-6 py-3 rounded-xl text-slate-600 font-medium hover:bg-slate-50 hover:text-slate-900 transition-colors text-center border border-transparent hover:border-slate-200">
                    Cancelar
                </a>
                <button type="submit" class="w-full md:w-auto px-8 py-3 rounded-xl bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold shadow-lg shadow-red-500/30 hover:shadow-red-500/40 hover:-translate-y-0.5 transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                    Atualizar Chamado
                </button>
            </div>
        </form>
    </div>
</div>
@endsection