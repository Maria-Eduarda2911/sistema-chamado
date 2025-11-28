@extends('layouts.app')

@section('content')
<!-- Fundo Abstrato -->
<div class="fixed top-0 left-0 w-full h-full overflow-hidden -z-10 pointer-events-none">
    <div class="absolute -top-[10%] -left-[10%] w-[50%] h-[50%] rounded-full bg-red-600/5 blur-[100px]"></div>
    <div class="absolute top-[20%] -right-[10%] w-[40%] h-[40%] rounded-full bg-orange-500/5 blur-[100px]"></div>
</div>

<main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <!-- Cabeçalho -->
    <div class="mb-10">
        <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Configurações da Conta</h1>
        <p class="text-slate-500 mt-2">Gerencie suas informações pessoais e segurança.</p>
    </div>

    <!-- Seção 1: Informações Pessoais (Glass Card) -->
    <div class="bg-white/80 backdrop-blur-xl border border-white/50 p-8 rounded-3xl shadow-xl mb-8 relative overflow-hidden">
        <!-- Barra de destaque -->
        <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-red-500 to-orange-500 opacity-80"></div>

        <h2 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-4 mb-6">Informações Pessoais</h2>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Nome -->
                <div class="space-y-2">
                    <label for="name" class="text-sm font-semibold text-slate-700">Nome</label>
                    <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required 
                        class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-2.5 px-4">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Email -->
                <div class="space-y-2">
                    <label for="email" class="text-sm font-semibold text-slate-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required 
                        class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-2.5 px-4">
                    @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>
            </div>

            <!-- Avatar -->
            <div class="flex items-center gap-6 pt-2">
                <div class="shrink-0 relative group">
                    <div class="h-20 w-20 rounded-full bg-gradient-to-br from-red-500 to-orange-500 p-0.5 shadow-lg">
                        <div class="h-full w-full rounded-full bg-white flex items-center justify-center overflow-hidden">
                            <!-- Lógica para mostrar avatar ou iniciais -->
                            <span class="text-2xl font-bold text-red-600">{{ substr($user->name, 0, 2) }}</span>
                        </div>
                    </div>
                </div>
                <div class="flex-1">
                    <label for="avatar" class="text-sm font-semibold text-slate-700 mb-2 block">Alterar Avatar</label>
                    <input id="avatar" type="file" name="avatar" accept=".jpg,.png,.ico"
                        class="block w-full text-sm text-slate-500
                                file:mr-4 file:py-2 file:px-4
                                file:rounded-full file:border-0
                                file:text-xs file:font-semibold
                                file:bg-red-50 file:text-red-700
                                hover:file:bg-red-100 transition-all cursor-pointer">
                    <p class="mt-1 text-xs text-slate-400">JPG, PNG ou ICO. Máx 2MB.</p>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-red-600 to-red-700 text-white font-semibold shadow-lg shadow-red-500/30 hover:shadow-red-500/40 hover:-translate-y-0.5 transition-all">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>

    <!-- Seção 2: Segurança (Glass Card) -->
    <div class="bg-white/80 backdrop-blur-xl border border-white/50 p-8 rounded-3xl shadow-xl relative overflow-hidden">
        <h2 class="text-lg font-bold text-slate-800 border-b border-slate-100 pb-4 mb-6">Segurança</h2>

        <form action="{{ route('password.update') }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <div class="max-w-xl">
                <!-- Senha Atual -->
                <div class="mb-6 space-y-2">
                    <label for="current_password" class="text-sm font-semibold text-slate-700">Senha Atual</label>
                    <input id="current_password" type="password" name="current_password" required 
                        class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-2.5 px-4">
                    @error('current_password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Nova Senha -->
                    <div class="space-y-2">
                        <label for="password" class="text-sm font-semibold text-slate-700">Nova Senha</label>
                        <input id="password" type="password" name="password" required 
                            class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-2.5 px-4">
                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Confirmar Senha -->
                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Confirmar Nova Senha</label>
                        <input id="password_confirmation" type="password" name="password_confirmation" required 
                            class="w-full rounded-xl border-slate-200 bg-slate-50/50 text-slate-700 focus:border-red-500 focus:ring-red-500 focus:ring-opacity-20 transition-all shadow-sm py-2.5 px-4">
                    </div>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-slate-100">
                <button type="submit" class="px-6 py-2.5 rounded-xl border border-slate-200 bg-white text-slate-700 font-semibold hover:bg-slate-50 hover:text-red-600 transition-colors shadow-sm">
                    Alterar Senha
                </button>
            </div>
        </form>
    </div>

</main>
@endsection