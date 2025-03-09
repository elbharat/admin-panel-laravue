<script setup>
import { ref } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import ModernAdminLayout from '@/Layouts/ModernAdminLayout.vue';
import InputError from '@/Components/ui/input-error.vue';
import InputLabel from '@/Components/ui/input-label.vue';
import TextInput from '@/Components/ui/input.vue';
import Button from '@/Components/ui/button/Button.vue';
import AdminBreadcrumb from '@/Components/AdminBreadcrumb.vue';

const props = defineProps({
    user: {
        type: Object,
        required: true
    },
    roles: {
        type: Array,
        required: true
    }
});

const form = useForm({
    name: props.user.name,
    email: props.user.email,
    password: '',
    password_confirmation: '',
    role: props.user.roles[0]?.name || ''
});

const submit = () => {
    form.put(route('users.update', props.user.id), {
        preserveScroll: true,
        onSuccess: () => {
            // Redirect to users index page
            window.location.href = route('users.index');
        }
    });
};
</script>

<template>
    <Head title="Edit User" />

    <ModernAdminLayout>
        <template #header>
            <div class="flex justify-between items-center w-full">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Edit User</h2>
            </div>
        </template>

        <template #breadcrumb>
            <AdminBreadcrumb :items="[
                { label: 'Users', href: route('users.index') },
                { label: 'Edit User', href: route('users.edit', user.id) }
            ]" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit">
                            <div class="mb-6">
                                <InputLabel for="name" value="Name" />
                                <TextInput
                                    id="name"
                                    type="text"
                                    class="mt-1 block w-full"
                                    v-model="form.name"
                                    required
                                    autofocus
                                />
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div class="mb-6">
                                <InputLabel for="email" value="Email" />
                                <TextInput
                                    id="email"
                                    type="email"
                                    class="mt-1 block w-full"
                                    v-model="form.email"
                                    required
                                />
                                <InputError class="mt-2" :message="form.errors.email" />
                            </div>

                            <div class="mb-6">
                                <InputLabel value="Role" />
                                <div class="mt-2 space-y-2">
                                    <div 
                                        v-for="role in roles" 
                                        :key="role.name" 
                                        class="flex items-center"
                                    >
                                        <input
                                            type="radio"
                                            :id="role.name"
                                            :value="role.name"
                                            v-model="form.role"
                                            name="role"
                                            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-700 dark:bg-gray-900 dark:ring-offset-gray-800"
                                            required
                                        >
                                        <label 
                                            :for="role.name" 
                                            class="ml-2 block text-sm font-medium text-gray-900 dark:text-gray-100"
                                        >
                                            {{ role.name }}
                                        </label>
                                    </div>
                                </div>
                                <InputError class="mt-2" :message="form.errors.role" />
                            </div>

                            <div class="mb-6">
                                <InputLabel for="password" value="Password" />
                                <TextInput
                                    id="password"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password"
                                    autocomplete="new-password"
                                />
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Biarkan kosong jika tidak ingin mengubah password
                                </p>
                                <InputError class="mt-2" :message="form.errors.password" />
                            </div>

                            <div class="mb-6">
                                <InputLabel for="password_confirmation" value="Confirm Password" />
                                <TextInput
                                    id="password_confirmation"
                                    type="password"
                                    class="mt-1 block w-full"
                                    v-model="form.password_confirmation"
                                    autocomplete="new-password"
                                />
                                <InputError class="mt-2" :message="form.errors.password_confirmation" />
                            </div>

                            <div class="flex items-center gap-4">
                                <Button type="submit" :disabled="form.processing">
                                    Update User
                                </Button>
                                <Link :href="route('users.index')">
                                    <Button type="button" variant="secondary">
                                        Cancel
                                    </Button>
                                </Link>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </ModernAdminLayout>
</template> 