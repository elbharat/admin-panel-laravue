<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { 
    Home, 
    Users2,
    Settings,
    Shield,
    UserCog,
} from 'lucide-vue-next';

const page = usePage();
const user = computed(() => page.props.auth.user);

const navigation = computed(() => [
    { 
        name: 'Dashboard', 
        href: route('dashboard'), 
        icon: Home, 
        current: route().current('dashboard') 
    },
    { 
        name: 'Users', 
        href: route('users.index'), 
        icon: Users2, 
        current: route().current('users.*'),
        show: user.value?.is_admin || user.value?.permissions?.includes('manage users')
    },
    { 
        name: 'Permissions', 
        href: route('permissions.index'), 
        icon: Shield, 
        current: route().current('permissions.*'),
        show: user.value?.is_admin
    },
    { 
        name: 'Roles', 
        href: route('roles.index'), 
        icon: UserCog, 
        current: route().current('roles.*'),
        show: user.value?.is_admin
    },
]);
</script>

<template>
    <nav class="flex-1 space-y-1 px-2 py-4">
        <div v-for="item in navigation" :key="item.name" class="mb-2">
            <Link
                v-if="!item.hasOwnProperty('show') || item.show"
                :href="item.href"
                :class="[
                    item.current
                        ? 'bg-gray-100 text-gray-900 dark:bg-gray-700 dark:text-white' 
                        : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white',
                    'group flex items-center rounded-md px-2 py-2 text-base font-medium'
                ]"
            >
                <component :is="item.icon" class="mr-3 h-5 w-5 flex-shrink-0" />
                {{ item.name }}
            </Link>
        </div>
    </nav>
</template> 