<script setup>
import { cn } from '@/lib/utils';

const props = defineProps({
  class: { type: String, required: false },
});
</script>

<template>
  <span
    :class="cn(
      'ml-auto text-xs tracking-widest text-muted-foreground',
      props.class
    )"
  >
    <slot />
  </span>
</template>
