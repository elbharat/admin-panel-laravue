<script setup>
import { useForm } from '@inertiajs/vue3';
import Modal from '@/Components/ui/modal.vue';
import InputError from '@/Components/ui/input-error.vue';
import InputLabel from '@/Components/ui/input-label.vue';
import TextInput from '@/Components/ui/input.vue';
import Button from '@/Components/ui/button/Button.vue';
import { watch, ref } from 'vue';

const props = defineProps({
    show: Boolean,
    roles: Array,
    user: Object
});

const emit = defineEmits(['close']);
const isEditing = ref(false);
const submitError = ref(null);

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: ''
});

watch(() => props.user, (newUser) => {
    isEditing.value = !!newUser;
    if (newUser) {
        form.name = newUser.name;
        form.email = newUser.email;
        form.role = newUser.roles && newUser.roles.length > 0 ? newUser.roles[0].name : '';
        // Reset password fields for editing
        form.password = '';
        form.password_confirmation = '';
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
    
    if (!form.email || form.email.trim() === '') {
        form.errors.email = 'The email field is required.';
        isValid = false;
    }
    
    if (!form.role || form.role.trim() === '') {
        form.errors.role = 'The role field is required.';
        isValid = false;
    }
    
    if (!isEditing.value) {
        if (!form.password || form.password.trim() === '') {
            form.errors.password = 'The password field is required.';
            isValid = false;
        }
        
        if (!form.password_confirmation || form.password_confirmation.trim() === '') {
            form.errors.password_confirmation = 'The password confirmation field is required.';
            isValid = false;
        }
        
        if (form.password !== form.password_confirmation) {
            form.errors.password_confirmation = 'The password confirmation does not match.';
            isValid = false;
        }
    } else if (form.password) {
        // Jika password diisi saat edit, pastikan confirmation juga diisi dan cocok
        if (!form.password_confirmation || form.password_confirmation.trim() === '') {
            form.errors.password_confirmation = 'The password confirmation field is required.';
            isValid = false;
        }
        
        if (form.password !== form.password_confirmation) {
            form.errors.password_confirmation = 'The password confirmation does not match.';
            isValid = false;
        }
    }
    
    return isValid;
};

function submit() {
    submitError.value = null;
    
    // Validasi form sebelum submit
    if (!validateForm()) {
        submitError.value = 'Please fix the errors before submitting.';
        return;
    }
    
    console.log('Submitting form:', form.data());
    
    if (isEditing.value) {
        // Update existing user
        console.log('Updating user with ID:', props.user.id);
        console.log('PUT URL:', route('users.update', props.user.id));
        
        form.put(route('users.update', props.user.id), {
            onSuccess: () => {
                console.log('User updated successfully');
                emit('close');
            },
            onError: (errors) => {
                console.error('Error updating user:', errors);
                submitError.value = 'Error updating user. See console for details.';
            },
            preserveScroll: true
        });
    } else {
        // Create new user
        console.log('Creating new user');
        console.log('POST URL:', route('users.store'));
        
        form.post(route('users.store'), {
            onSuccess: () => {
                console.log('User created successfully');
                emit('close');
            },
            onError: (errors) => {
                console.error('Error creating user:', errors);
                submitError.value = 'Error creating user. See console for details.';
            },
            preserveScroll: true
        });
    }
}
</script>

<template>
    <Modal :show="show" @close="$emit('close')" class="p-6">
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ isEditing ? 'Edit User' : 'Create User' }}
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
                />
                <InputError class="mt-2" :message="form.errors.name" />
            </div>

            <div>
                <InputLabel for="email" value="Email" />
                <TextInput
                    id="email"
                    type="email"
                    class="mt-1 block w-full"
                    v-model="form.email"
                    required
                />
                <InputError class="mt-2" :message="form.errors.email" />
            </div>

            <div>
                <InputLabel value="Role" />
                <div class="mt-2 space-y-2">
                    <div 
                        v-for="role in roles" 
                        :key="role.name" 
                        class="flex items-center"
                    >
                        <input
                            type="radio"
                            :id="role.name"
                            :value="role.name"
                            v-model="form.role"
                            name="role"
                            class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-700 dark:bg-gray-900 dark:ring-offset-gray-800"
                            required
                        >
                        <label 
                            :for="role.name" 
                            class="ml-2 block text-sm font-medium text-gray-900 dark:text-gray-100"
                        >
                            {{ role.name }}
                        </label>
                    </div>
                </div>
                <InputError class="mt-2" :message="form.errors.role" />
            </div>

            <div v-if="!isEditing || (isEditing && form.password)">
                <InputLabel for="password" value="Password" />
                <TextInput
                    id="password"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password"
                    :required="!isEditing"
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password" />
            </div>

            <div v-if="!isEditing || (isEditing && form.password)">
                <InputLabel for="password_confirmation" value="Confirm Password" />
                <TextInput
                    id="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    v-model="form.password_confirmation"
                    :required="!isEditing"
                    autocomplete="new-password"
                />
                <InputError class="mt-2" :message="form.errors.password_confirmation" />
            </div>

            <div class="flex items-center gap-4">
                <Button type="submit" :disabled="form.processing">
                    {{ isEditing ? 'Update' : 'Create' }}
                </Button>
                <Button type="button" variant="secondary" @click="$emit('close')">
                    Cancel
                </Button>
            </div>
        </form>
    </Modal>
</template> 