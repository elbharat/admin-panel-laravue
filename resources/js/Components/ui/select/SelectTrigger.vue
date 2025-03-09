<script setup>
import { SelectTrigger } from 'radix-vue';
import { ChevronDown } from 'lucide-vue-next';
</script>

<template>
    <SelectTrigger 
        class="flex h-10 w-full items-center justify-between rounded-md border border-gray-300 bg-transparent px-3 py-2 text-sm ring-offset-white placeholder:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 dark:border-gray-700 dark:ring-offset-gray-950 dark:placeholder:text-gray-400 dark:focus:ring-indigo-500"
    >
        <slot />
        <ChevronDown class="h-4 w-4 opacity-50" />
    </SelectTrigger>
</template>

<style scoped>
.SelectTrigger {
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
    border-radius: 0.375rem;
    border: 1px solid #e2e8f0;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    background-color: white;
    color: #1a202c;
    cursor: pointer;
    width: 100%;
}

.dark .SelectTrigger {
    background-color: #1a202c;
    border-color: #4a5568;
    color: #e2e8f0;
}

.SelectTrigger:hover {
    background-color: #f7fafc;
}

.dark .SelectTrigger:hover {
    background-color: #2d3748;
}
</style> 