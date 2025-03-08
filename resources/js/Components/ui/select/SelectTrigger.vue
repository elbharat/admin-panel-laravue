<script setup>
import { SelectTrigger } from 'radix-vue';
import { ChevronDown } from 'lucide-vue-next';
</script>

<template>
    <SelectTrigger class="SelectTrigger" v-bind="$attrs">
        <slot />
        <ChevronDown class="w-4 h-4 opacity-50" />
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