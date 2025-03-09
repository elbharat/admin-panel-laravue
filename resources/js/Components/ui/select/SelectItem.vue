<script setup>
import { SelectItem, SelectItemText, SelectItemIndicator } from 'radix-vue';
import { Check } from 'lucide-vue-next';

defineProps({
    value: {
        type: [String, Number],
        required: true
    }
});
</script>

<template>
    <SelectItem
        class="relative flex w-full cursor-pointer select-none items-center rounded-sm py-1.5 pl-8 pr-2 text-sm outline-none focus:bg-gray-100 data-[disabled]:pointer-events-none data-[highlighted]:bg-indigo-600 data-[highlighted]:text-white dark:focus:bg-gray-800 dark:data-[highlighted]:bg-indigo-600 dark:data-[highlighted]:text-white"
    >
        <span class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
            <SelectItemIndicator>
                <Check class="h-4 w-4" />
            </SelectItemIndicator>
        </span>
        <SelectItemText>
            <slot />
        </SelectItemText>
    </SelectItem>
</template>

<style scoped>
.SelectItem {
    position: relative;
    display: flex;
    align-items: center;
    padding: 0.5rem 0.75rem;
    font-size: 0.875rem;
    line-height: 1.25rem;
    color: #1a202c;
    user-select: none;
    outline: none;
}

.SelectItem:hover {
    background-color: #f7fafc;
    cursor: pointer;
}

.dark .SelectItem {
    color: #e2e8f0;
}

.dark .SelectItem:hover {
    background-color: #2d3748;
}

.SelectItem[data-highlighted] {
    background-color: #e2e8f0;
    color: #1a202c;
}

.dark .SelectItem[data-highlighted] {
    background-color: #4a5568;
    color: #e2e8f0;
}
</style> 