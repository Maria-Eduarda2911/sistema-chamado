<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Notificações') }}
            </h2>
            <div class="flex gap-2">
                @if(auth()->user()->unreadNotifications->count() > 0)
                    <button onclick="markAllAsRead()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Marcar todas como lidas
                    </button>
                @endif
                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-sm">
                    {{ auth()->user()->unreadNotifications->count() }} não lidas
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($notifications->count() > 0)
                        <div class="space-y-4">
                            @foreach($notifications as $notification)
                                <div class="border-l-4 {{ $notification->read_at ? 'border-gray-300 bg-gray-50' : 'border-blue-500 bg-blue-50' }} p-4 rounded-r-lg flex justify-between items-start">
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            @if(!$notification->read_at)
                                                <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                                            @endif
                                            <h4 class="font-semibold text-lg">
                                                {{ $notification->data['message'] ?? 'Nova notificação' }}
                                            </h4>
                                        </div>
                                        
                                        @if(isset($notification->data['ticket_title']))
                                            <p class="text-gray-700 mb-1">
                                                <strong>Ticket:</strong> {{ $notification->data['ticket_title'] }}
                                            </p>
                                        @endif
                                        
                                        @if(isset($notification->data['ticket_priority']))
                                            <p class="text-gray-700 mb-1">
                                                <strong>Prioridade:</strong> 
                                                <span class="px-2 py-1 rounded text-sm font-semibold 
                                                    {{ $notification->data['ticket_priority'] === 'alta' ? 'bg-red-100 text-red-800' : 
                                                       ($notification->data['ticket_priority'] === 'media' ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800') }}">
                                                    {{ ucfirst($notification->data['ticket_priority']) }}
                                                </span>
                                            </p>
                                        @endif
                                        
                                        @if(isset($notification->data['creator_name']))
                                            <p class="text-gray-700 mb-2">
                                                <strong>Criado por:</strong> {{ $notification->data['creator_name'] }}
                                            </p>
                                        @endif
                                        
                                        <p class="text-sm text-gray-500">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                    
                                    <div class="flex gap-2 ml-4">
                                        @if(isset($notification->data['url']))
                                            <a href="{{ $notification->data['url'] }}" 
                                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                Ver
                                            </a>
                                        @endif
                                        
                                        @if(!$notification->read_at)
                                            <button onclick="markAsRead('{{ $notification->id }}')" 
                                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                Marcar como lida
                                            </button>
                                        @endif
                                        
                                        <button onclick="deleteNotification('{{ $notification->id }}')" 
                                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">
                                            Excluir
                                        </button>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <div class="mt-6">
                            {{ $notifications->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500 text-lg">Você não possui notificações.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
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
                    location.reload();
                } else {
                    alert('Erro ao marcar notificação como lida');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erro ao marcar notificação como lida');
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
                    location.reload();
                } else {
                    alert('Erro ao marcar todas as notificações como lidas');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Erro ao marcar todas as notificações como lidas');
            });
        }

        function deleteNotification(notificationId) {
            if (confirm('Tem certeza que deseja excluir esta notificação?')) {
                fetch(`/notifications/${notificationId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Erro ao excluir notificação');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Erro ao excluir notificação');
                });
            }
        }
    </script>
</x-app-layout>
