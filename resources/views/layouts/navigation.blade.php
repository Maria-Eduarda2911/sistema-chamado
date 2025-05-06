
<nav class="bg-white shadow-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <!-- Esquerda: Logo e Nome do Sistema -->
            <div class="flex items-center">
                <div class="flex-shrink-0 flex items-center">
                    <!-- Ícone do Laravel com tamanho e cor ajustados -->
                    <svg class="h-8 w-8 text-red-600" viewBox="0 0 54 54" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M47.982 23.453c.012.044.018.089.018.134v7.071a.516.516 0 0 1-.26.448l-5.934 3.417v6.772a.517.517 0 0 1-.258.447L29.16 48.874c-.029.016-.06.026-.09.037-.012.004-.023.011-.035.015a.519.519 0 0 1-.264 0c-.015-.004-.027-.012-.041-.017-.028-.01-.058-.02-.085-.035l-12.386-7.132a.517.517 0 0 1-.259-.447V20.082c0-.046.006-.091.018-.135.004-.015.013-.028.018-.043.01-.027.019-.055.033-.08.01-.017.024-.03.035-.046.015-.02.029-.042.046-.06.015-.015.034-.026.051-.039.019-.015.035-.032.057-.044l6.194-3.566a.517.517 0 0 1 .515 0l6.194 3.566c.021.013.039.029.057.044.017.013.036.024.05.038.019.02.032.04.047.061.011.016.026.029.035.046.015.025.023.053.034.08.005.015.014.028.017.044a.52.52 0 0 1 .019.134v13.25l5.16-2.972v-6.773a.52.52 0 0 1 .019-.134c.004-.016.012-.03.018-.044.01-.027.019-.055.033-.08.01-.017.024-.03.035-.046.015-.02.028-.042.046-.06.015-.015.034-.025.05-.038.02-.016.037-.033.057-.045l6.195-3.566a.516.516 0 0 1 .515 0l6.194 3.566c.022.013.038.03.058.044.016.013.034.024.05.039.017.018.03.04.046.06.011.016.025.03.034.046.015.025.024.053.034.08.006.015.014.028.018.044zm-1.014 6.907v-5.88L44.8 25.728l-2.994 1.724v5.88l5.162-2.972zm-6.194 10.637v-5.884l-2.945 1.682-8.41 4.8v5.94l11.355-6.538zM17.032 20.975v20.022l11.355 6.537v-5.938l-5.932-3.357-.002-.002-.003-.001c-.02-.012-.036-.028-.055-.043-.016-.012-.035-.023-.049-.037l-.001-.002c-.017-.016-.029-.036-.043-.054-.013-.017-.028-.032-.038-.05l-.001-.002c-.012-.02-.019-.043-.027-.065-.009-.019-.02-.037-.025-.058-.006-.025-.007-.05-.01-.076-.003-.02-.008-.038-.008-.058V23.946L19.2 22.222l-2.168-1.247zm5.678-3.863-5.16 2.97 5.159 2.97 5.16-2.97-5.16-2.97h.001zm2.684 18.537 2.993-1.723V20.975l-2.167 1.247-2.994 1.724v12.951l2.168-1.248zM41.29 20.617l-5.16 2.97 5.16 2.97 5.158-2.97-5.158-2.97zm-.517 6.835-2.994-1.724-2.167-1.248v5.88l2.993 1.723 2.168 1.249v-5.88zm-11.872 13.25 7.568-4.32 3.783-2.16-5.156-2.968-5.936 3.418-5.41 3.115 5.151 2.915z" fill="currentColor"/>
                    </svg>
                    <span class="ml-2 text-xl font-bold text-gray-900"></span>
                </div>
            </div>

            <!-- Links Centralizados -->
            <div class="hidden sm:flex space-x-8">
                <a href="/dashboard" class="text-gray-600 font-medium hover:text-blue-600 transition-all duration-300">
                    Dashboard
                </a>
                <a href="/tickets" class="text-gray-600 font-medium hover:text-blue-600 transition-all duration-300">
                    Chamados
                </a>
            </div>

        <!-- Direita: Avatar do Usuário e Dropdown -->
<div class="flex items-center space-x-4" x-data="{ open: false }" @click.away="open = false">
    <div class="relative">
        <!-- Botão do Avatar -->
        <button @click="open = !open" 
                class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center hover:bg-blue-200 transition-colors cursor-pointer"
                aria-haspopup="true"
                :aria-expanded="open">
            <span class="text-sm font-medium text-blue-600">
                {{ strtoupper(substr(Auth::user()->name, 0, 2)) }}
            </span>
        </button>

        <!-- Dropdown Menu -->
        <div x-show="open"
             x-cloak
             x-transition:enter="transition ease-out duration-100"
             x-transition:enter-start="transform opacity-0 scale-95"
             x-transition:enter-end="transform opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-75"
             x-transition:leave-start="transform opacity-100 scale-100"
             x-transition:leave-end="transform opacity-0 scale-95"
             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 ring-1 ring-black ring-opacity-5 focus:outline-none z-50">

            @can('admin', Auth::user())
    <a href="{{ route('admin.config') }}" 
       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
        Configurações Admin
    </a>
@endcan
            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 transition-colors">
                    Sair
                </button>
            </form>
        </div>
    </div>
</div>
        </div>
    </div>
</nav>
