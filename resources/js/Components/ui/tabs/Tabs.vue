<script setup>
import { Tabs as TabsPrimitive } from 'radix-vue'
import { cn } from '@/lib/utils'

const props = defineProps({
  defaultValue: { type: String, required: false },
  value: { type: String, required: false },
  orientation: { type: String, required: false, default: 'horizontal' },
  dir: { type: String, required: false },
  activationMode: { type: String, required: false, default: 'automatic' },
  class: { type: String, required: false }
})

defineEmits(['update:value'])
</script>

<template>
  <TabsPrimitive.Root
    v-bind="props"
    :class="cn('w-full', props.class)"
    @update:value="$emit('update:value', $event)"
  >
    <slot />
  </TabsPrimitive.Root>
</template>
