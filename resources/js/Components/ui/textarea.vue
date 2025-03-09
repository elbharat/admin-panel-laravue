<script setup>
import { computed } from 'vue';

const props = defineProps({
    modelValue: {
        type: [String, Number],
        default: ''
    },
    id: {
        type: String,
        default: null
    },
    name: {
        type: String,
        default: null
    },
    placeholder: {
        type: String,
        default: null
    },
    rows: {
        type: [String, Number],
        default: 3
    },
    disabled: {
        type: Boolean,
        default: false
    },
    required: {
        type: Boolean,
        default: false
    },
    autofocus: {
        type: Boolean,
        default: false
    },
    class: {
        type: String,
        default: ''
    }
});

const emit = defineEmits(['update:modelValue']);

const input = computed({
    get() {
        return props.modelValue;
    },
    set(value) {
        emit('update:modelValue', value);
    }
});

const classes = computed(() => {
    return `block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 dark:bg-gray-800 dark:text-gray-100 dark:ring-gray-700 dark:placeholder:text-gray-500 dark:focus:ring-indigo-500 ${props.class}`;
});
</script>

<template>
    <textarea
        :id="id"
        :name="name"
        :value="modelValue"
        @input="$emit('update:modelValue', $event.target.value)"
        :placeholder="placeholder"
        :rows="rows"
        :disabled="disabled"
        :required="required"
        :autofocus="autofocus"
        :class="classes"
    ></textarea>
</template> 