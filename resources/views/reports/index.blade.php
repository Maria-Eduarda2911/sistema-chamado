@extends('layouts.app')

@section('content')
    <!-- Fundo Abstrato (Apenas tela, não sai na impressão) -->
    <div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none no-print">
        <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] rounded-full bg-red-600/5 blur-[100px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] rounded-full bg-orange-500/5 blur-[100px]"></div>
    </div>

    <main class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        <!-- Barra de Ações (Flutuante no topo - Não imprime) -->
        <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4 no-print">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Relatórios do Sistema</h1>
                <p class="text-slate-500 text-sm">Visualize, imprima ou exporte os indicadores de desempenho.</p>
            </div>
            <div class="flex gap-3">
                <button id="printBtn" class="flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 text-slate-700 rounded-xl hover:bg-slate-50 hover:text-blue-600 transition-colors shadow-sm font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Imprimir
                </button>
                <button id="downloadBtn" class="flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors shadow-lg shadow-red-500/20 font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                    Baixar PDF
                </button>
            </div>
        </div>

        <!-- O RELATÓRIO (Folha A4 Digital) -->
        <div id="report-content" class="report-container bg-white w-full p-10 rounded-xl shadow-2xl shadow-slate-200/50 border border-slate-100 relative overflow-hidden">
            
            <!-- Marca d'água decorativa -->
            <div class="absolute top-0 right-0 w-64 h-64 bg-gradient-to-br from-slate-50 to-white -z-10 rounded-bl-full opacity-50 pointer-events-none"></div>

            <!-- Cabeçalho do Documento -->
            <div class="flex items-start justify-between border-b-2 border-red-500 pb-6 mb-8">
                <div class="flex items-center gap-4">
                    <div class="p-3 bg-red-50 rounded-lg">
                        <!-- Logo Laravel / Sistema -->
                        <svg class="h-10 w-10 text-red-600" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M47.982 23.453c.012.044.018.089.018.134v7.071a.516.516 0 0 1-.26.448l-5.934 3.417v6.772a.517.517 0 0 1-.258.447L29.16 48.874c-.029.016-.06.026-.09.037-.012.004-.023.011-.035.015a.519.519 0 0 1-.264 0c-.015-.004-.027-.012-.041-.017-.028-.01-.058-.02-.085-.035l-12.386-7.132a.517.517 0 0 1-.259-.447V20.082c0-.046.006-.091.018-.135.004-.015.013-.028.018-.043.01-.027.019-.055.033-.08.01-.017.024-.03.035-.046.015-.02.029-.042.046-.06.015-.015.034-.026.051-.039.019-.015.035-.032.057-.044l6.194-3.566a.517.517 0 0 1 .515 0l6.194 3.566c.021.013.039.029.057.044.017.013.036.024.05.038.019.02.032.04.047.061.011.016.026.029.035.046.015.025.023.053.034.08.005.015.014.028.017.044a.52.52 0 0 1 .019.134v13.25l5.16-2.972v-6.773a.52.52 0 0 1 .019-.134c.004-.016.012-.03.018-.044.01-.027.019-.055.033-.08.01-.017.024-.03.035-.046.015-.02.028-.042.046-.06.015-.015.034-.025.05-.038.02-.016.037-.033.057-.045l6.195-3.566a.516.516 0 0 1 .515 0l6.194 3.566c.022.013.038.03.058.044.016.013.034.024.05.039.017.018.03.04.046.06.011.016.025.03.034.046.015.025.024.053.034.08.006.015.014.028.018.044zm-1.014 6.907v-5.88L44.8 25.728l-2.994 1.724v5.88l5.162-2.972zm-6.194 10.637v-5.884l-2.945 1.682-8.41 4.8v5.94l11.355-6.538zM17.032 20.975v20.022l11.355 6.537v-5.938l-5.932-3.357-.002-.002-.003-.001c-.02-.012-.036-.028-.055-.043-.016-.012-.035-.023-.049-.037l-.001-.002c-.017-.016-.029-.036-.043-.054-.013-.017-.028-.032-.038-.05l-.001-.002c-.012-.02-.019-.043-.027-.065-.009-.019-.02-.037-.025-.058-.006-.025-.007-.05-.01-.076-.003-.02-.008-.038-.008-.058V23.946L19.2 22.222l-2.168-1.247zm5.678-3.863-5.16 2.97 5.159 2.97 5.16-2.97-5.16-2.97h.001zm2.684 18.537 2.993-1.723V20.975l-2.167 1.247-2.994 1.724v12.951l2.168-1.248zM41.29 20.617l-5.16 2.97 5.16 2.97 5.158-2.97-5.158-2.97zm-.517 6.835-2.994-1.724-2.167-1.248v5.88l2.993 1.723 2.168 1.249v-5.88zm-11.872 13.25 7.568-4.32 3.783-2.16-5.156-2.968-5.936 3.418-5.41 3.115 5.151 2.915z" fill="currentColor" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-slate-900 tracking-tight leading-none">Relatório Executivo</h1>
                        <p class="text-sm text-slate-500 font-medium uppercase tracking-wide mt-1">Gestão de Chamados</p>
                    </div>
                </div>
                <div class="text-right">
                    <div class="text-sm font-semibold text-slate-700">Emissão: {{ now()->format('d/m/Y') }}</div>
                    <div class="text-xs text-slate-500">às {{ now()->format('H:i') }}</div>
                </div>
            </div>

            <!-- Resumo Executivo (Cards) -->
            <div class="mb-10">
                <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 border-l-4 border-red-500 pl-3">Resumo Geral</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    
                    <!-- Total -->
                    <div class="bg-slate-50 p-5 rounded-xl border border-slate-100 flex flex-col justify-between">
                        <p class="text-xs font-semibold text-slate-500 uppercase">Total de Chamados</p>
                        <p class="text-3xl font-bold text-slate-800 mt-2">{{ $stats['total_tickets'] }}</p>
                    </div>

                    <!-- Resolvidos -->
                    <div class="bg-green-50 p-5 rounded-xl border border-green-100 flex flex-col justify-between">
                        <p class="text-xs font-semibold text-green-700 uppercase flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-green-500"></span> Resolvidos
                        </p>
                        <div class="flex items-end justify-between mt-2">
                            <p class="text-3xl font-bold text-green-800">{{ $stats['resolvidos'] }}</p>
                            @php $percent = $stats['total_tickets'] > 0 ? round(($stats['resolvidos'] / $stats['total_tickets']) * 100) : 0; @endphp
                            <span class="text-xs font-bold bg-white text-green-700 px-2 py-1 rounded-full shadow-sm border border-green-200">{{ $percent }}%</span>
                        </div>
                    </div>

                    <!-- Pendentes -->
                    <div class="bg-yellow-50 p-5 rounded-xl border border-yellow-100 flex flex-col justify-between">
                        <p class="text-xs font-semibold text-yellow-700 uppercase flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span> Pendentes
                        </p>
                        <p class="text-3xl font-bold text-yellow-800 mt-2">{{ $stats['pendentes'] }}</p>
                    </div>

                    <!-- Abertos -->
                    <div class="bg-blue-50 p-5 rounded-xl border border-blue-100 flex flex-col justify-between">
                        <p class="text-xs font-semibold text-blue-700 uppercase flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span> Em Aberto
                        </p>
                        <p class="text-3xl font-bold text-blue-800 mt-2">{{ $stats['abertos'] }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                
                <!-- Gráfico -->
                <div class="break-inside-avoid">
                    <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 border-l-4 border-red-500 pl-3">Distribuição Visual</h3>
                    <div class="bg-slate-50 rounded-xl p-6 border border-slate-100 flex items-center justify-center h-64 chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>

                <!-- Detalhes Operacionais -->
                <div class="flex flex-col justify-between break-inside-avoid">
                    <div>
                        <h3 class="text-sm font-bold text-slate-400 uppercase tracking-widest mb-4 border-l-4 border-red-500 pl-3">Métricas de Atenção</h3>
                        
                        <div class="space-y-4">
                            <!-- Alerta Sem Responsável -->
                            <div class="flex items-center justify-between p-4 bg-white rounded-lg border border-slate-200 shadow-sm">
                                <div class="flex items-center gap-3">
                                    <div class="bg-red-100 p-2.5 rounded-full text-red-600">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">Não Atribuídos</p>
                                        <p class="text-xs text-slate-500">Chamados aguardando técnico</p>
                                    </div>
                                </div>
                                <span class="text-2xl font-bold text-red-600">{{ $stats['sem_responsavel'] }}</span>
                            </div>

                            <!-- Contexto -->
                            <div class="bg-white border border-slate-200 rounded-lg p-4 shadow-sm">
                                <h4 class="text-xs font-semibold text-slate-400 uppercase mb-3">Metadados do Relatório</h4>
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div>
                                        <p class="text-slate-500 text-xs">Solicitado Por</p>
                                        <p class="text-slate-900 font-semibold">{{ Auth::user()->name }}</p>
                                        <p class="text-slate-400 text-xs">{{ Auth::user()->email }}</p>
                                    </div>
                                    <div>
                                        <p class="text-slate-500 text-xs">Período Analisado</p>
                                        <p class="text-slate-900 font-semibold">Últimos 30 dias</p>
                                        <p class="text-slate-400 text-xs">{{ now()->subDays(30)->format('d/m') }} a {{ now()->format('d/m') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Rodapé Institucional -->
            <div class="mt-12 pt-6 border-t border-slate-100 text-center">
                <p class="text-[10px] text-slate-400 uppercase tracking-widest font-semibold mb-1">Documento Gerado Automaticamente pelo Sistema</p>
                <p class="text-[10px] text-slate-300 font-mono">HASH: SG-{{ now()->year }}-{{ str_pad($stats['total_tickets'], 6, '0', STR_PAD_LEFT) }}-{{ \Illuminate\Support\Str::random(8) }}</p>
            </div>

        </div>
    </main>
@endsection

@push('styles')
<style>
    @media print {
        @page {
            size: A4 portrait;
            margin: 10mm;
        }
        body {
            background-color: white !important;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        /* Ocultar elementos de navegação e fundo na impressão */
        .no-print, nav, header, .fixed, footer {
            display: none !important;
        }
        /* Ajustar o container para a largura do papel */
        .report-container {
            box-shadow: none !important;
            border: none !important;
            padding: 0 !important;
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
        }
        /* Garantir que gráficos apareçam */
        .chart-container canvas {
            max-height: 300px !important;
            width: 100% !important;
        }
        /* Evitar quebras de página ruins */
        .break-inside-avoid {
            page-break-inside: avoid;
        }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Configuração do Gráfico (Design Moderno e Limpo)
        const ctx = document.getElementById('statusChart');
        if (ctx) {
            new Chart(ctx.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Abertos', 'Pendentes', 'Resolvidos', 'Sem Responsável'],
                    datasets: [{
                        data: [
                            {{ $stats['abertos'] }},
                            {{ $stats['pendentes'] }},
                            {{ $stats['resolvidos'] }},
                            {{ $stats['sem_responsavel'] }}
                        ],
                        backgroundColor: [
                            '#3b82f6', // Blue-500
                            '#eab308', // Yellow-500
                            '#22c55e', // Green-500
                            '#ef4444'  // Red-500
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    cutout: '75%',
                    plugins: {
                        legend: {
                            position: 'right',
                            labels: {
                                font: { family: "'Inter', sans-serif", size: 11 },
                                usePointStyle: true,
                                padding: 20,
                                boxWidth: 8
                            }
                        }
                    }
                }
            });
        }

        // Configuração do PDF
        const pdfOptions = {
            margin: 10,
            filename: `relatorio-chamados-${new Date().toISOString().slice(0, 10)}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, useCORS: true, logging: false },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        // Event Listeners
        document.getElementById('downloadBtn')?.addEventListener('click', () => {
            const element = document.getElementById('report-content');
            // Feedback visual rápido
            const btn = document.getElementById('downloadBtn');
            const originalText = btn.innerHTML;
            btn.innerHTML = 'Gerando...';
            btn.disabled = true;
            
            html2pdf().set(pdfOptions).from(element).save().then(() => {
                btn.innerHTML = originalText;
                btn.disabled = false;
            });
        });

        document.getElementById('printBtn')?.addEventListener('click', () => {
            window.print();
        });
    });
</script>
@endpush