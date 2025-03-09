<script setup>
import { DropdownMenu as DropdownMenuPrimitive } from 'radix-vue'
import { Check } from 'lucide-vue-next'
import { cn } from '@/lib/utils'

const props = defineProps({
  checked: { type: Boolean, required: false },
  class: { type: String, required: false },
  disabled: { type: Boolean, required: false }
})

defineEmits(['update:checked'])
</script>

<template>
  <DropdownMenuPrimitive.CheckboxItem
    v-bind="props"
    :class="cn(
      'relative flex cursor-default select-none items-center rounded-sm py-1.5 pl-8 pr-2 text-sm outline-none transition-colors focus:bg-accent focus:text-accent-foreground data-[disabled]:pointer-events-none data-[disabled]:opacity-50',
      props.class
    )"
  >
    <span class="absolute left-2 flex h-3.5 w-3.5 items-center justify-center">
      <DropdownMenuPrimitive.ItemIndicator>
        <Check class="h-4 w-4" />
      </DropdownMenuPrimitive.ItemIndicator>
    </span>
    <slot />
  </DropdownMenuPrimitive.CheckboxItem>
</template>
