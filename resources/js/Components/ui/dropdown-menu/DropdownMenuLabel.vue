<script setup>
import { DropdownMenu as DropdownMenuPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  inset: { type: Boolean, required: false },
  class: { type: String, required: false }
})
</script>

<template>
  <DropdownMenuPrimitive.Label
    :class="cn(
      'px-2 py-1.5 text-sm font-semibold',
      inset && 'pl-8',
      props.class
    )"
  >
    <slot />
  </DropdownMenuPrimitive.Label>
</template>
