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

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <Head :title="'Register - ' + settings.websiteTitle" />

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

        <form @submit.prevent="submit">
            <div>
                <InputLabel for="name" value="Name" />
                <Input
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div class="mt-4">
                <InputLabel for="email" value="Email" />
                <Input
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div class="mt-4">
                <InputLabel for="password" value="Password" />
                <Input
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div class="mt-4">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <Input
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="mt-4">
                <Button
                    class="w-full"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Register
                </Button>
            </div>

            <div class="mt-4 text-center">
                <span class="text-sm text-gray-600">Already have an account?</span>
                <Link
                    :href="route('login')"
                    class="ml-1 text-sm text-indigo-600 hover:text-indigo-900"
                >
                    Login here
                </Link>
            </div>
        </form>
    </AuthenticationCard>
</template>
