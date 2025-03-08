<script setup>
import { SelectContent, SelectPortal } from 'radix-vue';
</script>

<template>
    <SelectPortal>
        <SelectContent class="SelectContent" v-bind="$attrs">
            <slot />
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