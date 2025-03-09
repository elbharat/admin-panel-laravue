<script setup>
import { ref } from 'vue';
import { Head, router, Link } from '@inertiajs/vue3';
import ModernAdminLayout from '@/Layouts/ModernAdminLayout.vue';
import Button from '@/Components/ui/button/Button.vue';
import { Plus, Pencil, Trash } from 'lucide-vue-next';
import RoleModal from './Partials/RoleModal.vue';
import AdminBreadcrumb from '@/Components/AdminBreadcrumb.vue';

const props = defineProps({
    roles: {
        type: Array,
        required: true
    },
    permissionGroups: {
        type: Array,
        required: true
    }
});

const showRoleModal = ref(false);
const editingRole = ref(null);

const openCreateRoleModal = () => {
    editingRole.value = null;
    showRoleModal.value = true;
};

const openEditRoleModal = (role) => {
    editingRole.value = role;
    showRoleModal.value = true;
};

const closeRoleModal = () => {
    showRoleModal.value = false;
    editingRole.value = null;
};

const deleteRole = (roleId) => {
    if (confirm('Are you sure you want to delete this role?')) {
        router.delete(route('roles.destroy', roleId), {
            preserveScroll: true
        });
    }
};
</script>

<template>
    <Head title="Role Management" />

    <ModernAdminLayout>
        <template #header>
            <div class="flex justify-between items-center w-full">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Role Management</h2>
                <Link :href="route('roles.create')">
                    <Button variant="primary" class="flex items-center gap-2 ml-4">
                        <Plus class="w-4 h-4" />
                        Add Role
                    </Button>
                </Link>
            </div>
        </template>

        <template #breadcrumb>
            <AdminBreadcrumb :items="[
                { label: 'Roles', href: route('roles.index') }
            ]" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div v-if="roles.length === 0" class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">No roles found. Create one to get started.</p>
                        </div>
                        
                        <div v-else class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Permissions</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    <tr v-for="role in roles" :key="role.id">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ role.name }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-900 dark:text-gray-100">
                                            <div class="flex flex-wrap gap-1">
                                                <span 
                                                    v-for="permission in role.permissions.slice(0, 5)" 
                                                    :key="permission.id" 
                                                    class="px-2 py-1 text-xs font-medium rounded-full bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300"
                                                >
                                                    {{ permission.display_name || permission.name }}
                                                </span>
                                                <span 
                                                    v-if="role.permissions.length > 5" 
                                                    class="px-2 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300"
                                                >
                                                    +{{ role.permissions.length - 5 }} more
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                            <Link :href="route('roles.edit', role.id)">
                                                <Button variant="secondary" size="sm" class="inline-flex items-center gap-1">
                                                    <Pencil class="w-4 h-4" />
                                                    Edit
                                                </Button>
                                            </Link>
                                            <Button 
                                                v-if="role.name !== 'admin'" 
                                                @click="deleteRole(role.id)" 
                                                variant="danger" 
                                                size="sm" 
                                                class="inline-flex items-center gap-1"
                                            >
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

        <RoleModal
            v-if="showRoleModal"
            :show="showRoleModal"
            :role="editingRole"
            :permission-groups="permissionGroups"
            @close="closeRoleModal"
        />
    </ModernAdminLayout>
</template> 