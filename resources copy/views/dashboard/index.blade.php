@extends('layouts.app')

@section('content')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Cabeçalho -->
        <h1 class="text-3xl font-semibold text-gray-800">Dashboard</h1>
        <div class="mt-4">

            <!-- Estatísticas -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 justify-center text-center">
                <div class="bg-white p-6 center rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-800">Chamados Abertos</h3>
                    <p class="mt-2 text-3xl font-bold text-blue-600">{{ $stats['abertos'] }}</p>
                </div>
                <div class="bg-white p-6 center rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-800">Chamados Pendentes</h3>
                    <p class="mt-2 text-3xl font-bold text-yellow-500">{{ $stats['pendentes'] }}</p>
                </div>
                <div class="bg-white p-6 center rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-800">Chamados Resolvidos</h3>
                    <p class="mt-2 text-3xl font-bold text-green-600">{{ $stats['resolvidos'] }}</p>
                </div>
                <!-- Chamados Atribuídos -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-800">Chamados sem atribuição</h3>
                    <p class="mt-2 text-3xl font-bold text-red-600">{{ $stats['sem_responsavel'] }}</p>
                </div>

            </div>

            <!-- Gráficos -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-8">
                @foreach(['abertos', 'pendentes', 'fechados', 'totais'] as $key)
                    <div>
                        <h2 class="text-xl font-bold text-gray-800 mb-4">Chamados {{ ucfirst($key) }} Este Ano</h2>
                        <div class="bg-white p-6 rounded-lg shadow">
                            <canvas id="chart{{ ucfirst($key) }}" height="100"></canvas>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Tabela de Usuários com Chamados Atribuídos -->
<div class="mt-12">
    <h2 class="text-xl justify-center font-bold text-gray-800 mb-4">Usuários com Mais Chamados Atribuídos</h2>
    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Usuário</th>
                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Total de Chamados Atribuídos</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if(isset($assignedUsers) && $assignedUsers->isNotEmpty())
                    @foreach($assignedUsers as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-center text-gray-900">{{ $user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-center font-semibold text-gray-900">
                                {{ $user->assigned_tickets_count }} <!-- Agora exibe os chamados atribuídos corretamente -->
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-sm text-gray-500">Nenhum usuário atribuído encontrado.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>

    </main>
@endsection
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const meses = {!! json_encode($chartLabels) !!};

        function criarGrafico(id, label, dados) {
            const ctx = document.getElementById(id).getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: meses,
                    datasets: [{ label, data: dados, fill: true, tension: 0.4 }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { grid: { display: false } },
                        y: { grid: { display: true } }
                    }
                }
            });
        }

        criarGrafico('chartAbertos', 'Abertos', {!! json_encode($chartData['abertos']) !!});
        criarGrafico('chartPendentes', 'Pendentes', {!! json_encode($chartData['pendentes']) !!});
        criarGrafico('chartFechados', 'Fechados', {!! json_encode($chartData['fechados']) !!});
        criarGrafico('chartTotais', 'Totais', {!! json_encode($chartData['totais']) !!});
    </script>

@endpush