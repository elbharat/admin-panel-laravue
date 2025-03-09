<script setup>
import { cn } from '@/lib/utils';

const props = defineProps({
  class: { type: String, required: false },
});
</script>

<template>
  <li :class="cn('inline-flex items-center gap-1.5', props.class)">
    <slot />
  </li>
</template>
