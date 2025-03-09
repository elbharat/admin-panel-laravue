<script setup>
import { Avatar as AvatarPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  class: { type: String, required: false },
  size: { type: String, required: false, default: 'sm' },
  shape: { type: String, required: false, default: 'circle' }
})

const sizeClasses = {
  xs: 'h-6 w-6',
  sm: 'h-8 w-8',
  md: 'h-10 w-10',
  lg: 'h-12 w-12',
  xl: 'h-14 w-14'
}

const shapeClasses = {
  circle: 'rounded-full',
  square: 'rounded-md'
}
</script>

<template>
  <AvatarPrimitive.Root
    :class="cn(
      'relative flex shrink-0 overflow-hidden',
      sizeClasses[size],
      shapeClasses[shape],
      props.class
    )"
  >
    <slot />
  </AvatarPrimitive.Root>
</template>
