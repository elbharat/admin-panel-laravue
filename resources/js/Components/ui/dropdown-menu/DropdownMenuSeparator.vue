<script setup>
import { DropdownMenu as DropdownMenuPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  class: { type: String, required: false }
})
</script>

<template>
  <DropdownMenuPrimitive.Separator
    :class="cn('-mx-1 my-1 h-px bg-muted', props.class)"
  />
</template>
