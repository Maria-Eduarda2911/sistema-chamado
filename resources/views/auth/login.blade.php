<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Chamados</title>
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
<!-- Fundo escuro com gradiente avermelhado (Tema Laravel) -->
<body class="bg-[#450a0a] min-h-screen flex items-center justify-center p-4 relative overflow-hidden">
    
    <!-- Elementos de fundo abstratos (Curves) -->
    <div class="absolute top-0 left-0 w-full h-full overflow-hidden -z-10">
        <!-- Alterado para vermelho/laranja -->
        <div class="absolute -top-[30%] -left-[10%] w-[70%] h-[70%] rounded-full bg-red-600/20 blur-[100px]"></div>
        <div class="absolute top-[20%] -right-[10%] w-[60%] h-[60%] rounded-full bg-orange-500/10 blur-[100px]"></div>
    </div>

    <!-- Container Principal (Card Central) -->
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-5xl flex overflow-hidden min-h-[600px]">
        
        <!-- Lado Esquerdo (Visual/Marketing) -->
        <div class="hidden lg:flex w-1/2 bg-black relative flex-col justify-between p-12 text-white bg-[url('https://images.unsplash.com/photo-1542831371-29b0f74f9713?q=80&w=2070&auto=format&fit=crop')] bg-cover bg-center">
            <!-- Overlay vermelho ajustado -->
            <div class="absolute inset-0 bg-red-700/60 mix-blend-multiply"></div>
            <!-- Gradiente escuro -->
            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-red-900/20 to-black/60"></div>
            
            <div class="relative z-10 h-full flex flex-col justify-between">
                <div class="flex items-center gap-3">
                    <img src="https://laravel.com/img/logomark.min.svg" alt="Logo Laravel" class="h-10 w-10">
                    <span class="text-2xl font-bold tracking-tight">Sistema de Chamados</span>
                </div>

                <div class="space-y-4">
                    <div class="glass-card p-4 rounded-xl flex items-center gap-4 transition hover:bg-white/20">
                        <div class="bg-red-500/20 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-sm font-medium">Monitore e gerencie seus chamados em tempo real</p>
                    </div>

                    <div class="glass-card p-4 rounded-xl flex items-center gap-4 transition hover:bg-white/20">
                        <div class="bg-red-500/20 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                        <p class="text-sm font-medium">Atendimento rápido e eficiente para seus clientes</p>
                    </div>
                    
                    <div class="glass-card p-4 rounded-xl flex items-center gap-4 transition hover:bg-white/20">
                        <div class="bg-red-500/20 p-2 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <p class="text-sm font-medium">Segurança total e controle de acesso integrado</p>
                    </div>
                </div>

                <div class="text-xs text-red-200">
                    &copy; 2025 Sistema de Chamados. Todos os direitos reservados.
                </div>
            </div>
        </div>

        <!-- Lado Direito (Formulário) -->
        <div class="w-full lg:w-1/2 bg-white p-8 md:p-12 flex flex-col justify-center relative">
            
            <div class="max-w-sm mx-auto w-full">
                <div class="mb-10">
                    <h2 class="text-3xl font-bold text-slate-900 mb-2">Bem vindo</h2>
                    <p class="text-slate-500">Conecte-se para acessar o painel de suporte.</p>
                </div>

                <!-- CORREÇÃO AQUI: Adicionado a rota correta e descomentado o @csrf -->
                <form action="{{ route('login') }}" method="POST" class="space-y-6">
                    @csrf 

                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1">E-mail</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 outline-none transition-all" placeholder="seu@email.com" required>
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1">Senha</label>
                        <div class="relative">
                            <input type="password" id="password" name="password" class="w-full px-4 py-3 rounded-lg bg-slate-50 border border-slate-200 focus:border-red-500 focus:bg-white focus:ring-2 focus:ring-red-200 outline-none transition-all" placeholder="••••••••" required>
                            <button type="button" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-red-600 focus:ring-red-500">
                            <span class="text-sm text-slate-600">Manter conectado</span>
                        </label>
                        <a href="{{ route('password.request') }}" class="text-sm font-medium text-red-600 hover:text-red-700">Esqueceu a senha?</a>
                    </div>

                    <button type="submit" class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg shadow-red-500/30 transition-all hover:transform hover:-translate-y-0.5">
                        Entrar
                    </button>
                </form>

                <div class="mt-8">
                    <div class="relative">
                        <div class="absolute inset-0 flex items-center">
                            <div class="w-full border-t border-slate-200"></div>
                        </div>
                        <div class="relative flex justify-center text-sm">
                            <span class="px-2 bg-white text-slate-500">Ou conecte-se com</span>
                        </div>
                    </div>

                    <div class="mt-6">
                        <button type="button" class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-slate-200 rounded-lg text-slate-700 hover:bg-slate-50 hover:border-slate-300 transition-all font-medium">
                            <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M23.766 12.2764C23.766 11.4607 23.6999 10.6406 23.5588 9.83807H12.24V14.4591H18.7217C18.4528 15.9494 17.5885 17.2678 16.323 18.1056V21.1039H20.19C22.4608 19.0139 23.766 15.9274 23.766 12.2764Z" fill="#4285F4"/>
                                <path d="M12.2401 24.0008C15.4766 24.0008 18.2059 22.9382 20.1945 21.1039L16.3275 18.1055C15.2517 18.8375 13.8627 19.252 12.2445 19.252C9.11388 19.252 6.45946 17.1399 5.50705 14.3003H1.5166V17.3912C3.55371 21.4434 7.7029 24.0008 12.2401 24.0008Z" fill="#34A853"/>
                                <path d="M5.50253 14.3003C5.00236 12.8199 5.00236 11.1799 5.50253 9.69951V6.60861H1.51649C-0.18551 10.0056 -0.18551 14.0004 1.51649 17.3974L5.50253 14.3003Z" fill="#FBBC05"/>
                                <path d="M12.2401 4.74966C13.9509 4.7232 15.6044 5.36697 16.8434 6.54867L20.2695 3.12262C18.1001 1.0855 15.2208 -0.034466 12.2401 0.000808666C7.7029 0.000808666 3.55371 2.55822 1.5166 6.60861L5.50264 9.69951C6.45064 6.86148 9.10947 4.74966 12.2401 4.74966Z" fill="#EA4335"/>
                            </svg>
                            Google
                        </button>
                    </div>
                </div>

                <div class="mt-8 text-center">
                    <p class="text-sm text-slate-600">
                        Não tem uma conta? 
                        <a href="{{ route('register') }}" class="font-semibold text-red-600 hover:text-red-700 hover:underline transition-all ml-1">
                            Crie sua conta agora
                        </a>
                    </p>
                </div>

            </div>
            
            <div class="mt-10 text-center text-xs text-slate-400 lg:hidden">
                &copy; 2025 Sistema de Chamados
            </div>
        </div>
    </div>

    <div class="absolute bottom-4 right-4 flex gap-4 text-xs text-slate-500/50 hidden lg:flex">
        <a href="#" class="hover:text-slate-400">Termos de Uso</a>
        <a href="#" class="hover:text-slate-400">Privacidade</a>
    </div>
</body>
</html>