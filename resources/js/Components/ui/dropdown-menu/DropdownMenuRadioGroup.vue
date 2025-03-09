<script setup>
import { DropdownMenu as DropdownMenuPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  modelValue: { type: [String, Number], required: false },
  class: { type: String, required: false }
})

defineEmits(['update:modelValue'])
</script>

<template>
  <DropdownMenuPrimitive.RadioGroup
    :model-value="modelValue"
    :class="cn('p-1', props.class)"
    @update:model-value="$emit('update:modelValue', $event)"
  >
    <slot />
  </DropdownMenuPrimitive.RadioGroup>
</template>
