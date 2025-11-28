@extends('layouts.app')

@section('content')
<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    <div class="flex flex-col md:flex-row justify-between items-end md:items-center mb-6 gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Gerenciamento de Chamados</h1>
            <p class="text-slate-500 mt-2">Visualize, filtre e gerencie todas as solicitações de suporte.</p>
        </div>

        <a href="{{ route('tickets.create') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold shadow-lg hover:shadow-lg transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
            Novo Chamado
        </a>
    </div>

    <!-- Filtros -->
    <div class="bg-white/80 backdrop-blur-xl border border-white/50 p-6 rounded-2xl shadow-sm mb-8">
        <form action="{{ route('tickets.index') }}" method="GET" class="grid grid-cols-1 md:grid-cols-12 gap-4 items-end">
            <div class="md:col-span-1">
                <label for="filter_id" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">ID</label>
                <input type="number" name="id" id="filter_id" value="{{ request('id') }}" placeholder="#" class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-700 py-2.5 px-3">
            </div>

            <div class="md:col-span-3">
                <label for="filter_category" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Categoria</label>
                <div class="relative">
                    <select name="category_id" id="filter_category" class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-700 py-2.5 px-3 pr-8">
                        <option value="">Todas</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="md:col-span-2">
                <label for="filter_priority" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Prioridade</label>
                <div class="relative">
                    <select name="priority" id="filter_priority" class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-700 py-2.5 px-3 pr-8">
                        <option value="">Todas</option>
                        @foreach($priorities as $p)
                            @php $val = is_object($p) ? ($p->priority ?? $p->name ?? $p) : $p; @endphp
                            <option value="{{ $val }}" {{ request('priority') == $val ? 'selected' : '' }}>{{ ucfirst($val) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="md:col-span-3">
                <label for="assigned_to" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Técnico</label>
                <div class="relative">
                    <select name="assigned_to" id="assigned_to" class="w-full rounded-xl border-slate-200 bg-slate-50 text-slate-700 py-2.5 px-3 pr-8">
                        <option value="">Todos</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ request('assigned_to') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="md:col-span-3 flex gap-2">
                <button type="submit" class="flex-1 bg-slate-800 hover:bg-slate-900 text-white font-medium py-2.5 px-4 rounded-xl">Filtrar</button>
                <a href="{{ route('tickets.index') }}" class="flex-1 bg-white border border-slate-200 text-slate-600 py-2.5 px-4 rounded-xl text-center">Limpar</a>
            </div>
        </form>
    </div>

    <!-- Tabela -->
    <div class="bg-white/80 backdrop-blur-xl border rounded-2xl shadow-xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">ID</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Título</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase tracking-wider">Prioridade</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Categoria</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Técnico</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase tracking-wider">Descrição</th>
                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-slate-50">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50/80 transition-colors group">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-400">#{{ $ticket->id }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('tickets.show', $ticket) }}" class="text-sm font-semibold text-slate-800 group-hover:text-red-600 transition-colors">{{ $ticket->title }}</a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @php
                                    $status = $ticket->status;
                                    $badge = 'bg-gray-100 text-gray-700';
                                    if(in_array($status, ['open','aberto'])) { $badge = 'bg-green-100 text-green-800'; }
                                    if(in_array($status, ['in_progress','in_andamento','in_progress'])) { $badge = 'bg-yellow-50 text-yellow-800'; }
                                    if(in_array($status, ['closed','fechado'])) { $badge = 'bg-gray-50 text-gray-800'; }
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }} border border-transparent">
                                    <span class="w-1.5 h-1.5 rounded-full {{ strpos($badge,'green')!==false ? 'bg-green-500' : (strpos($badge,'yellow')!==false ? 'bg-yellow-500' : 'bg-gray-400') }} mr-1.5"></span>
                                    {{ ucfirst(str_replace(['_','-'], ' ', $ticket->status)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-50 text-red-700 border border-red-100">{{ ucfirst($ticket->priority) }}</span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">{{ $ticket->category?->name ?? '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($ticket->assignedUser)
                                    <div class="flex items-center gap-2">
                                        <div class="h-6 w-6 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">{{ strtoupper(substr($ticket->assignedUser->name,0,2)) }}</div>
                                        <span class="text-sm text-slate-600">{{ $ticket->assignedUser->name }}</span>
                                    </div>
                                @else
                                    <span class="text-sm text-slate-400 italic">Não atribuído</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-400 max-w-xs truncate">{{ \Illuminate\Support\Str::limit($ticket->description, 80) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('tickets.edit', $ticket) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 hover:text-blue-700 transition-colors" title="Editar">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                    </a>

                                    <form action="{{ route('tickets.destroy', $ticket) }}" method="POST" onsubmit="return confirm('Deseja realmente excluir este chamado?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 hover:text-red-700 transition-colors" title="Excluir">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="px-6 py-6 text-center text-slate-500">Nenhum chamado encontrado.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="px-6 py-4 border-t border-slate-100 bg-slate-50/30 flex items-center justify-between">
            <span class="text-sm text-slate-500">Mostrando {{ $tickets->firstItem() ?? 0 }} a {{ $tickets->lastItem() ?? 0 }} de {{ $tickets->total() }} resultados</span>
            <div>
                {{ $tickets->withQueryString()->links() }}
            </div>
        </div>
    </div>

</main>
@endsection