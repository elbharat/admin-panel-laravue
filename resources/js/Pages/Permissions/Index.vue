<script setup>
import { ref } from 'vue';
import { Head, router, Link } from '@inertiajs/vue3';
import ModernAdminLayout from '@/Layouts/ModernAdminLayout.vue';
import Button from '@/Components/ui/button/Button.vue';
import { Plus, Pencil, Trash } from 'lucide-vue-next';
import PermissionGroupModal from './Partials/PermissionGroupModal.vue';
import PermissionModal from './Partials/PermissionModal.vue';
import AdminBreadcrumb from '@/Components/AdminBreadcrumb.vue';

const props = defineProps({
    permissionGroups: {
        type: Array,
        required: true
    },
    roles: {
        type: Array,
        required: true
    }
});

const showGroupModal = ref(false);
const showPermissionModal = ref(false);
const editingGroup = ref(null);
const editingPermission = ref(null);
const selectedGroupId = ref(null);

const openCreateGroupModal = () => {
    editingGroup.value = null;
    showGroupModal.value = true;
};

const openEditGroupModal = (group) => {
    editingGroup.value = group;
    showGroupModal.value = true;
};

const closeGroupModal = () => {
    showGroupModal.value = false;
    editingGroup.value = null;
};

const openCreatePermissionModal = (groupId = null) => {
    editingPermission.value = null;
    selectedGroupId.value = groupId;
    showPermissionModal.value = true;
};

const openEditPermissionModal = (permission) => {
    editingPermission.value = permission;
    selectedGroupId.value = permission.group_id;
    showPermissionModal.value = true;
};

const closePermissionModal = () => {
    showPermissionModal.value = false;
    editingPermission.value = null;
    selectedGroupId.value = null;
};

const deletePermission = (permissionId) => {
    if (confirm('Are you sure you want to delete this permission?')) {
        router.delete(route('permissions.destroy', permissionId), {
            preserveScroll: true
        });
    }
};

const deleteGroup = (groupId) => {
    if (confirm('Are you sure you want to delete this permission group?')) {
        router.delete(route('permission-groups.destroy', groupId), {
            preserveScroll: true
        });
    }
};
</script>

<template>
    <Head title="Permission Management" />

    <ModernAdminLayout>
        <template #header>
            <div class="flex justify-between items-center w-full">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Permission Management</h2>
                <div class="flex space-x-2">
                    <Link :href="route('permissions.create')">
                        <Button variant="secondary" class="flex items-center gap-2">
                            <Plus class="w-4 h-4" />
                            Add Permission
                        </Button>
                    </Link>
                    <Link :href="route('permission-groups.create')">
                        <Button variant="primary" class="flex items-center gap-2 ml-4">
                            <Plus class="w-4 h-4" />
                            Add Group
                        </Button>
                    </Link>
                </div>
            </div>
        </template>

        <template #breadcrumb>
            <AdminBreadcrumb :items="[
                { label: 'Permissions', href: route('permissions.index') }
            ]" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div v-if="permissionGroups.length === 0" class="text-center py-8">
                            <p class="text-gray-500 dark:text-gray-400">No permission groups found. Create one to get started.</p>
                        </div>
                        
                        <div v-else class="space-y-8">
                            <!-- Ungrouped Permissions -->
                            <div class="border dark:border-gray-700 rounded-lg overflow-hidden">
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 flex justify-between items-center">
                                    <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Ungrouped Permissions</h3>
                                    <Link :href="route('permissions.create')">
                                        <Button size="sm" variant="secondary" class="flex items-center gap-1">
                                            <Plus class="w-4 h-4" />
                                            Add
                                        </Button>
                                    </Link>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Display Name</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            <tr v-for="permission in permissionGroups.flatMap(g => g.permissions).filter(p => !p.group_id)" :key="permission.id">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ permission.name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ permission.display_name || permission.name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ permission.description || '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                    <Link :href="route('permissions.edit', permission.id)">
                                                        <Button variant="secondary" size="sm" class="inline-flex items-center gap-1">
                                                            <Pencil class="w-4 h-4" />
                                                            Edit
                                                        </Button>
                                                    </Link>
                                                    <Button 
                                                        @click="deletePermission(permission.id)" 
                                                        variant="danger" 
                                                        size="sm" 
                                                        class="inline-flex items-center gap-1"
                                                    >
                                                        <Trash class="w-4 h-4" />
                                                        Delete
                                                    </Button>
                                                </td>
                                            </tr>
                                            <tr v-if="permissionGroups.flatMap(g => g.permissions).filter(p => !p.group_id).length === 0">
                                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No ungrouped permissions found.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                            <!-- Permission Groups -->
                            <div v-for="group in permissionGroups.filter(g => g.id)" :key="group.id" class="border dark:border-gray-700 rounded-lg overflow-hidden">
                                <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 flex justify-between items-center">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{ group.display_name }}</h3>
                                        <p v-if="group.description" class="text-sm text-gray-500 dark:text-gray-400">{{ group.description }}</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <Link :href="`${route('permissions.create')}?group_id=${group.id}`">
                                            <Button size="sm" variant="secondary" class="flex items-center gap-1">
                                                <Plus class="w-4 h-4" />
                                                Add Permission
                                            </Button>
                                        </Link>
                                        <Link :href="route('permission-groups.edit', group.id)">
                                            <Button size="sm" variant="secondary" class="flex items-center gap-1">
                                                <Pencil class="w-4 h-4" />
                                                Edit Group
                                            </Button>
                                        </Link>
                                        <Button 
                                            @click="deleteGroup(group.id)" 
                                            size="sm" 
                                            variant="danger" 
                                            class="flex items-center gap-1"
                                        >
                                            <Trash class="w-4 h-4" />
                                            Delete Group
                                        </Button>
                                    </div>
                                </div>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Name</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Display Name</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Description</th>
                                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                            <tr v-for="permission in group.permissions" :key="permission.id">
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ permission.name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ permission.display_name || permission.name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ permission.description || '-' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                    <Link :href="route('permissions.edit', permission.id)">
                                                        <Button variant="secondary" size="sm" class="inline-flex items-center gap-1">
                                                            <Pencil class="w-4 h-4" />
                                                            Edit
                                                        </Button>
                                                    </Link>
                                                    <Button 
                                                        @click="deletePermission(permission.id)" 
                                                        variant="danger" 
                                                        size="sm" 
                                                        class="inline-flex items-center gap-1"
                                                    >
                                                        <Trash class="w-4 h-4" />
                                                        Delete
                                                    </Button>
                                                </td>
                                            </tr>
                                            <tr v-if="group.permissions.length === 0">
                                                <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">No permissions in this group.</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <PermissionGroupModal
            v-if="showGroupModal"
            :show="showGroupModal"
            :group="editingGroup"
            @close="closeGroupModal"
        />

        <PermissionModal
            v-if="showPermissionModal"
            :show="showPermissionModal"
            :permission="editingPermission"
            :group-id="selectedGroupId"
            :groups="permissionGroups"
            @close="closePermissionModal"
        />
    </ModernAdminLayout>
</template> 