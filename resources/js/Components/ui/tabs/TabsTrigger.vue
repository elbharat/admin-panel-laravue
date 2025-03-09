<script setup>
import { Tabs as TabsPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  value: { type: String, required: true },
  disabled: { type: Boolean, required: false },
  class: { type: String, required: false }
})
</script>

<template>
  <TabsPrimitive.Trigger
    :class="cn(
      'inline-flex items-center justify-center whitespace-nowrap rounded-sm px-3 py-1.5 text-sm font-medium ring-offset-background transition-all focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 data-[state=active]:bg-background data-[state=active]:text-foreground data-[state=active]:shadow-sm',
      props.class
    )"
    v-bind="props"
  >
    <slot />
  </TabsPrimitive.Trigger>
</template>
