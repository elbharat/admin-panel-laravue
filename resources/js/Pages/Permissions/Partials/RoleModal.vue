<script setup>
import { ref, watch, computed } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/ui/modal.vue';
import InputError from '@/Components/ui/input-error.vue';
import InputLabel from '@/Components/ui/input-label.vue';
import TextInput from '@/Components/ui/input.vue';
import Button from '@/Components/ui/button/Button.vue';
import Checkbox from '@/Components/ui/checkbox.vue';

const props = defineProps({
    show: Boolean,
    role: Object,
    permissionGroups: {
        type: Array,
        required: true
    }
});

const emit = defineEmits(['close']);
const submitError = ref(null);

const form = useForm({
    name: '',
    permissions: [],
});

const isEditing = ref(false);
const allPermissions = computed(() => {
    const permissions = [];
    props.permissionGroups.forEach(group => {
        if (group.permissions && Array.isArray(group.permissions)) {
            permissions.push(...group.permissions);
        }
    });
    return permissions;
});

watch(() => props.role, (newRole) => {
    isEditing.value = !!newRole;
    if (newRole) {
        form.name = newRole.name;
        form.permissions = newRole.permissions && Array.isArray(newRole.permissions) 
            ? newRole.permissions.map(p => p.id) 
            : [];
    } else {
        form.reset();
        form.permissions = []; // Pastikan array permissions kosong saat reset
    }
}, { immediate: true });

const validateForm = () => {
    let isValid = true;
    submitError.value = null;
    
    if (!form.name || form.name.trim() === '') {
        form.errors.name = 'The name field is required.';
        isValid = false;
    }
    
    return isValid;
};

const submit = () => {
    submitError.value = null;
    
    // Validasi form sebelum submit
    if (!validateForm()) {
        submitError.value = 'Please fix the errors before submitting.';
        return;
    }
    
    console.log('Submitting role form:', form.data());
    
    if (isEditing.value) {
        console.log('Updating role with ID:', props.role.id);
        console.log('PUT URL:', route('roles.update', props.role.id));
        
        form.put(route('roles.update', props.role.id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Role updated successfully');
                emit('close');
            },
            onError: (errors) => {
                console.error('Error updating role:', errors);
                submitError.value = 'Error updating role. See console for details.';
            }
        });
    } else {
        console.log('Creating new role');
        console.log('POST URL:', route('roles.store'));
        
        form.post(route('roles.store'), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Role created successfully');
                emit('close');
            },
            onError: (errors) => {
                console.error('Error creating role:', errors);
                submitError.value = 'Error creating role. See console for details.';
            }
        });
    }
};

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
</script>

<template>
    <Modal :show="show" @close="$emit('close')" max-width="2xl">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ isEditing ? 'Edit Role' : 'Create Role' }}
            </h2>

            <form @submit.prevent="submit" class="mt-6">
                <div v-if="submitError" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ submitError }}
                </div>
                
                <div class="mb-6">
                    <InputLabel for="name" value="Name" />
                    <TextInput
                        id="name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.name"
                        required
                        autofocus
                        :disabled="role && role.name === 'admin'"
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
                        {{ isEditing ? 'Save' : 'Create' }}
                    </Button>
                    <Button type="button" variant="secondary" @click="$emit('close')">
                        Cancel
                    </Button>
                </div>
            </form>
        </div>
    </Modal>
</template> 