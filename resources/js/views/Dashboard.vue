<template>
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <!-- Navbar -->
        <nav class="bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <span class="text-sm font-semibold text-gray-900 dark:text-white">Dashboard</span>
                <button
                    @click="handleLogout"
                    :disabled="loggingOut"
                    class="text-sm text-gray-500 dark:text-gray-400 hover:text-red-500 dark:hover:text-red-400 transition disabled:opacity-50"
                >
                    {{ loggingOut ? 'Signing out…' : 'Sign out' }}
                </button>
            </div>
        </nav>

        <!-- Content -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm px-8 py-10">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-1">
                    Welcome back<span v-if="user?.name">, {{ user.name }}</span>!
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">You are authenticated via Sanctum cookie.</p>
            </div>
        </main>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();
const user = ref(null);
const loggingOut = ref(false);

onMounted(async () => {
    const { data } = await window.axios.get('/api/user');
    user.value = data;
});

async function handleLogout() {
    loggingOut.value = true;
    try {
        await window.axios.post('/logout');
        router.push({ name: 'login' });
    } finally {
        loggingOut.value = false;
    }
}
</script>
