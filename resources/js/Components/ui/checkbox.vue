<template>
  <input
    type="checkbox"
    :checked="checked"
    :value="value"
    @change="$emit('update:checked', $event.target.checked)"
    class="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50 dark:border-gray-600 dark:bg-gray-800"
  />
</template>

<script setup>
defineProps({
  checked: {
    type: [Array, Boolean],
    default: false,
  },
  value: {
    type: String,
    default: null,
  },
});

defineEmits(['update:checked']);
</script> 