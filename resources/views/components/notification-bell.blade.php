<div class="relative" x-data="{ 
    open: false, 
    notifications: [], 
    unreadCount: 0,
    loading: false 
}" 
x-init="
    // Buscar notificações ao carregar
    fetchNotifications();
    
    // Atualizar a cada 30 segundos
    setInterval(() => {
        fetchNotifications();
    }, 30000);
"
@click.away="open = false">
    <!-- Botão do Sino -->
    <button @click="open = !open; if(open) fetchNotifications();" 
            class="relative p-2 text-gray-600 hover:text-blue-600 transition-colors duration-200">
        <!-- Ícone do Sino -->
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
            </path>
        </svg>
        
        <!-- Badge de Notificações -->
        <span x-show="unreadCount > 0" 
              x-text="unreadCount > 99 ? '99+' : unreadCount"
              class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center min-w-[20px]">
        </span>
    </button>

    <!-- Dropdown de Notificações -->
    <div x-show="open" 
         x-cloak 
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 z-50 max-h-96 overflow-hidden">
        
        <!-- Header -->
        <div class="px-4 py-3 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-semibold text-gray-900">Notificações</h3>
            <div class="flex gap-2">
                <span x-show="unreadCount > 0" 
                      class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full"
                      x-text="unreadCount + ' não lidas'">
                </span>
                <a href="{{ route('notifications.index') }}" 
                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Ver todas
                </a>
            </div>
        </div>

        <!-- Loading -->
        <div x-show="loading" class="p-4 text-center">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-600 mx-auto"></div>
            <p class="text-gray-500 mt-2">Carregando...</p>
        </div>

        <!-- Lista de Notificações -->
        <div x-show="!loading" class="max-h-64 overflow-y-auto">
            <template x-if="notifications.length === 0">
                <div class="p-4 text-center text-gray-500">
                    <svg class="w-12 h-12 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                              d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                        </path>
                    </svg>
                    <p>Nenhuma notificação</p>
                </div>
            </template>
            
            <template x-for="notification in notifications" :key="notification.id">
                <div class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 cursor-pointer flex items-start gap-3"
                     @click="markAsRead(notification.id); window.location.href = notification.data.url || '#'">
                    <!-- Indicador de não lida -->
                    <div class="flex-shrink-0 mt-1">
                        <div x-show="!notification.read_at" class="w-2 h-2 bg-blue-500 rounded-full"></div>
                        <div x-show="notification.read_at" class="w-2 h-2 bg-gray-300 rounded-full"></div>
                    </div>
                    
                    <!-- Conteúdo da Notificação -->
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate" 
                           x-text="notification.data.message || 'Nova notificação'">
                        </p>
                        <p class="text-xs text-gray-500 mt-1" 
                           x-text="formatDate(notification.created_at)">
                        </p>
                        <template x-if="notification.data.ticket_priority">
                            <span class="inline-block mt-1 px-2 py-1 text-xs rounded-full"
                                  :class="{
                                      'bg-red-100 text-red-800': notification.data.ticket_priority === 'alta',
                                      'bg-yellow-100 text-yellow-800': notification.data.ticket_priority === 'media',
                                      'bg-green-100 text-green-800': notification.data.ticket_priority === 'baixa'
                                  }"
                                  x-text="notification.data.ticket_priority.charAt(0).toUpperCase() + notification.data.ticket_priority.slice(1)">
                            </span>
                        </template>
                    </div>
                </div>
            </template>
        </div>

        <!-- Footer -->
        <div x-show="!loading && notifications.length > 0" class="px-4 py-3 border-t border-gray-200">
            <button @click="markAllAsRead()" 
                    class="w-full text-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                Marcar todas como lidas
            </button>
        </div>
    </div>

    <script>
        function fetchNotifications() {
            this.loading = true;
            fetch('/notifications/unread', {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.notifications = data.notifications;
                this.unreadCount = data.unread_count;
                this.loading = false;
            })
            .catch(error => {
                console.error('Erro ao buscar notificações:', error);
                this.loading = false;
            });
        }

        function markAsRead(notificationId) {
            fetch(`/notifications/${notificationId}/mark-as-read`, {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.fetchNotifications();
                }
            })
            .catch(error => {
                console.error('Erro ao marcar como lida:', error);
            });
        }

        function markAllAsRead() {
            fetch('/notifications/mark-all-as-read', {
                method: 'PATCH',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.fetchNotifications();
                }
            })
            .catch(error => {
                console.error('Erro ao marcar todas como lidas:', error);
            });
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();
            const diffInMinutes = Math.floor((now - date) / 60000);
            
            if (diffInMinutes < 1) return 'Agora';
            if (diffInMinutes < 60) return `${diffInMinutes}m atrás`;
            
            const diffInHours = Math.floor(diffInMinutes / 60);
            if (diffInHours < 24) return `${diffInHours}h atrás`;
            
            const diffInDays = Math.floor(diffInHours / 24);
            if (diffInDays < 7) return `${diffInDays}d atrás`;
            
            return date.toLocaleDateString('pt-BR');
        }
    </script>
</div>
