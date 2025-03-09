<template>
  <input
    ref="checkboxRef"
    type="checkbox"
    :id="id"
    :name="name"
    :value="value"
    v-model="isChecked"
    :disabled="disabled"
    :required="required"
    class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600 dark:border-gray-700 dark:bg-gray-800 dark:ring-offset-gray-800 dark:focus:ring-indigo-500"
  />
</template>

<script setup>
import { computed, ref, watch } from 'vue';

const props = defineProps({
  checked: {
    type: [Boolean, Array],
    default: false,
  },
  value: {
    type: [String, Number, Boolean],
    default: null,
  },
  id: {
    type: String,
    default: null,
  },
  name: {
    type: String,
    default: null,
  },
  disabled: {
    type: Boolean,
    default: false,
  },
  required: {
    type: Boolean,
    default: false,
  },
  indeterminate: {
    type: Boolean,
    default: false,
  },
});

const emit = defineEmits(['update:checked']);

const checkboxRef = ref(null);

watch(() => props.indeterminate, (value) => {
  if (checkboxRef.value) {
    checkboxRef.value.indeterminate = value;
  }
});

const isChecked = computed({
  get() {
    if (Array.isArray(props.checked)) {
      return props.checked.includes(props.value);
    }
    return props.checked;
  },
  set(checked) {
    if (Array.isArray(props.checked)) {
      if (checked) {
        emit('update:checked', [...props.checked, props.value]);
      } else {
        emit('update:checked', props.checked.filter(value => value !== props.value));
      }
    } else {
      emit('update:checked', checked);
    }
  }
});
</script> 