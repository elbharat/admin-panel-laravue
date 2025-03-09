<script setup>
import { DropdownMenu as DropdownMenuPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  class: { type: String, required: false }
})
</script>

<template>
  <DropdownMenuPrimitive.Group :class="cn('p-1', props.class)">
    <slot />
  </DropdownMenuPrimitive.Group>
</template>
