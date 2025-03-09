<script setup>
import { ref, watch } from 'vue';
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/ui/modal.vue';
import InputError from '@/Components/ui/input-error.vue';
import InputLabel from '@/Components/ui/input-label.vue';
import TextInput from '@/Components/ui/input.vue';
import Button from '@/Components/ui/button/Button.vue';
import Textarea from '@/Components/ui/textarea.vue';

const props = defineProps({
    show: Boolean,
    group: Object,
});

const emit = defineEmits(['close']);
const submitError = ref(null);

const form = useForm({
    name: '',
    display_name: '',
    description: '',
});

const isEditing = ref(false);

watch(() => props.group, (newGroup) => {
    isEditing.value = !!newGroup;
    if (newGroup) {
        form.name = newGroup.name || '';
        form.display_name = newGroup.display_name || newGroup.name || '';
        form.description = newGroup.description || '';
    } else {
        form.reset();
    }
}, { immediate: true });

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
    
    console.log('Submitting group form:', form.data());
    
    // Ensure display_name is set if empty
    if (!form.display_name) {
        form.display_name = form.name;
    }
    
    if (isEditing.value) {
        console.log('Updating group with ID:', props.group.id);
        console.log('PUT URL:', route('permission-groups.update', props.group.id));
        
        form.put(route('permission-groups.update', props.group.id), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Group updated successfully');
                emit('close');
            },
            onError: (errors) => {
                console.error('Error updating group:', errors);
                submitError.value = 'Error updating group. See console for details.';
            }
        });
    } else {
        console.log('Creating new group');
        console.log('POST URL:', route('permission-groups.store'));
        
        form.post(route('permission-groups.store'), {
            preserveScroll: true,
            onSuccess: () => {
                console.log('Group created successfully');
                emit('close');
            },
            onError: (errors) => {
                console.error('Error creating group:', errors);
                submitError.value = 'Error creating group. See console for details.';
            }
        });
    }
};
</script>

<template>
    <Modal :show="show" @close="$emit('close')">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ isEditing ? 'Edit Permission Group' : 'Create Permission Group' }}
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
                        Unique identifier for this group (e.g. "user_management")
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
                        Human-readable name (e.g. "User Management")
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