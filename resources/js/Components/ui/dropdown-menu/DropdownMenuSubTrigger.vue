<script setup>
import { DropdownMenu as DropdownMenuPrimitive } from 'radix-vue'
import { ChevronRight } from 'lucide-vue-next'
import { cn } from '@/lib/utils'

const props = defineProps({
  inset: { type: Boolean, required: false },
  class: { type: String, required: false },
  disabled: { type: Boolean, required: false }
})
</script>

<template>
  <DropdownMenuPrimitive.SubTrigger
    v-bind="props"
    :class="cn(
      'flex cursor-default select-none items-center rounded-sm px-2 py-1.5 text-sm outline-none focus:bg-accent data-[state=open]:bg-accent',
      inset && 'pl-8',
      props.class
    )"
  >
    <slot />
    <ChevronRight class="ml-auto h-4 w-4" />
  </DropdownMenuPrimitive.SubTrigger>
</template>
