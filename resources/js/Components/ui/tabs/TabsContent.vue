<script setup>
import { Tabs as TabsPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  value: { type: String, required: true },
  forceMount: { type: Boolean, required: false },
  class: { type: String, required: false }
})
</script>

<template>
  <TabsPrimitive.Content
    :class="cn(
      'mt-2 ring-offset-background focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2',
      props.class
    )"
    v-bind="props"
  >
    <slot />
  </TabsPrimitive.Content>
</template>
