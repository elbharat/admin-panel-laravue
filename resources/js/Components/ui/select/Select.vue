<script setup>
import { SelectRoot } from 'radix-vue';

defineProps({
    modelValue: {
        type: String,
        required: true
    }
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
    <SelectRoot 
        :value="modelValue"
        @update:value="(val) => emit('update:modelValue', val)"
    >
        <slot />
    </SelectRoot>
</template> 