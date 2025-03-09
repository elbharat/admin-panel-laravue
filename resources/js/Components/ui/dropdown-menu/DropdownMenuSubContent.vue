<script setup>
import { DropdownMenu as DropdownMenuPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  class: { type: String, required: false },
  align: { type: String, required: false, default: 'start' },
  alignOffset: { type: Number, required: false, default: -4 },
  sideOffset: { type: Number, required: false, default: -4 },
  avoidCollisions: { type: Boolean, required: false, default: true }
})
</script>

<template>
  <DropdownMenuPrimitive.Portal>
    <DropdownMenuPrimitive.SubContent
      :class="cn(
        'z-50 min-w-[8rem] overflow-hidden rounded-md border bg-popover p-1 text-popover-foreground shadow-lg data-[state=open]:animate-in data-[state=closed]:animate-out data-[state=closed]:fade-out-0 data-[state=open]:fade-in-0 data-[state=closed]:zoom-out-95 data-[state=open]:zoom-in-95 data-[side=bottom]:slide-in-from-top-2 data-[side=left]:slide-in-from-right-2 data-[side=right]:slide-in-from-left-2 data-[side=top]:slide-in-from-bottom-2',
        props.class
      )"
      v-bind="props"
    >
      <slot />
    </DropdownMenuPrimitive.SubContent>
  </DropdownMenuPrimitive.Portal>
</template>
