@extends('layouts.app')

@section('content')
<div class="bg-slate-50 relative">

    <!-- Fundo Geral (Blobs) -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] rounded-full bg-red-600/5 blur-[100px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] rounded-full bg-orange-500/5 blur-[100px]"></div>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 pb-20">
        
        <!-- Cabeçalho -->
        <div class="mb-10">
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Dashboard</h1>
            <p class="text-slate-500 mt-2">Visão geral e métricas de desempenho do sistema.</p>
        </div>

        <!-- Cards de Estatísticas -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            
            <!-- Card: Abertos -->
            <div class="group relative bg-white/70 backdrop-blur-xl border border-slate-200/60 p-6 rounded-2xl shadow-sm transition-all hover:shadow-lg hover:-translate-y-1 hover:bg-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Abertos</h3>
                    <div class="p-2 bg-blue-50 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-slate-800">{{ $stats['abertos'] }}</p>
                <div class="mt-2 text-xs text-slate-400">Chamados abertos</div>
            </div>

            <!-- Card: Pendentes -->
            <div class="group relative bg-white/70 backdrop-blur-xl border border-slate-200/60 p-6 rounded-2xl shadow-sm transition-all hover:shadow-lg hover:-translate-y-1 hover:bg-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Pendentes</h3>
                    <div class="p-2 bg-yellow-50 rounded-lg text-yellow-600 group-hover:bg-yellow-500 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-slate-800">{{ $stats['pendentes'] }}</p>
                <div class="mt-2 text-xs text-slate-400">Em andamento</div>
            </div>

            <!-- Card: Resolvidos -->
            <div class="group relative bg-white/70 backdrop-blur-xl border border-slate-200/60 p-6 rounded-2xl shadow-sm transition-all hover:shadow-lg hover:-translate-y-1 hover:bg-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Resolvidos</h3>
                    <div class="p-2 bg-green-50 rounded-lg text-green-600 group-hover:bg-green-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-slate-800">{{ $stats['resolvidos'] }}</p>
                <div class="mt-2 text-xs text-slate-400">Resolvidos</div>
            </div>

            <!-- Card: Sem Atribuição -->
            <div class="group relative bg-white/70 backdrop-blur-xl border border-slate-200/60 p-6 rounded-2xl shadow-sm transition-all hover:shadow-lg hover:-translate-y-1 hover:bg-white">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wider">Sem Técnico</h3>
                    <div class="p-2 bg-red-50 rounded-lg text-red-600 group-hover:bg-red-600 group-hover:text-white transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                </div>
                <p class="text-3xl font-bold text-slate-800">{{ $stats['sem_responsavel'] }}</p>
                <div class="mt-2 text-xs text-slate-400">Sem técnico atribuído</div>
            </div>
        </div>

        <!-- Gráficos Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
            <!-- Gráfico Abertos -->
            <div class="bg-white/80 backdrop-blur-xl border border-slate-200 p-6 rounded-2xl shadow-sm">
                <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <span class="w-2 h-6 bg-blue-500 rounded-full"></span>
                    Chamados Abertos
                </h2>
                <div class="relative h-64">
                    <canvas id="chartAbertos"></canvas>
                </div>
            </div>

            <!-- Gráfico Pendentes -->
            <div class="bg-white/80 backdrop-blur-xl border border-slate-200 p-6 rounded-2xl shadow-sm">
                <h2 class="text-lg font-bold text-slate-800 mb-6 flex items-center gap-2">
                    <span class="w-2 h-6 bg-yellow-500 rounded-full"></span>
                    Chamados Pendentes
                </h2>
                <div class="relative h-64">
                    <canvas id="chartPendentes"></canvas>
                </div>
            </div>
        </div>

        <!-- Tabela de Usuários -->
        <div class="bg-white/80 backdrop-blur-xl border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
            <div class="px-6 py-5 border-b border-slate-100 bg-slate-50/50">
                <h2 class="text-lg font-bold text-slate-800">Performance da Equipe</h2>
                <p class="text-sm text-slate-500">Usuários com mais chamados atribuídos.</p>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Usuário</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Atribuído</th>
                            <th class="px-6 py-4 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-50">
                        @forelse($assignedUsers as $user)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <div class="h-8 w-8 rounded-full bg-gradient-to-br from-blue-500 to-blue-600 text-white flex items-center justify-center font-bold text-xs shadow-sm">{{ strtoupper(substr($user->name, 0, 2)) }}</div>
                                    <span class="text-sm font-medium text-slate-700">{{ $user->name }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-bold bg-slate-100 text-slate-700">
                                    {{ $user->assigned_tickets_count }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <span class="inline-flex items-center gap-1.5 px-2 py-1 rounded-full text-xs font-medium bg-green-50 text-green-700 border border-green-100">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Ativo
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-slate-500">
                                Nenhum técnico com chamados atribuídos
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Script de Inicialização dos Gráficos (Dummy Data) -->
    <script>
        const chartConfig = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { grid: { display: false } },
                y: { beginAtZero: true, border: { dash: [4, 4] }, grid: { color: '#f1f5f9' } }
            },
            elements: {
                line: { tension: 0.4, borderWidth: 3 },
                point: { radius: 4, hitRadius: 10, hoverRadius: 6 }
            }
        };

        const labels = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'];

        function createChart(id, color, bgColor, data) {
            new Chart(document.getElementById(id), {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        borderColor: color,
                        backgroundColor: bgColor,
                        fill: true,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: color,
                    }]
                },
                options: chartConfig
            });
        }

        // Renderizando com dados fictícios e cores do tema
        createChart('chartAbertos', '#3b82f6', 'rgba(59, 130, 246, 0.1)', [12, 19, 3, 5, 2, 3]);
        createChart('chartPendentes', '#eab308', 'rgba(234, 179, 8, 0.1)', [2, 3, 20, 5, 1, 4]);
    </script>
</main>

</div>
@endsection