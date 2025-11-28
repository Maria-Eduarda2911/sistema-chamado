<nav class="sticky top-0 z-50 w-full bg-white/80 backdrop-blur-xl border-b border-slate-200/80 shadow-sm transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            
            <!-- LADO ESQUERDO: Logo e Menu Principal -->
            <div class="flex items-center gap-4">
                <!-- Logo Area -->
                <div class="flex-shrink-0 flex items-center gap-3 cursor-pointer transition-transform hover:scale-105 duration-200">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
                        <div class="relative">
                            <div class="absolute inset-0 bg-red-500 blur-lg opacity-20 rounded-full"></div>
                            <svg class="h-9 w-9 text-red-600 relative z-10" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M47.982 23.453c.012.044.018.089.018.134v7.071a.516.516 0 0 1-.26.448l-5.934 3.417v6.772a.517.517 0 0 1-.258.447L29.16 48.874c-.029.016-.06.026-.09.037-.012.004-.023.011-.035.015a.519.519 0 0 1-.264 0c-.015-.004-.027-.012-.041-.017-.028-.01-.058-.02-.085-.035l-12.386-7.132a.517.517 0 0 1-.259-.447V20.082c0-.046.006-.091.018-.135.004-.015.013-.028.018-.043.01-.027.019-.055.033-.08.01-.017.024-.03.035-.046.015-.02.028-.042.046-.06.015-.015.034-.025.05-.038.02-.016.037-.033.057-.045l6.194-3.566a.517.517 0 0 1 .515 0l6.194 3.566c.021.013.039.029.057.044.017.013.036.024.05.038.019.02.032.04.047.061.011.016.026.029.035.046.015.02.029-.042.046-.06.015-.015.034-.025.05-.038.02-.016.037-.033.057-.045l6.195-3.566a.516.516 0 0 1 .515 0l6.194 3.566c.022.013.038.03.058.044.016.013.034.024.05.039.017.018.03.04.046.06.011.016.025.03.034.046.015.025.024.053.034.08.006.015.014.028.018.044zm-1.014 6.907v-5.88L44.8 25.728l-2.994 1.724v5.88l5.162-2.972zm-6.194 10.637v-5.884l-2.945 1.682-8.41 4.8v5.94l11.355-6.538zM17.032 20.975v20.022l11.355 6.537v-5.938l-5.932-3.357-.002-.002-.003-.001c-.02-.012-.036-.028-.055-.043-.016-.012-.035-.023-.049-.037l-.001-.002c-.017-.016-.029-.036-.043-.054-.013-.017-.028-.032-.038-.05l-.001-.002c-.012-.02-.019-.043-.027-.065-.009-.019-.02-.037-.025-.058-.006-.025-.007-.05-.01-.076-.003-.02-.008-.038-.008-.058V23.946L19.2 22.222l-2.168-1.247zm5.678-3.863-5.16 2.97 5.159 2.97 5.16-2.97-5.16-2.97h.001zm2.684 18.537 2.993-1.723V20.975l-2.167 1.247-2.994 1.724v12.951l2.168-1.248zM41.29 20.617l-5.16 2.97 5.16 2.97 5.158-2.97-5.158-2.97zm-.517 6.835-2.994-1.724-2.167-1.248v5.88l2.993 1.723 2.168 1.249v-5.88zm-11.872 13.25 7.568-4.32 3.783-2.16-5.156-2.968-5.936 3.418-5.41 3.115 5.151 2.915z" fill="currentColor" />
                            </svg>
                        </div>
                        <span class="text-lg font-bold text-slate-800 tracking-tight hidden md:block">Sistema de Chamados</span>
                    </a>
                </div>

                <!-- Divisória Vertical -->
                <div class="hidden md:block h-6 w-px bg-slate-200 mx-2"></div>

                <!-- Links de Navegação -->
                <div class="hidden md:flex items-center gap-1">
                    <a href="{{ route('dashboard') }}" class="group relative px-4 py-2 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-red-600 bg-red-50' : 'text-slate-500 hover:bg-slate-50 hover:text-red-600' }} rounded-full transition-all duration-200">
                        Dashboard
                    </a>
                    <a href="{{ route('tickets.index') }}" class="group relative px-4 py-2 text-sm font-medium {{ request()->routeIs('tickets.*') ? 'text-red-600 bg-red-50' : 'text-slate-500 hover:bg-slate-50 hover:text-red-600' }} rounded-full transition-all duration-200">
                        Chamados
                    </a>
                    <a href="{{ route('reports.index') }}" class="group relative px-4 py-2 text-sm font-medium {{ request()->routeIs('reports.*') ? 'text-red-600 bg-red-50' : 'text-slate-500 hover:bg-slate-50 hover:text-red-600' }} rounded-full transition-all duration-200">
                        Relatórios
                    </a>
                </div>
            </div>

            <!-- LADO DIREITO: Ações e Perfil -->
            <div class="flex items-center gap-2 sm:gap-4">
                
                <!-- Notificações (Link Ativo) -->
                <a href="{{ route('notifications.index') }}" class="relative p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    @if(auth()->user()->unreadNotifications->count() > 0)
                        <span class="absolute top-2 right-2.5 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white animate-pulse"></span>
                    @endif
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </a>

                <!-- Dropdown Perfil (Alpine.js) -->
                <div x-data="{ open: false }" class="relative" @click.away="open = false">
                    <button @click="open = !open" 
                            class="flex items-center gap-3 p-1 pl-2 pr-1 rounded-full border border-slate-200 hover:bg-white hover:shadow-md hover:border-red-100 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                        
                        <div class="hidden sm:flex flex-col items-end mr-1">
                            <span class="text-xs font-semibold text-slate-700 leading-none">{{ auth()->user()->name }}</span>
                            <span class="text-[10px] text-slate-400 leading-tight">{{ auth()->user()->email }}</span>
                        </div>

                        <!-- Avatar -->
                        <div class="h-9 w-9 rounded-full bg-gradient-to-br from-red-500 to-red-700 flex items-center justify-center text-white shadow-sm ring-2 ring-white">
                            <span class="text-sm font-bold">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                        </div>
                        
                        <!-- Ícone Chevron -->
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 text-slate-400 transition-transform duration-200 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </button>

                    <!-- Menu Suspenso -->
                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95 -translate-y-2"
                         x-transition:enter-end="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="transform opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="transform opacity-0 scale-95 -translate-y-2"
                         class="absolute right-0 mt-3 w-56 bg-white rounded-xl shadow-xl ring-1 ring-black ring-opacity-5 py-2 z-50 origin-top-right overflow-hidden" 
                         x-cloak>
                        
                        <!-- Header Mobile Dropdown -->
                        <div class="px-4 py-3 border-b border-slate-50 sm:hidden">
                            <p class="text-sm text-slate-900 font-bold">Menu</p>
                        </div>

                        @can('admin')
                        <a href="{{ route('admin.config') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                            Painel Admin
                        </a>
                        @endif

                        <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-red-50 hover:text-red-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Configurações
                        </a>

                        <div class="border-t border-slate-100 my-1"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 hover:text-red-800 transition-colors text-left">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                Sair
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</nav>