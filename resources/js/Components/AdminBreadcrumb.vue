<template>
  <div class="mb-4">
    <Breadcrumb>
      <BreadcrumbList>
        <BreadcrumbItem>
          <BreadcrumbLink :href="route('dashboard')">Dashboard</BreadcrumbLink>
        </BreadcrumbItem>
        <BreadcrumbSeparator />
        
        <template v-for="(item, index) in items" :key="index">
          <BreadcrumbItem>
            <template v-if="index === items.length - 1">
              <BreadcrumbPage>{{ item.label }}</BreadcrumbPage>
            </template>
            <template v-else>
              <BreadcrumbLink :href="item.href">{{ item.label }}</BreadcrumbLink>
            </template>
          </BreadcrumbItem>
          <BreadcrumbSeparator v-if="index < items.length - 1" />
        </template>
      </BreadcrumbList>
    </Breadcrumb>
  </div>
</template>

<script setup>
import { Breadcrumb, BreadcrumbItem, BreadcrumbLink, BreadcrumbList, BreadcrumbPage, BreadcrumbSeparator } from '@/Components/ui/breadcrumb';

defineProps({
  items: {
    type: Array,
    default: () => [],
    // Format: [{ label: 'Users', href: route('users.index') }, { label: 'Create User' }]
    // Item terakhir tidak perlu href karena itu adalah halaman saat ini
  }
});
</script> 