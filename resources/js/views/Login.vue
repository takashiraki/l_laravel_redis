<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-gray-900">
        <div class="w-full max-w-md">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg px-8 py-10">
                <h1 class="text-2xl font-semibold text-gray-900 dark:text-white mb-1">Sign in</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-8">Enter your credentials to continue</p>

                <form @submit.prevent="handleLogin" novalidate>
                    <!-- Email -->
                    <div class="mb-5">
                        <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Email
                        </label>
                        <input
                            id="email"
                            v-model="form.email"
                            type="email"
                            autocomplete="email"
                            placeholder="you@example.com"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            :class="{ 'border-red-500 focus:ring-red-500': errors.email }"
                        />
                        <p v-if="errors.email" class="mt-1.5 text-xs text-red-500">{{ errors.email[0] }}</p>
                    </div>

                    <!-- Password -->
                    <div class="mb-6">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                            Password
                        </label>
                        <input
                            id="password"
                            v-model="form.password"
                            type="password"
                            autocomplete="current-password"
                            placeholder="••••••••"
                            class="w-full rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 px-4 py-2.5 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                            :class="{ 'border-red-500 focus:ring-red-500': errors.password }"
                        />
                        <p v-if="errors.password" class="mt-1.5 text-xs text-red-500">{{ errors.password[0] }}</p>
                    </div>

                    <!-- General error -->
                    <div v-if="generalError" class="mb-5 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 px-4 py-3 text-sm text-red-600 dark:text-red-400">
                        {{ generalError }}
                    </div>

                    <button
                        type="submit"
                        :disabled="loading"
                        class="w-full flex items-center justify-center gap-2 rounded-lg bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 disabled:cursor-not-allowed text-white text-sm font-medium px-4 py-2.5 transition"
                    >
                        <svg v-if="loading" class="animate-spin h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" />
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z" />
                        </svg>
                        {{ loading ? 'Signing in…' : 'Sign in' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';

const router = useRouter();

const form = reactive({ email: '', password: '' });
const errors = reactive({});
const generalError = ref('');
const loading = ref(false);

async function handleLogin() {
    // Reset errors
    Object.keys(errors).forEach((k) => delete errors[k]);
    generalError.value = '';
    loading.value = true;

    try {
        // 1. Fetch CSRF cookie (required by Sanctum SPA auth)
        await window.axios.get('/sanctum/csrf-cookie');

        // 2. Attempt login
        await window.axios.post('/login', {
            email: form.email,
            password: form.password,
        });

        router.push({ name: 'dashboard' });
    } catch (err) {
        if (err.response?.status === 422) {
            Object.assign(errors, err.response.data.errors ?? {});
        } else {
            generalError.value = 'Something went wrong. Please try again.';
        }
    } finally {
        loading.value = false;
    }
}
</script>
