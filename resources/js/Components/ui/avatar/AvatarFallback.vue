<script setup>
import { Avatar as AvatarPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  delayMs: { type: Number, required: false },
  class: { type: String, required: false }
})
</script>

<template>
  <AvatarPrimitive.Fallback
    :delayMs="delayMs"
    :class="cn(
      'flex h-full w-full items-center justify-center rounded-full bg-muted',
      props.class
    )"
  >
    <slot />
  </AvatarPrimitive.Fallback>
</template>
