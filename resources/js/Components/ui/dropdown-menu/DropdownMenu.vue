<script setup>
import { DropdownMenu as DropdownMenuPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  open: { type: Boolean, required: false },
  defaultOpen: { type: Boolean, required: false },
  modal: { type: Boolean, required: false, default: true },
  dir: { type: String, required: false },
  class: { type: String, required: false }
})

defineEmits(['update:open'])
</script>

<template>
  <DropdownMenuPrimitive.Root v-bind="props">
    <slot />
  </DropdownMenuPrimitive.Root>
</template>
