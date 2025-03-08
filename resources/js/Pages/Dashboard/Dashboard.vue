<script setup>
import ModernAdminLayout from '@/Layouts/ModernAdminLayout.vue';
import AdminBreadcrumb from '@/Components/AdminBreadcrumb.vue';
import { UserIcon, FileTextIcon, MessageSquareIcon, EyeIcon } from 'lucide-vue-next';
import { Head, usePage } from '@inertiajs/vue3';

const $page = usePage();
const user = $page.props.auth.user;
const isAdmin = user.is_admin || user.roles.includes('admin');

defineProps({
    stats: {
        type: Object,
        default: () => ({
            users: 0,
            posts: 0,
            comments: 0,
            views: 0
        })
    },
    activities: {
        type: Array,
        default: () => []
    }
});
</script>

<template>
    <Head title="Dashboard" />

    <ModernAdminLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
                Dashboard
            </h2>
        </template>

        <template #breadcrumb>
            <AdminBreadcrumb :items="[{ label: 'Dashboard' }]" />
        </template>

        <!-- Admin Dashboard -->
        <div v-if="isAdmin" class="py-6">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Greeting Card -->
                <div class="mb-6 overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Selamat datang, {{ user.name }}!
                        </h3>
                        <p class="mt-1 text-gray-600 dark:text-gray-400">
                            Ini adalah panel admin untuk mengelola aplikasi Anda. Gunakan menu di sidebar untuk navigasi.
                        </p>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="mb-6 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Users Stat -->
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-blue-100 dark:bg-blue-900">
                                    <UserIcon class="h-6 w-6 text-blue-600 dark:text-blue-300" />
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengguna</h3>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ stats.users }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Posts Stat -->
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-green-100 dark:bg-green-900">
                                    <FileTextIcon class="h-6 w-6 text-green-600 dark:text-green-300" />
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Konten</h3>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ stats.posts }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Stat -->
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-purple-100 dark:bg-purple-900">
                                    <MessageSquareIcon class="h-6 w-6 text-purple-600 dark:text-purple-300" />
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Komentar</h3>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ stats.comments }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Views Stat -->
                    <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex items-center">
                                <div class="flex h-12 w-12 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900">
                                    <EyeIcon class="h-6 w-6 text-amber-600 dark:text-amber-300" />
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Pengunjung</h3>
                                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">{{ stats.views }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="overflow-hidden bg-white shadow-sm dark:bg-gray-800 sm:rounded-lg">
                    <div class="border-b border-gray-200 dark:border-gray-700">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Aktivitas Terbaru</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <div v-if="activities.length" class="divide-y divide-gray-200 dark:divide-gray-700">
                            <div v-for="(activity, index) in activities" :key="index" class="py-4">
                                <div class="flex items-center">
                                    <div class="h-8 w-8 rounded-full bg-gray-200 dark:bg-gray-700"></div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ activity.user }}</p>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ activity.action }}</p>
                                        <p class="text-xs text-gray-400 dark:text-gray-500">{{ activity.time }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="py-4 text-center text-gray-500 dark:text-gray-400">
                            Belum ada aktivitas terbaru.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- User Dashboard -->
        <div v-else class="py-6">
            <div class="mx-auto max-w-7xl">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                            Selamat datang, {{ user.name }}!
                        </h3>
                        <p class="mt-1 text-gray-600 dark:text-gray-400">
                            Ini adalah halaman dashboard Anda.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </ModernAdminLayout>
</template>
