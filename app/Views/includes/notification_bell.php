<!-- Notification Bell Dropdown -->
<div class="relative" id="notificationContainer">
    <button onclick="toggleNotifications()" class="relative p-2 rounded-full hover:bg-slate-700 transition-all">
        <i class="fas fa-bell text-gray-300 text-xl"></i>
        <span id="notificationBadge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs font-bold rounded-full h-5 w-5 flex items-center justify-center animate-pulse hidden">
            0
        </span>
    </button>

    <!-- Notification Dropdown -->
    <div id="notificationDropdown" class="hidden absolute right-0 mt-2 w-96 bg-slate-800 rounded-lg shadow-2xl border border-purple-500/20 z-50 max-h-96 overflow-y-auto">
        <div class="p-4 border-b border-purple-500/20 bg-slate-900/50 rounded-t-lg flex justify-between items-center">
            <h3 class="text-lg font-semibold text-white">
                Notifications (<span id="unreadCountText">0</span> unread)
            </h3>
            <button onclick="markAllAsRead()" class="text-xs text-purple-400 hover:text-purple-300">
                Mark all read
            </button>
        </div>

        <div id="notificationList">
            <!-- Notifications will be loaded here -->
            <div class="p-8 text-center text-gray-400">
                <i class="fas fa-bell text-4xl mb-3 opacity-30"></i>
                <p>Loading notifications...</p>
            </div>
        </div>
    </div>
</div>

<script>
let notificationDropdownOpen = false;

// Load notifications on page load
document.addEventListener('DOMContentLoaded', function() {
    loadNotifications();

    // Refresh every 60 seconds
    setInterval(loadNotifications, 60000);

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const container = document.getElementById('notificationContainer');
        if (!container.contains(event.target) && notificationDropdownOpen) {
            toggleNotifications();
        }
    });
});

function toggleNotifications() {
    const dropdown = document.getElementById('notificationDropdown');
    notificationDropdownOpen = !notificationDropdownOpen;

    if (notificationDropdownOpen) {
        dropdown.classList.remove('hidden');
        loadNotifications();
    } else {
        dropdown.classList.add('hidden');
    }
}

function loadNotifications() {
    fetch('<?= base_url('notifications') ?>', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            updateNotificationBadge(data.unreadCount);
            displayNotifications(data.notifications);
        }
    })
    .catch(error => {
        console.error('Error loading notifications:', error);
    });
}

function updateNotificationBadge(count) {
    const badge = document.getElementById('notificationBadge');
    const countText = document.getElementById('unreadCountText');

    if (count > 0) {
        badge.textContent = count > 99 ? '99+' : count;
        badge.classList.remove('hidden');
    } else {
        badge.classList.add('hidden');
    }

    if (countText) {
        countText.textContent = count;
    }
}

function displayNotifications(notifications) {
    const container = document.getElementById('notificationList');

    if (!notifications || notifications.length === 0) {
        container.innerHTML = `
            <div class="p-8 text-center text-gray-400">
                <i class="fas fa-bell-slash text-4xl mb-3 opacity-30"></i>
                <p>No notifications</p>
            </div>
        `;
        return;
    }

    let html = '';
    const unreadNotifications = notifications.filter(n => n.is_read == 0);

    if (unreadNotifications.length === 0) {
        html = `
            <div class="p-8 text-center text-gray-400">
                <i class="fas fa-check-circle text-4xl mb-3 opacity-30"></i>
                <p>All caught up!</p>
            </div>
        `;
    } else {
        unreadNotifications.forEach(notification => {
            html += `
                <div class="p-4 border-b border-slate-700 hover:bg-slate-700/50 transition-colors" data-notification-id="${notification.id}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1 flex items-start space-x-3">
                            <div class="bg-blue-600 p-2 rounded-full flex-shrink-0">
                                <i class="fas fa-book text-white text-sm"></i>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-white font-medium">${notification.message}</p>
                                <p class="text-xs text-gray-400 mt-1">${formatTime(notification.created_at)}</p>
                            </div>
                        </div>
                        <button onclick="markAsRead(${notification.id})" 
                                class="ml-2 p-2 text-green-400 hover:bg-green-500/20 rounded transition-all flex-shrink-0"
                                title="Mark as read">
                            <i class="fas fa-check text-sm"></i>
                        </button>
                    </div>
                </div>
            `;
        });
    }

    container.innerHTML = html;
}

function markAsRead(id) {
    fetch(`<?= base_url('notifications/mark_read') ?>/${id}`, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Remove the notification from the list with animation
            const notificationElement = document.querySelector(`[data-notification-id="${id}"]`);
            if (notificationElement) {
                notificationElement.style.opacity = '0';
                notificationElement.style.transform = 'translateX(100%)';
                notificationElement.style.transition = 'all 0.3s ease';

                setTimeout(() => {
                    notificationElement.remove();
                    loadNotifications(); // Refresh the list
                }, 300);
            }

            updateNotificationBadge(data.unreadCount);
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

function markAllAsRead() {
    if (!confirm('Mark all notifications as read?')) return;

    fetch('<?= base_url('notifications/mark_all_read') ?>', {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            loadNotifications();
        }
    })
    .catch(error => {
        console.error('Error marking all as read:', error);
    });
}

function formatTime(datetime) {
    const date = new Date(datetime);
    const now = new Date();
    const diff = Math.floor((now - date) / 1000 / 60);

    if (diff < 1) return 'Just now';
    if (diff < 60) return `${diff} minute${diff > 1 ? 's' : ''} ago`;
    if (diff < 1440) return `${Math.floor(diff / 60)} hour${Math.floor(diff / 60) > 1 ? 's' : ''} ago`;

    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' });
}
</script>