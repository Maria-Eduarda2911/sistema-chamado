<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar E-mail - Sistema de Chamados</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
    </style>
</head>
<body class="bg-[#450a0a] min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Elementos de fundo abstratos -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <div class="absolute -top-[30%] -left-[10%] w-[70%] h-[70%] rounded-full bg-red-600/20 blur-[100px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[60%] h-[60%] rounded-full bg-orange-500/10 blur-[100px]"></div>
    </div>

    <!-- Container Principal -->
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-5xl flex overflow-hidden min-h-[600px]">
        
        <!-- Lado Esquerdo (Visual) - Igual ao Login/Register -->
        <div class="hidden lg:flex w-1/2 bg-black relative flex-col justify-between p-12 text-white bg-[url('https://images.unsplash.com/photo-1542831371-29b0f74f9713?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center">
            <div class="absolute inset-0 bg-red-700/60 mix-blend-multiply"></div>
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-red-900/20 to-black/60"></div>
            
            <div class="relative z-10 h-full flex flex-col justify-between">
                <div class="flex items-center gap-3">
                    <img src="https://laravel.com/img/logomark.min.svg" alt="Logo Laravel" class="h-10 w-10">
                    <span class="text-2xl font-bold tracking-tight">Sistema de Chamados</span>
                </div>

                <div class="space-y-4">
                    <div class="glass-card p-4 rounded-xl flex items-center gap-4 transition hover:bg-white/20">
                        <div class="bg-red-500/20 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-sm font-medium">Verifique seu e-mail para garantir a segurança da sua conta</p>
                    </div>
                </div>

                <div class="text-xs text-red-200">
                    &copy; 2025 Sistema de Chamados.
                </div>
            </div>
        </div>

        <!-- Lado Direito (Conteúdo de Verificação) -->
        <div class="w-full lg:w-1/2 bg-white p-8 md:p-12 flex flex-col justify-center relative">
            
            <div class="max-w-sm mx-auto w-full">
                <!-- Ícone de E-mail -->
                <div class="mb-6">
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path></svg>
                    </div>
                    <h2 class="text-3xl font-bold text-slate-900 mb-4">Verifique seu e-mail</h2>
                    
                    <div class="text-slate-600 text-sm leading-relaxed mb-6">
                        {{ __('Obrigado por se inscrever! Antes de começar, você poderia verificar seu endereço de e-mail clicando no link que acabamos de enviar para você? Se você não recebeu o e-mail, teremos prazer em enviar outro.') }}
                    </div>

                    @if (session('status') == 'verification-link-sent')
                        <div class="mb-6 text-sm font-medium text-green-600 bg-green-50 p-4 rounded-lg border border-green-100 flex items-start">
                            <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ __('Um novo link de verificação foi enviado para o endereço de e-mail fornecido durante o registro.') }}
                        </div>
                    @endif
                </div>

                <div class="space-y-4">
                    <!-- Botão de Reenviar -->
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg shadow-red-500/30 transition-all hover:transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            {{ __('Reenviar E-mail de Verificação') }}
                        </button>
                    </form>

                    <!-- Botão de Logout -->
                    <form method="POST" action="{{ route('logout') }}" class="text-center">
                        @csrf
                        <button type="submit" class="text-sm font-medium text-slate-500 hover:text-slate-800 transition-colors flex items-center justify-center gap-2 mx-auto mt-4">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                            {{ __('Sair da conta') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>