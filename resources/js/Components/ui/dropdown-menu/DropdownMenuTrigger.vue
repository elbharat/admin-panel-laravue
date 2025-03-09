<script setup>
import { DropdownMenu as DropdownMenuPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  asChild: { type: Boolean, required: false },
  class: { type: String, required: false }
})
</script>

<template>
  <DropdownMenuPrimitive.Trigger
    :class="cn(
      'flex cursor-default select-none items-center justify-center rounded-sm px-2 py-1.5 text-sm outline-none focus:bg-accent data-[state=open]:bg-accent',
      props.class
    )"
    v-bind="{ asChild: props.asChild }"
  >
    <slot />
  </DropdownMenuPrimitive.Trigger>
</template>
