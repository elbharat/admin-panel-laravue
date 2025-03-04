<script setup>
import ModernAdminLayout from '@/Layouts/ModernAdminLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <ModernAdminLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Profile</h1>
            </div>
        </template>

        <div class="space-y-6">
            <div class="bg-white p-6 shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    class="max-w-xl"
                />
            </div>

            <div class="bg-white p-6 shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <UpdatePasswordForm class="max-w-xl" />
            </div>

            <div class="bg-white p-6 shadow-sm dark:bg-gray-800 sm:rounded-lg">
                <DeleteUserForm class="max-w-xl" />
            </div>
        </div>
    </ModernAdminLayout>
</template>
