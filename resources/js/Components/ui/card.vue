<template>
  <div :class="['rounded-lg border bg-card text-card-foreground shadow-sm', className]">
    <slot />
  </div>
</template>

<script setup>
defineProps({
  className: {
    type: String,
    default: '',
  },
})
</script>

<script>
import { h } from 'vue'

export const CardHeader = {
  render() {
    return h('div', { class: 'flex flex-col space-y-1.5 p-6' }, this.$slots.default?.())
  }
}

export const CardTitle = {
  props: {
    as: {
      type: String,
      default: 'h3',
    },
  },
  render() {
    return h(this.as, { class: 'text-2xl font-semibold leading-none tracking-tight' }, this.$slots.default?.())
  }
}

export const CardDescription = {
  render() {
    return h('p', { class: 'text-sm text-muted-foreground' }, this.$slots.default?.())
  }
}

export const CardContent = {
  render() {
    return h('div', { class: 'p-6 pt-0' }, this.$slots.default?.())
  }
}

export const CardFooter = {
  render() {
    return h('div', { class: 'flex items-center p-6 pt-0' }, this.$slots.default?.())
  }
}
</script> 