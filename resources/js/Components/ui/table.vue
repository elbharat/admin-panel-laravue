<template>
  <div :class="['w-full overflow-auto', className]">
    <table class="w-full caption-bottom text-sm">
      <slot />
    </table>
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

export const TableHeader = {
  render() {
    return h('thead', { class: '[&_tr]:border-b' }, this.$slots.default?.())
  }
}

export const TableBody = {
  render() {
    return h('tbody', { class: '[&_tr:last-child]:border-0' }, this.$slots.default?.())
  }
}

export const TableFooter = {
  render() {
    return h('tfoot', { class: 'border-t bg-muted/50 font-medium [&>tr]:last:border-b-0' }, this.$slots.default?.())
  }
}

export const TableRow = {
  render() {
    return h('tr', { class: 'border-b transition-colors hover:bg-muted/50 data-[state=selected]:bg-muted' }, this.$slots.default?.())
  }
}

export const TableHead = {
  render() {
    return h('th', { class: 'h-10 px-2 text-left align-middle font-medium text-muted-foreground [&:has([role=checkbox])]:pr-0 [&>[role=checkbox]]:translate-y-[2px]' }, this.$slots.default?.())
  }
}

export const TableCell = {
  render() {
    return h('td', { class: 'p-2 align-middle [&:has([role=checkbox])]:pr-0 [&>[role=checkbox]]:translate-y-[2px]' }, this.$slots.default?.())
  }
}

export const TableCaption = {
  render() {
    return h('caption', { class: 'mt-4 text-sm text-muted-foreground' }, this.$slots.default?.())
  }
}
</script> 