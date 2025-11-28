<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Acesso Negado</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-50 relative overflow-hidden h-screen w-full flex items-center justify-center">

    <!-- Fundo Geral (Blobs) -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
        <div class="absolute top-[20%] left-[20%] w-[40%] h-[40%] rounded-full bg-red-600/5 blur-[120px]"></div>
        <div class="absolute bottom-[20%] right-[20%] w-[40%] h-[40%] rounded-full bg-orange-500/5 blur-[120px]"></div>
    </div>

    <!-- Card Central -->
    <div class="relative mx-4">
        <!-- Efeito de brilho atrás do card -->
        <div class="absolute -inset-1 bg-gradient-to-r from-red-500 to-orange-500 rounded-3xl blur opacity-20"></div>
        
        <div class="relative bg-white/80 backdrop-blur-2xl border border-white/50 p-8 md:p-12 rounded-3xl shadow-2xl max-w-lg w-full text-center">
            
            <!-- Ícone Animado/Estilizado -->
            <div class="mx-auto w-24 h-24 bg-red-50 rounded-full flex items-center justify-center mb-6 relative group">
                <div class="absolute inset-0 bg-red-500 rounded-full opacity-0 group-hover:opacity-10 transition-opacity duration-300 animate-pulse"></div>
                <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
                <!-- Badge de Erro -->
                <div class="absolute -top-2 -right-2 bg-slate-900 text-white text-xs font-bold px-2 py-1 rounded-lg border-2 border-white shadow-sm">
                    403
                </div>
            </div>

            <!-- Títulos e Textos -->
            <h1 class="text-3xl font-bold text-slate-900 mb-2 tracking-tight">Acesso Restrito</h1>
            <p class="text-slate-500 mb-8 leading-relaxed">
                Ops! Parece que você não tem as permissões necessárias para acessar esta área do sistema.
            </p>

            <!-- Ações -->
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <button class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-slate-900 text-white hover:bg-slate-800 transition-all font-medium shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Voltar
                </button>
                
                <button class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-white text-slate-700 border border-slate-200 hover:bg-slate-50 transition-all font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Ir para o Início
                </button>
            </div>
            
            <p class="mt-8 text-xs text-slate-400">
                Se você acredita que isso é um erro, contate o administrador.
            </p>
        </div>
    </div>

</body>
</html>