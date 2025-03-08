<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import ModernAdminLayout from '@/Layouts/ModernAdminLayout.vue';
import Button from '@/Components/ui/button/Button.vue';
import Select from '@/Components/ui/select/Select.vue';
import SelectTrigger from '@/Components/ui/select/SelectTrigger.vue';
import SelectValue from '@/Components/ui/select/SelectValue.vue';
import SelectContent from '@/Components/ui/select/SelectContent.vue';
import SelectItem from '@/Components/ui/select/SelectItem.vue';
import { Plus, Pencil, Trash } from 'lucide-vue-next';
import UserModal from './Partials/UserModal.vue';

const props = defineProps({
    users: {
        type: Array,
        required: true
    },
    roles: {
        type: Array,
        required: true
    }
});

const showModal = ref(false);
const editingUser = ref(null);

const openCreateModal = () => {
    editingUser.value = null;
    showModal.value = true;
};

const openEditModal = (user) => {
    editingUser.value = user;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    editingUser.value = null;
};
</script>

<template>
    <Head title="Users Management" />

    <ModernAdminLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Users Management</h2>
                <Button @click="openCreateModal" variant="primary" class="flex items-center gap-2">
                    <Plus class="w-4 h-4" />
                    Create User
                </Button>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="user in users" :key="user.id">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ user.name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ user.email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                            <span class="px-2 py-1 text-xs font-medium rounded-full"
                                                :class="{
                                                    'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300': user.roles[0]?.name === 'admin',
                                                    'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300': user.roles[0]?.name === 'user'
                                                }">
                                                {{ user.roles[0]?.name }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <Button @click="openEditModal(user)" variant="secondary" size="sm" class="inline-flex items-center gap-1">
                                                <Pencil class="w-4 h-4" />
                                                Edit
                                            </Button>
                                            <Button variant="danger" size="sm" class="inline-flex items-center gap-1">
                                                <Trash class="w-4 h-4" />
                                                Delete
                                            </Button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <UserModal
            v-if="showModal"
            :show="showModal"
            :user="editingUser"
            :roles="roles"
            @close="closeModal"
        />
    </ModernAdminLayout>
</template> 