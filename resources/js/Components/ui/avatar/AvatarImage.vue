<script setup>
import { Avatar as AvatarPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  src: { type: String, required: true },
  alt: { type: String, required: false, default: '' },
  class: { type: String, required: false }
})
</script>

<template>
  <AvatarPrimitive.Image
    :src="src"
    :alt="alt"
    :class="cn('aspect-square h-full w-full object-cover', props.class)"
  />
</template>
