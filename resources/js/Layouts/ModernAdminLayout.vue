<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { 
  Home, 
  Settings, 
  LogOut, 
  User, 
  Moon,
  Sun,
  Menu as MenuIcon,
  X
} from 'lucide-vue-next';
import Button from '@/Components/ui/button.vue';

const showingMobileMenu = ref(false);
const darkMode = ref(false);
const page = usePage();
const user = computed(() => page.props.auth.user);

const toggleDarkMode = () => {
  darkMode.value = !darkMode.value;
  if (darkMode.value) {
    document.documentElement.classList.add('dark');
  } else {
    document.documentElement.classList.remove('dark');
  }
};

// Hanya menampilkan menu yang sudah ada implementasinya
const navigation = [
    { name: 'Dashboard', href: route('dashboard'), icon: Home, current: route().current('dashboard') },
    { name: 'Pengaturan Website', href: route('admin.settings.index'), icon: Settings, current: route().current('admin.settings.*') },
];
</script>

<template>
  <div class="flex h-screen bg-gray-50 dark:bg-gray-900">
    <!-- Sidebar -->
    <aside 
      class="fixed inset-y-0 left-0 z-50 w-64 transform bg-white shadow-lg transition-transform duration-300 dark:bg-gray-800 lg:static lg:translate-x-0"
      :class="{ '-translate-x-full': !showingMobileMenu, 'translate-x-0': showingMobileMenu }"
    >
      <div class="flex h-full flex-col">
        <!-- Sidebar header -->
        <div class="flex h-16 items-center justify-between border-b px-4 dark:border-gray-700">
          <Link :href="route('dashboard')" class="flex items-center">
            <span class="text-xl font-bold text-gray-800 dark:text-white">AdminPanel</span>
          </Link>
          <button 
            @click="showingMobileMenu = false" 
            class="rounded-md p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white lg:hidden"
          >
            <X class="h-6 w-6" />
          </button>
        </div>
        
        <!-- Sidebar content -->
        <nav class="flex-1 space-y-1 px-2 py-4">
          <div v-for="item in navigation" :key="item.name" class="mb-2">
            <Link
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
        
        <!-- Sidebar footer -->
        <div class="border-t p-4 dark:border-gray-700">
          <div class="flex items-center">
            <div class="flex-shrink-0">
              <div class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700">
                <User class="h-5 w-5 text-gray-600 dark:text-gray-300" />
              </div>
            </div>
            <div class="ml-3">
              <p class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ user.name }}</p>
              <p class="text-xs text-gray-500 dark:text-gray-400">{{ user.email }}</p>
            </div>
          </div>
          <div class="mt-3">
            <Link
              :href="route('logout')"
              method="post"
              as="button"
              class="flex w-full items-center rounded-md px-2 py-2 text-sm font-medium text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-gray-700"
            >
              <LogOut class="mr-2 h-4 w-4" />
              Log Out
            </Link>
          </div>
        </div>
      </div>
    </aside>

    <!-- Main content -->
    <div class="flex flex-1 flex-col overflow-hidden">
      <!-- Top navbar -->
      <header class="z-10 border-b bg-white shadow-sm dark:border-gray-700 dark:bg-gray-800">
        <div class="flex h-16 items-center justify-between px-4">
          <div class="flex items-center lg:hidden">
            <button 
              @click="showingMobileMenu = true" 
              class="rounded-md p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
            >
              <MenuIcon class="h-6 w-6" />
            </button>
          </div>
          
          <div class="flex flex-1 items-center justify-end">
            <div class="flex items-center space-x-4">
              <!-- Dark mode toggle -->
              <button 
                @click="toggleDarkMode" 
                class="rounded-md p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
              >
                <Moon v-if="!darkMode" class="h-5 w-5" />
                <Sun v-else class="h-5 w-5" />
              </button>
              
              <!-- Profile dropdown -->
              <div class="relative">
                <Link
                  :href="route('profile.edit')"
                  class="flex items-center rounded-md p-1 text-gray-500 hover:bg-gray-100 hover:text-gray-900 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                >
                  <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-200 dark:bg-gray-700">
                    <User class="h-4 w-4 text-gray-600 dark:text-gray-300" />
                  </div>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </header>

      <!-- Page content -->
      <main class="flex-1 overflow-auto bg-gray-50 dark:bg-gray-900">
        <!-- Page header -->
        <div class="border-b bg-white px-4 py-4 dark:border-gray-700 dark:bg-gray-800 sm:px-6 lg:px-8" v-if="$slots.header">
          <slot name="header" />
        </div>
        
        <!-- Page body -->
        <div class="p-4 sm:p-6 lg:p-8">
          <slot />
        </div>
      </main>
    </div>
  </div>
</template> 