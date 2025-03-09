<script setup>
import { cn } from '@/lib/utils'

const props = defineProps({
  class: { type: String, required: false }
})
</script>

<template>
  <nav :class="cn('flex', props.class)" aria-label="breadcrumb">
    <ol class="flex flex-wrap items-center gap-1.5">
      <slot />
    </ol>
  </nav>
</template>
