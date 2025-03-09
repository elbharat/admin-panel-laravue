<script setup>
import { reactive, ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import axios from 'axios';
import ModernAdminLayout from '@/Layouts/ModernAdminLayout.vue';
import InputError from '@/Components/ui/input-error.vue';
import InputLabel from '@/Components/ui/input-label.vue';
import TextInput from '@/Components/ui/input.vue';
import Button from '@/Components/ui/button/Button.vue';
import AdminBreadcrumb from '@/Components/AdminBreadcrumb.vue';

const props = defineProps({
    roles: Array
});

const formData = reactive({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    role: ''
});

const errors = ref({});
const isSubmitting = ref(false);
const debugInfo = ref({
    submittedData: null,
    serverResponse: null,
    lastError: null
});

async function submit(e) {
    e.preventDefault();
    
    // Reset state
    errors.value = {};
    isSubmitting.value = true;
    debugInfo.value = {
        submittedData: { ...formData, password: '[HIDDEN]' },
        serverResponse: null,
        lastError: null
    };

    try {
        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Log pre-submission state
        console.log('Submitting form with data:', {
            formData: { ...formData, password: '[HIDDEN]' },
            token: token ? 'Present' : 'Missing'
        });

        // Make request
        const response = await axios.post('/users', formData, {
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        });

        // Log success
        console.log('Server response:', response.data);
        debugInfo.value.serverResponse = response.data;

        // Redirect on success
        window.location.href = '/users';

    } catch (error) {
        console.error('Error details:', {
            status: error.response?.status,
            data: error.response?.data,
            headers: error.response?.headers
        });

        debugInfo.value.lastError = {
            status: error.response?.status,
            data: error.response?.data
        };

        if (error.response?.data?.errors) {
            errors.value = error.response.data.errors;
        } else {
            errors.value = {
                general: 'Terjadi kesalahan. Silakan coba lagi.'
            };
        }
    } finally {
        isSubmitting.value = false;
    }
}
</script>

<template>
    <Head title="Create User" />

    <ModernAdminLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Tambah User Baru
            </h2>
        </template>

        <template #breadcrumb>
            <AdminBreadcrumb :items="[
                { label: 'Users', href: route('users.index') },
                { label: 'Create User', href: route('users.create') }
            ]" />
        </template>

        <!-- Debug Panel -->
        <div class="bg-yellow-100 p-4 mb-4">
            <h3 class="font-bold">Debug Information:</h3>
            <div class="mt-2 space-y-2">
                <div>
                    <strong>Form Data:</strong>
                    <pre class="mt-1 text-sm">{{ formData }}</pre>
                </div>
                <div>
                    <strong>Submission Status:</strong>
                    <pre class="mt-1 text-sm">{{ isSubmitting ? 'Submitting...' : 'Ready' }}</pre>
                </div>
                <div>
                    <strong>Last Submitted Data:</strong>
                    <pre class="mt-1 text-sm">{{ debugInfo.submittedData || 'None' }}</pre>
                </div>
                <div>
                    <strong>Server Response:</strong>
                    <pre class="mt-1 text-sm">{{ debugInfo.serverResponse || 'None' }}</pre>
                </div>
                <div>
                    <strong>Last Error:</strong>
                    <pre class="mt-1 text-sm">{{ debugInfo.lastError || 'None' }}</pre>
                </div>
                <div v-if="Object.keys(errors).length">
                    <strong class="text-red-600">Validation Errors:</strong>
                    <pre class="mt-1 text-sm text-red-600">{{ errors }}</pre>
                </div>
            </div>
        </div>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <form @submit.prevent="submit" class="space-y-6">
                        <!-- General Error -->
                        <div v-if="errors.general" class="p-4 bg-red-100 text-red-700 rounded">
                            {{ errors.general }}
                        </div>

                        <!-- Name -->
                        <div>
                            <InputLabel for="name" value="Nama" />
                            <input
                                id="name"
                                v-model="formData.name"
                                type="text"
                                class="mt-1 block w-full rounded-md border-gray-300"
                                required
                            />
                            <div v-if="errors.name" class="mt-1 text-red-600 text-sm">
                                {{ errors.name }}
                            </div>
                        </div>

                        <!-- Email -->
                        <div>
                            <InputLabel for="email" value="Email" />
                            <input
                                id="email"
                                v-model="formData.email"
                                type="email"
                                class="mt-1 block w-full rounded-md border-gray-300"
                                required
                            />
                            <div v-if="errors.email" class="mt-1 text-red-600 text-sm">
                                {{ errors.email }}
                            </div>
                        </div>

                        <!-- Role -->
                        <div>
                            <InputLabel for="role" value="Role" />
                            <select
                                id="role"
                                v-model="formData.role"
                                class="mt-1 block w-full rounded-md border-gray-300"
                                required
                            >
                                <option value="">Pilih Role</option>
                                <option 
                                    v-for="role in roles" 
                                    :key="role.id" 
                                    :value="role.name"
                                >
                                    {{ role.name }}
                                </option>
                            </select>
                            <div v-if="errors.role" class="mt-1 text-red-600 text-sm">
                                {{ errors.role }}
                            </div>
                        </div>

                        <!-- Password -->
                        <div>
                            <InputLabel for="password" value="Password" />
                            <input
                                id="password"
                                v-model="formData.password"
                                type="password"
                                class="mt-1 block w-full rounded-md border-gray-300"
                                required
                            />
                            <div v-if="errors.password" class="mt-1 text-red-600 text-sm">
                                {{ errors.password }}
                            </div>
                        </div>

                        <!-- Password Confirmation -->
                        <div>
                            <InputLabel for="password_confirmation" value="Konfirmasi Password" />
                            <input
                                id="password_confirmation"
                                v-model="formData.password_confirmation"
                                type="password"
                                class="mt-1 block w-full rounded-md border-gray-300"
                                required
                            />
                            <div v-if="errors.password_confirmation" class="mt-1 text-red-600 text-sm">
                                {{ errors.password_confirmation }}
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center gap-4">
                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 disabled:opacity-50"
                                :disabled="isSubmitting"
                            >
                                {{ isSubmitting ? 'Menyimpan...' : 'Simpan' }}
                            </button>

                            <a
                                href="/users"
                                class="px-4 py-2 bg-gray-300 text-gray-700 rounded hover:bg-gray-400"
                                :class="{ 'pointer-events-none': isSubmitting }"
                            >
                                Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </ModernAdminLayout>
</template> 