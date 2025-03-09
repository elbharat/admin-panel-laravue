<script setup>
import { SelectContent, SelectPortal, SelectViewport } from 'radix-vue';
</script>

<template>
    <SelectPortal>
        <SelectContent 
            class="relative z-50 min-w-[8rem] overflow-hidden rounded-md border border-gray-200 bg-white text-gray-950 shadow-md data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 dark:border-gray-800 dark:bg-gray-950 dark:text-gray-50"
            position="popper"
            :side-offset="4"
        >
            <SelectViewport class="p-1">
                <slot />
            </SelectViewport>
        </SelectContent>
    </SelectPortal>
</template>

<style scoped>
.SelectContent {
    overflow: hidden;
    background-color: white;
    border-radius: 0.375rem;
    border: 1px solid #e2e8f0;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    width: var(--radix-select-trigger-width);
    max-height: var(--radix-select-content-available-height);
}

.dark .SelectContent {
    background-color: #1a202c;
    border-color: #4a5568;
}
</style> 