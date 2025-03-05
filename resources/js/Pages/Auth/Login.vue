<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import AuthenticationCard from '@/Components/AuthenticationCard.vue';
import InputError from '@/Components/ui/input-error.vue';
import InputLabel from '@/Components/ui/input-label.vue';
import { Button } from '@/Components/ui/button';
import { Input } from '@/Components/ui/input';

const page = usePage();
const settings = computed(() => page.props.settings || {
    websiteTitle: 'Laravel',
    websiteSubtitle: '',
    websiteLogo: null,
    websiteFavicon: null,
    websiteThumbnail: null,
    footerCopyright: '© ' + new Date().getFullYear() + ' Laravel'
});

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    login: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <Head :title="'Login - ' + settings.websiteTitle" />

    <AuthenticationCard>
        <template #logo>
            <div class="text-center">
                <img 
                    v-if="settings.websiteLogo" 
                    :src="settings.websiteLogo" 
                    :alt="settings.websiteTitle" 
                    class="mx-auto w-20 h-20 object-contain" 
                />
                <h1 class="mt-4 text-2xl font-bold text-gray-900 dark:text-white">{{ settings.websiteTitle }}</h1>
                <p v-if="settings.websiteSubtitle" class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ settings.websiteSubtitle }}</p>
            </div>
        </template>

        <div v-if="status" class="mb-4 text-sm font-medium text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="login" value="Email or Username" />
                <Input
                    id="login"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.login"
                    required
                    autofocus
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.login" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <Input
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4 flex items-center justify-between">
                <label class="flex items-center">
                    <input 
                        type="checkbox"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                        v-model="form.remember"
                    >
                    <span class="ms-2 text-sm text-gray-600">Remember me</span>
                </label>

                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    Forgot your password?
                </Link>
            </div>

            <div class="mt-4">
                <Button
                    class="w-full"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Log in
                </Button>
            </div>

            <div class="mt-4 text-center">
                <span class="text-sm text-gray-600">Don't have an account?</span>
                <Link
                    :href="route('register')"
                    class="ml-1 text-sm text-indigo-600 hover:text-indigo-900"
                >
                    Register now
                </Link>
            </div>
        </form>
    </AuthenticationCard>
</template>
