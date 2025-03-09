<script setup>
import { ref } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import ModernAdminLayout from '@/Layouts/ModernAdminLayout.vue';
import InputError from '@/Components/ui/input-error.vue';
import InputLabel from '@/Components/ui/input-label.vue';
import TextInput from '@/Components/ui/input.vue';
import Button from '@/Components/ui/button/Button.vue';
import Checkbox from '@/Components/ui/checkbox.vue';
import AdminBreadcrumb from '@/Components/AdminBreadcrumb.vue';

const props = defineProps({
    permissionGroups: {
        type: Array,
        required: true
    }
});

const form = useForm({
    name: '',
    permissions: [],
});

const allPermissions = ref([]);

// Mengumpulkan semua permission dari semua grup
props.permissionGroups.forEach(group => {
    if (group.permissions && Array.isArray(group.permissions)) {
        allPermissions.value.push(...group.permissions);
    }
});

const toggleGroupPermissions = (groupId, checked) => {
    const group = props.permissionGroups.find(g => g.id === groupId);
    if (!group || !group.permissions || !Array.isArray(group.permissions)) {
        return;
    }
    
    const groupPermissions = group.permissions.map(p => p.id);
    
    if (checked) {
        // Add all permissions from this group that aren't already selected
        groupPermissions.forEach(id => {
            if (!form.permissions.includes(id)) {
                form.permissions.push(id);
            }
        });
    } else {
        // Remove all permissions from this group
        form.permissions = form.permissions.filter(id => !groupPermissions.includes(id));
    }
};

const isGroupChecked = (groupId) => {
    const group = props.permissionGroups.find(g => g.id === groupId);
    if (!group || !group.permissions || !Array.isArray(group.permissions) || group.permissions.length === 0) {
        return false;
    }
    
    const groupPermissions = group.permissions.map(p => p.id);
    return groupPermissions.every(id => form.permissions.includes(id));
};

const isGroupIndeterminate = (groupId) => {
    const group = props.permissionGroups.find(g => g.id === groupId);
    if (!group || !group.permissions || !Array.isArray(group.permissions) || group.permissions.length === 0) {
        return false;
    }
    
    const groupPermissions = group.permissions.map(p => p.id);
    const selectedCount = groupPermissions.filter(id => form.permissions.includes(id)).length;
    return selectedCount > 0 && selectedCount < groupPermissions.length;
};

const submit = () => {
    form.post(route('roles.store'), {
        preserveScroll: true,
        onSuccess: () => {
            // Redirect to roles index page
            window.location.href = route('roles.index');
        }
    });
};
</script>

<template>
    <Head title="Create Role" />

    <ModernAdminLayout>
        <template #header>
            <div class="flex justify-between items-center w-full">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Role</h2>
            </div>
        </template>

        <template #breadcrumb>
            <AdminBreadcrumb :items="[
                { label: 'Roles', href: route('roles.index') },
                { label: 'Create Role', href: route('roles.create') }
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
                                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                    Unique identifier for this role (e.g. "editor")
                                </p>
                                <InputError class="mt-2" :message="form.errors.name" />
                            </div>

                            <div>
                                <h3 class="text-md font-medium text-gray-900 dark:text-gray-100 mb-4">Permissions</h3>
                                
                                <div class="space-y-6">
                                    <!-- Ungrouped Permissions -->
                                    <div class="border dark:border-gray-700 rounded-lg p-4">
                                        <div class="mb-2 flex items-center">
                                            <h4 class="text-sm font-medium text-gray-900 dark:text-gray-100">Ungrouped Permissions</h4>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                            <div v-for="permission in allPermissions.filter(p => !p.group_id)" :key="permission.id" class="flex items-center space-x-2">
                                                <Checkbox 
                                                    :id="`permission-${permission.id}`" 
                                                    v-model:checked="form.permissions" 
                                                    :value="permission.id" 
                                                />
                                                <label :for="`permission-${permission.id}`" class="text-sm text-gray-700 dark:text-gray-300">
                                                    {{ permission.display_name || permission.name }}
                                                </label>
                                            </div>
                                            <div v-if="allPermissions.filter(p => !p.group_id).length === 0" class="text-sm text-gray-500 dark:text-gray-400">
                                                No ungrouped permissions found.
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Permission Groups -->
                                    <div v-for="group in permissionGroups.filter(g => g.id)" :key="group.id" class="border dark:border-gray-700 rounded-lg p-4">
                                        <div class="mb-2 flex items-center">
                                            <Checkbox 
                                                :id="`group-${group.id}`" 
                                                :checked="isGroupChecked(group.id)"
                                                :indeterminate="isGroupIndeterminate(group.id)"
                                                @update:checked="toggleGroupPermissions(group.id, $event)"
                                            />
                                            <label :for="`group-${group.id}`" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ group.display_name }}
                                            </label>
                                        </div>
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2 ml-6">
                                            <div v-for="permission in group.permissions" :key="permission.id" class="flex items-center space-x-2">
                                                <Checkbox 
                                                    :id="`permission-${permission.id}`" 
                                                    v-model:checked="form.permissions" 
                                                    :value="permission.id" 
                                                />
                                                <label :for="`permission-${permission.id}`" class="text-sm text-gray-700 dark:text-gray-300">
                                                    {{ permission.display_name || permission.name }}
                                                </label>
                                            </div>
                                            <div v-if="!group.permissions || group.permissions.length === 0" class="text-sm text-gray-500 dark:text-gray-400">
                                                No permissions in this group.
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <InputError class="mt-2" :message="form.errors.permissions" />
                            </div>

                            <div class="flex items-center gap-4 mt-6">
                                <Button type="submit" :disabled="form.processing">
                                    Create Role
                                </Button>
                                <Link :href="route('roles.index')">
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