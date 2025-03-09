<script setup>
import { DropdownMenu as DropdownMenuPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  open: { type: Boolean, required: false },
  defaultOpen: { type: Boolean, required: false },
  class: { type: String, required: false }
})

defineEmits(['update:open'])
</script>

<template>
  <DropdownMenuPrimitive.Sub
    :open="open"
    :defaultOpen="defaultOpen"
    :class="cn('relative', props.class)"
    @update:open="$emit('update:open', $event)"
  >
    <slot />
  </DropdownMenuPrimitive.Sub>
</template>
