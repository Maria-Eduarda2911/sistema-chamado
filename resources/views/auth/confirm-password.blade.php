<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Senha - Sistema de Chamados</title>
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
        
        <!-- Lado Esquerdo (Visual) -->
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
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <p class="text-sm font-medium">Área segura. Confirme sua identidade para prosseguir.</p>
                    </div>
                </div>

                <div class="text-xs text-red-200">
                    &copy; 2025 Sistema de Chamados.
                </div>
            </div>
        </div>

        <!-- Lado Direito (Formulário) -->
        <div class="w-full lg:w-1/2 bg-white p-8 md:p-12 flex flex-col justify-center relative">
            
            <div class="max-w-sm mx-auto w-full">
                <!-- Ícone de Cadeado -->
                <div class="w-12 h-12 bg-red-50 rounded-xl flex items-center justify-center mb-6">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>

                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-slate-900 mb-2">Confirmação Necessária</h2>
                    <p class="text-slate-500 text-sm leading-relaxed">
                        {{ __('Esta é uma área segura do aplicativo. Por favor, confirme sua senha antes de continuar.') }}
                    </p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}" class="space-y-5">
                    @csrf

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Senha Atual</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 outline-none transition-all pl-10" required autocomplete="current-password">
                            <div class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg shadow-red-500/30 transition-all hover:transform hover:-translate-y-0.5 mt-2 flex justify-center items-center gap-2">
                        {{ __('Confirmar') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>