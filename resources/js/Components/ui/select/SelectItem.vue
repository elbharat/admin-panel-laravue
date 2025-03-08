<script setup>
import { SelectItem } from 'radix-vue';

defineProps({
    value: {
        type: [String, Number],
        required: true
    }
});
</script>

<template>
    <SelectItem class="SelectItem" v-bind="$attrs" :value="value">
        <slot />
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