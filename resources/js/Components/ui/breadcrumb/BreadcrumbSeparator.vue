<script setup>
import { ChevronRight } from 'lucide-vue-next'
import { cn } from '@/lib/utils'

const props = defineProps({
  class: { type: String, required: false }
})
</script>

<template>
  <ChevronRight
    :class="cn('h-4 w-4 text-muted-foreground', props.class)"
    aria-hidden="true"
  />
</template>
