@extends('layouts.app')

@section('content')
  <div class="report-container bg-white mx-auto p-6 rounded-lg">
    <!-- Cabeçalho -->
    <div class="flex items-center justify-between mb-8 border-b pb-4">
    <div class="flex items-center gap-4">
      <svg class="h-10 w-10 text-red-600" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd"
        d="M47.982 23.453c.012.044.018.089.018.134v7.071a.516.516 0 0 1-.26.448l-5.934 3.417v6.772a.517.517 0 0 1-.258.447L29.16 48.874c-.029.016-.06.026-.09.037-.012.004-.023.011-.035.015a.519.519 0 0 1-.264 0c-.015-.004-.027-.012-.041-.017-.028-.01-.058-.02-.085-.035l-12.386-7.132a.517.517 0 0 1-.259-.447V20.082c0-.046.006-.091.018-.135.004-.015.013-.028.018-.043.01-.027.019-.055.033-.08.01-.017.024-.03.035-.046.015-.02.029-.042.046-.06.015-.015.034-.026.051-.039.019-.015.035-.032.057-.044l6.194-3.566a.517.517 0 0 1 .515 0l6.194 3.566c.021.013.039.029.057.044.017.013.036.024.05.038.019.02.032.04.047.061.011.016.026.029.035.046.015.025.023.053.034.08.005.015.014.028.017.044a.52.52 0 0 1 .019.134v13.25l5.16-2.972v-6.773a.52.52 0 0 1 .019-.134c.004-.016.012-.03.018-.044.01-.027.019-.055.033-.08.01-.017.024-.03.035-.046.015-.02.028-.042.046-.06.015-.015.034-.025.05-.038.02-.016.037-.033.057-.045l6.195-3.566a.516.516 0 0 1 .515 0l6.194 3.566c.022.013.038.03.058.044.016.013.034.024.05.039.017.018.03.04.046.06.011.016.025.03.034.046.015.025.024.053.034.08.006.015.014.028.018.044zm-1.014 6.907v-5.88L44.8 25.728l-2.994 1.724v5.88l5.162-2.972zm-6.194 10.637v-5.884l-2.945 1.682-8.41 4.8v5.94l11.355-6.538zM17.032 20.975v20.022l11.355 6.537v-5.938l-5.932-3.357-.002-.002-.003-.001c-.02-.012-.036-.028-.055-.043-.016-.012-.035-.023-.049-.037l-.001-.002c-.017-.016-.029-.036-.043-.054-.013-.017-.028-.032-.038-.05l-.001-.002c-.012-.02-.019-.043-.027-.065-.009-.019-.02-.037-.025-.058-.006-.025-.007-.05-.01-.076-.003-.02-.008-.038-.008-.058V23.946L19.2 22.222l-2.168-1.247zm5.678-3.863-5.16 2.97 5.159 2.97 5.16-2.97-5.16-2.97h.001zm2.684 18.537 2.993-1.723V20.975l-2.167 1.247-2.994 1.724v12.951l2.168-1.248zM41.29 20.617l-5.16 2.97 5.16 2.97 5.158-2.97-5.158-2.97zm-.517 6.835-2.994-1.724-2.167-1.248v5.88l2.993 1.723 2.168 1.249v-5.88zm-11.872 13.25 7.568-4.32 3.783-2.16-5.156-2.968-5.936 3.418-5.41 3.115 5.151 2.915z"
        fill="currentColor" />
      </svg>
      <div>
      <h1 class="text-2xl font-bold">Sistema de Chamados</h1>
      <div class="text-sm text-gray-600">Relatório Técnico Oficial</div>
      </div>
    </div>
    <div class="text-right text-sm">
      <p>{{ now()->format('d/m/Y H:i') }}</p>
      <p>{{ Auth::user()->name }}</p>
    </div>
    </div>

    <!-- Botões -->
    <div class="no-print flex justify-center gap-4 mb-8">
    <button id="downloadBtn" class="bg-blue-600 text-white px-4 py-2 rounded">Baixar PDF</button>
    <button id="printBtn" class="bg-green-600 text-white px-4 py-2 rounded">Imprimir</button>
    </div>

    <!-- Conteúdo Principal -->
    <div class="space-y-6">


    <!-- Seção de Gráficos -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
      <div class="p-4 border rounded">
      <h2 class="text-xl font-semibold mb-4">Distribuição de Chamados</h2>
      <div class="chart-container">
        <canvas id="statusChart" style="height: 250px;"></canvas>
      </div>
      </div>

      <div class="p-4 border rounded">
      <h2 class="text-xl font-semibold mb-4">Estatísticas Operacionais</h2>
      <div class="grid grid-cols-2 gap-4 text-sm">
        <div class="bg-gray-50 p-3 rounded">
        <p class="font-medium">Período Analisado</p>
        <p class="text-blue-600">{{ now()->subMonth()->format('d/m/Y') }} - {{ now()->format('d/m/Y') }}</p>
        </div>
        <div class="bg-gray-50 p-3 rounded">
        <p class="font-medium">Total de Ocorrências</p>
        <p class="text-green-600">{{ $stats['total_tickets'] }}</p>
        </div>
        <div class="bg-gray-50 p-3 rounded">
        <p class="font-medium">Chamados Abertos</p>
        <p class="text-red-600">{{ $stats['abertos'] }}</p>
        </div>
        <div class="bg-gray-50 p-3 rounded">
        <p class="font-medium">Pendentes</p>
        <p class="text-yellow-600">{{ $stats['pendentes'] }}</p>
        </div>
      </div>
      </div>
    </div>

    <!-- Detalhes Técnicos -->
    <div class="p-4 border rounded bg-gray-50">
      <h2 class="text-xl font-semibold mb-4">Contexto Operacional</h2>
      <div class="grid grid-cols-3 gap-4 text-sm">
      <div>
        <p class="font-medium">Responsável Técnico</p>
        <p>{{ Auth::user()->name }}</p>
        <p>{{ Auth::user()->position ?? '' }}</p>
      </div>
      <div>
        <p class="font-medium">Sem Responsável</p>
        <p class="text-red-600">{{ $stats['sem_responsavel'] }}</p>
      </div>
      <div>
        <p class="font-medium">Resolvidos</p>
        <p class="text-green-600">{{ $stats['resolvidos'] }}</p>
      </div>
      </div>
    </div>

    <!-- Rodapé Institucional -->
    <div class="p-4 border-t mt-6 text-center text-sm text-gray-600">
      <p>Protocolo: SG-{{ now()->year }}-{{ str_pad($stats['total_tickets'], 5, '0', STR_PAD_LEFT) }}</p>
      <p class="italic">Documento registrado em {{ now()->format('d/m/Y H:i:s') }} - Válido por 5 anos</p>
    </div>
    </div>
  </div>
