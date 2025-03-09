<script setup>
import { cn } from '@/lib/utils';

const props = defineProps({
  href: { type: String, required: false },
  class: { type: String, required: false }
});
</script>

<template>
  <component
    :is="href ? 'a' : 'span'"
    :href="href"
    :class="cn(
      'text-sm font-medium transition-colors hover:text-foreground',
      !href && 'text-muted-foreground',
      props.class
    )"
  >
    <slot />
  </component>
</template>
