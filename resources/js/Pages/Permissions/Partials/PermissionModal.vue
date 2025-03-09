<script setup>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/ui/modal.vue';
import InputError from '@/Components/ui/input-error.vue';
import InputLabel from '@/Components/ui/input-label.vue';
import TextInput from '@/Components/ui/input.vue';
import Button from '@/Components/ui/button/Button.vue';
import Textarea from '@/Components/ui/textarea.vue';
import Select from '@/Components/ui/select/Select.vue';
import SelectTrigger from '@/Components/ui/select/SelectTrigger.vue';
import SelectValue from '@/Components/ui/select/SelectValue.vue';
import SelectContent from '@/Components/ui/select/SelectContent.vue';
import SelectItem from '@/Components/ui/select/SelectItem.vue';

const props = defineProps({
    show: Boolean,
    permission: Object,
    groupId: [Number, String, null],
    groups: {
        type: Array,
        required: true
    }
});

const emit = defineEmits(['close']);
const submitError = ref(null);

const form = useForm({
    name: '',
    display_name: '',
    description: '',
    group_id: null,
});

const isEditing = ref(false);

watch(() => props.permission, (newPermission) => {
    isEditing.value = !!newPermission;
    if (newPermission) {
        form.name = newPermission.name || '';
        form.display_name = newPermission.display_name || newPermission.name || '';
        form.description = newPermission.description || '';
        form.group_id = newPermission.group_id;
    } else {
        form.reset();
        form.group_id = props.groupId;
    }
}, { immediate: true });

watch(() => props.groupId, (newGroupId) => {
    if (!isEditing.value) {
        form.group_id = newGroupId;
    }
});

const validateForm = () => {
    let isValid = true;
    submitError.value = null;
    
    if (!form.name || form.name.trim() === '') {
        form.errors.name = 'The name field is required.';
        isValid = false;
    }
    
    if (!form.display_name || form.display_name.trim() === '') {
        form.errors.display_name = 'The display name field is required.';
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
    
    console.log('Submitting permission form:', form.data());
    
    // Ensure display_name is set if empty
    if (!form.display_name) {
        form.display_name = form.name;
    }
    
    if (isEditing.value) {
        console.log('Updating permission with ID:', props.permission.id);
        console.log('PUT URL:', route('permissions.update', props.permission.id));
        
        form.put(route('permissions.update', props.permission.id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Permission updated successfully');
                emit('close');
            },
            onError: (errors) => {
                console.error('Error updating permission:', errors);
                submitError.value = 'Error updating permission. See console for details.';
            }
        });
    } else {
        console.log('Creating new permission');
        console.log('POST URL:', route('permissions.store'));
        
        form.post(route('permissions.store'), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Permission created successfully');
                emit('close');
            },
            onError: (errors) => {
                console.error('Error creating permission:', errors);
                submitError.value = 'Error creating permission. See console for details.';
            }
        });
    }
};
</script>

<template>
    <Modal :show="show" @close="$emit('close')">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ isEditing ? 'Edit Permission' : 'Create Permission' }}
            </h2>

            <form @submit.prevent="submit" class="mt-6 space-y-6">
                <div v-if="submitError" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                    {{ submitError }}
                </div>
                
                <div>
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
                        Unique identifier for this permission (e.g. "manage_users")
                    </p>
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div>
                    <InputLabel for="display_name" value="Display Name" />
                    <TextInput
                        id="display_name"
                        type="text"
                        class="mt-1 block w-full"
                        v-model="form.display_name"
                        required
                    />
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        Human-readable name (e.g. "Manage Users")
                    </p>
                    <InputError class="mt-2" :message="form.errors.display_name" />
                </div>

                <div>
                    <InputLabel for="description" value="Description" />
                    <Textarea
                        id="description"
                        class="mt-1 block w-full"
                        v-model="form.description"
                        rows="3"
                    />
                    <InputError class="mt-2" :message="form.errors.description" />
                </div>

                <div>
                    <InputLabel for="group" value="Group" />
                    <Select v-model="form.group_id" class="mt-1">
                        <SelectTrigger class="w-full">
                            <SelectValue placeholder="Select a group" />
                        </SelectTrigger>
                        <SelectContent>
                            <SelectItem :value="null">None</SelectItem>
                            <SelectItem v-for="group in groups.filter(g => g.id)" :key="group.id" :value="group.id">
                                {{ group.display_name }}
                            </SelectItem>
                        </SelectContent>
                    </Select>
                    <InputError class="mt-2" :message="form.errors.group_id" />
                </div>

                <div class="flex items-center gap-4">
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