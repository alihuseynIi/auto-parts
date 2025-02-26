<template>
    <button
        class="relative flex items-center justify-center w-10 h-10 text-gray-500 focus:outline-none"
        @click="toggleDropdown"
    >
        <svg
            class="w-6 h-6"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14V11A6 6 0 006 11v3c0 .386-.145.735-.405 1.005L4 17h5m6 0a3 3 0 11-6 0"
            ></path>
        </svg>

        <!-- Bildirim Sayacı -->
        <span
            v-if="unreadCount > 0"
            class="absolute top-0 right-0 inline-flex items-center justify-center w-5 h-5 text-xs font-bold text-white bg-red-500 rounded-full"
        >
      {{ unreadCount }}
    </span>

        <!-- Eğer bildirim yoksa yeşil nokta -->
        <span
            v-if="unreadCount === 0"
            class="absolute top-0 right-0 w-3 h-3 bg-green-500 border-2 border-white rounded-full"
        ></span>
    </button>
</template>

<script>
export default {
    data() {
        return {
            unreadCount: 0,
        };
    },
    mounted() {
        this.fetchNotifications();
        Nova.$on('nova.notifications.received', this.fetchNotifications);
    },
    methods: {
        fetchNotifications() {
            Nova.request()
                .get('/nova-api/notifications')
                .then((response) => {
                    this.unreadCount = response.data.filter((notification) => !notification.read_at).length;
                });
        },
        toggleDropdown() {
            Nova.$emit('toggle-notification-dropdown');
        },
    },
};
</script>
