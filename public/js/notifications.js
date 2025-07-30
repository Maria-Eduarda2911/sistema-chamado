// Sistema de Notificações Push em Tempo Real
class NotificationSystem {
    constructor() {
        this.echo = null;
        this.userId = this.getUserId();
        this.isTechnician = this.getIsTechnician();
        this.init();
    }

    getUserId() {
        // Pegar ID do usuário de um meta tag ou variável global
        const userIdMeta = document.querySelector('meta[name="user-id"]');
        return userIdMeta ? userIdMeta.getAttribute('content') : null;
    }

    getIsTechnician() {
        // Verificar se o usuário é técnico
        const isTechMeta = document.querySelector('meta[name="is-technician"]');
        return isTechMeta ? isTechMeta.getAttribute('content') === '1' : false;
    }

    init() {
        // Configurar Laravel Echo (usando Pusher como exemplo)
        if (window.Pusher) {
            this.echo = new Echo({
                broadcaster: 'pusher',
                key: window.Laravel.pusherAppKey,
                cluster: window.Laravel.pusherCluster,
                forceTLS: true
            });

            this.setupChannels();
        } else {
            // Fallback para polling se WebSockets não estiverem disponíveis
            this.setupPolling();
        }
    }

    setupChannels() {
        if (!this.echo || !this.isTechnician) return;

        // Escutar canal de técnicos para novos tickets
        this.echo.private('technicians')
            .listen('.ticket.created', (e) => {
                this.showPushNotification(e);
                this.updateNotificationBell();
            });

        // Escutar notificações específicas do usuário
        if (this.userId) {
            this.echo.private(`user.${this.userId}`)
                .notification((notification) => {
                    this.showPushNotification(notification);
                    this.updateNotificationBell();
                });
        }
    }

    setupPolling() {
        if (!this.isTechnician) return;

        // Polling a cada 30 segundos para buscar novas notificações
        setInterval(() => {
            this.checkForNewNotifications();
        }, 30000);
    }

    checkForNewNotifications() {
        fetch('/notifications/unread', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            const currentCount = this.getStoredNotificationCount();
            if (data.unread_count > currentCount) {
                // Há novas notificações
                this.setStoredNotificationCount(data.unread_count);
                this.updateNotificationBell();
                
                // Mostrar notificação do browser se possível
                if (data.notifications.length > 0) {
                    this.showPushNotification(data.notifications[0]);
                }
            }
        })
        .catch(error => {
            console.error('Erro ao verificar notificações:', error);
        });
    }

    showPushNotification(notification) {
        // Verificar se o browser suporta notificações
        if ('Notification' in window) {
            // Pedir permissão se necessário
            if (Notification.permission === 'default') {
                Notification.requestPermission().then(permission => {
                    if (permission === 'granted') {
                        this.displayNotification(notification);
                    }
                });
            } else if (Notification.permission === 'granted') {
                this.displayNotification(notification);
            }
        }

        // Mostrar notificação visual na página também
        this.showInPageNotification(notification);
    }

    displayNotification(notification) {
        const title = 'Sistema de Chamados';
        const options = {
            body: notification.message || notification.data?.message || 'Nova notificação',
            icon: '/favicon.ico',
            badge: '/favicon.ico',
            tag: 'ticket-notification',
            requireInteraction: true,
            actions: [
                {
                    action: 'view',
                    title: 'Ver',
                    icon: '/favicon.ico'
                },
                {
                    action: 'dismiss',
                    title: 'Dispensar'
                }
            ]
        };

        const browserNotification = new Notification(title, options);

        browserNotification.onclick = function() {
            window.focus();
            if (notification.url || notification.data?.url) {
                window.location.href = notification.url || notification.data.url;
            }
            browserNotification.close();
        };

        // Auto-fechar após 5 segundos
        setTimeout(() => {
            browserNotification.close();
        }, 5000);
    }

    showInPageNotification(notification) {
        // Criar elemento de notificação visual
        const notificationDiv = document.createElement('div');
        notificationDiv.className = 'fixed top-4 right-4 bg-blue-500 text-white p-4 rounded-lg shadow-lg z-50 max-w-sm';
        notificationDiv.innerHTML = `
            <div class="flex items-start gap-3">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="font-semibold">Novo Ticket</h4>
                    <p class="text-sm opacity-90">${notification.message || notification.data?.message || 'Nova notificação'}</p>
                </div>
                <button onclick="this.parentElement.parentElement.remove()" class="text-white hover:text-gray-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        `;

        document.body.appendChild(notificationDiv);

        // Remover após 5 segundos
        setTimeout(() => {
            if (notificationDiv.parentNode) {
                notificationDiv.remove();
            }
        }, 5000);

        // Adicionar click para ir para o ticket
        if (notification.url || notification.data?.url) {
            notificationDiv.style.cursor = 'pointer';
            notificationDiv.addEventListener('click', () => {
                window.location.href = notification.url || notification.data.url;
            });
        }
    }

    updateNotificationBell() {
        // Atualizar o sino de notificações na navbar
        const event = new CustomEvent('updateNotifications');
        document.dispatchEvent(event);
    }

    getStoredNotificationCount() {
        return parseInt(localStorage.getItem('notificationCount') || '0');
    }

    setStoredNotificationCount(count) {
        localStorage.setItem('notificationCount', count.toString());
    }

    // Método público para solicitar permissão de notificação
    requestNotificationPermission() {
        if ('Notification' in window && Notification.permission === 'default') {
            Notification.requestPermission().then(permission => {
                if (permission === 'granted') {
                    console.log('Permissão de notificação concedida');
                }
            });
        }
    }
}

// Inicializar o sistema quando a página carregar
document.addEventListener('DOMContentLoaded', function() {
    window.notificationSystem = new NotificationSystem();
    
    // Solicitar permissão automaticamente para técnicos
    if (window.notificationSystem.isTechnician) {
        window.notificationSystem.requestNotificationPermission();
    }
});

// Escutar evento customizado para atualizar notificações
document.addEventListener('updateNotifications', function() {
    // Atualizar componente Alpine.js se existir
    if (window.Alpine && window.Alpine.store) {
        const notificationStore = window.Alpine.store('notifications');
        if (notificationStore && typeof notificationStore.fetchNotifications === 'function') {
            notificationStore.fetchNotifications();
        }
    }
});
