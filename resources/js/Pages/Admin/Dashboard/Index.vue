<template>
    <ModernAdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        Selamat datang di Admin Panel!
                    </div>
                </div>
            </div>
        </div>
    </ModernAdminLayout>
</template>

<script setup>
import ModernAdminLayout from '@/Layouts/ModernAdminLayout.vue';
</script> 