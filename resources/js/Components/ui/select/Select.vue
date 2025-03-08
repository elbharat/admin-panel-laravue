<script setup>
import { SelectRoot } from 'radix-vue';

defineProps({
    modelValue: {
        type: [String, Number],
        required: true
    }
});

defineEmits(['update:modelValue']);
</script>

<template>
    <SelectRoot v-bind="$attrs" :model-value="modelValue" @update:model-value="$emit('update:modelValue', $event)">
        <slot />
    </SelectRoot>
</template> 