@endsection

@push('styles')
  <style>
    @media print {
    @page {
      size: A4 portrait;
      margin: 15mm 10mm;
    }

    body {
      font-size: 10pt !important;
      line-height: 1.4;
      background: white !important;
    }

    .report-container {
      width: 900% !important;
      padding: 0 !important;
      margin: 0 !important;
      box-shadow: none !important;
    }

    .chart-container canvas {
      height: 180px !important;
      max-width: 80% !important;
      margin: 0 auto;
    }

    .no-print {
      display: none !important;
    }

    .grid {
      display: block !important;
    }

    .border {
      border-color: #ccc !important;
    }
    }
  </style>
@endpush

@push('scripts')
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', () => {
    // Configuração do Gráfico
    new Chart(document.getElementById('statusChart'), {
      type: 'pie',
      data: {
      labels: ['Abertos', 'Pendentes', 'Resolvidos', 'Sem Responsável'],
      datasets: [{
        data: [
        {{ $stats['abertos'] }},
        {{ $stats['pendentes'] }},
        {{ $stats['resolvidos'] }},
        {{ $stats['sem_responsavel'] }}
        ],
        backgroundColor: ['#3B82F6', '#F59E0B', '#10B981', '#64748B']
      }]
      },
      options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
        position: 'bottom',
        labels: {
          font: {
          size: 10
          }
        }
        }
      }
      }
    });

    // Configuração do PDF
    const pdfOptions = {
      margin: [15, 10],
      filename: `relatorio-${new Date().toISOString().slice(0, 10)}.pdf`,
      html2canvas: {
      scale: 2,
      logging: true,
      useCORS: true
      },
      jsPDF: {
      unit: 'mm',
      format: 'a4',
      orientation: 'portrait'
      }
    };

    // Event Listeners
    document.getElementById('downloadBtn')?.addEventListener('click', () => {
      html2pdf().set(pdfOptions).from(document.querySelector('.report-container')).save();
    });

    document.getElementById('printBtn')?.addEventListener('click', () => {
      window.print();
    });
    });
  </script>
@endpush