<script setup>
import { ref } from 'vue';
import { Head, useForm, Link } from '@inertiajs/vue3';
import ModernAdminLayout from '@/Layouts/ModernAdminLayout.vue';
import InputError from '@/Components/ui/input-error.vue';
import InputLabel from '@/Components/ui/input-label.vue';
import TextInput from '@/Components/ui/input.vue';
import Button from '@/Components/ui/button/Button.vue';
import Textarea from '@/Components/ui/textarea.vue';
import AdminBreadcrumb from '@/Components/AdminBreadcrumb.vue';

const form = useForm({
    name: '',
    display_name: '',
    description: '',
});

const submit = () => {
    // Ensure display_name is set if empty
    if (!form.display_name) {
        form.display_name = form.name;
    }
    
    form.post(route('permission-groups.store'), {
        preserveScroll: true,
        onSuccess: () => {
            // Redirect to permissions index page
            window.location.href = route('permissions.index');
        }
    });
};
</script>

<template>
    <Head title="Create Permission Group" />

    <ModernAdminLayout>
        <template #header>
            <div class="flex justify-between items-center w-full">
                <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Create Permission Group</h2>
            </div>
        </template>

        <template #breadcrumb>
            <AdminBreadcrumb :items="[
                { label: 'Permissions', href: route('permissions.index') },
                { label: 'Create Group', href: route('permission-groups.create') }
            ]" />
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <form @submit.prevent="submit" class="space-y-6">
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
                                    Create Group
                                </Button>
                                <Link :href="route('permissions.index')">
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