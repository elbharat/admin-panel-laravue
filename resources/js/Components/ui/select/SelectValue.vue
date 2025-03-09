<script setup>
import { SelectValue } from 'radix-vue';
</script>

<template>
    <SelectValue>
        <slot />
    </SelectValue>
</template>

<style scoped>
.SelectValue {
    display: block;
    line-height: 1.25rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
</style> 