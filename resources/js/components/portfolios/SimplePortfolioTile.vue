<script setup>
defineProps(
  {
    portfolio: {
      type: Object,
      required: true,
    },
    variant: {
      type: String,
      default: 'default',
    },
  }
)
import BaseTile from '@/components/ui/tiles/BaseTile.vue'
</script>

<template>
  <BaseTile variant="portfolio">
    <template #title>
      <router-link :to="{ name: 'PortfolioDetail', params: { id: portfolio.id } }" class="text-lg font-bold">
        {{ portfolio.name }}
      </router-link>
    </template>
    <template #description>
      <p>{{ portfolio.description }}</p>
    </template>
    <template #footer>
      <p class="italic text-xs">{{ portfolio.notes }}</p>
    </template>
  </BaseTile>
</template>
