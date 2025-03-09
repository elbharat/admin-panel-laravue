<script setup>
import { DropdownMenu as DropdownMenuPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  inset: { type: Boolean, required: false },
  class: { type: String, required: false },
  disabled: { type: Boolean, required: false }
})
</script>

<template>
  <DropdownMenuPrimitive.Item
    :class="cn(
      'relative flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none transition-colors focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50',
      inset && 'pl-8',
      props.class
    )"
    :disabled="disabled"
  >
    <slot />
  </DropdownMenuPrimitive.Item>
</template>
