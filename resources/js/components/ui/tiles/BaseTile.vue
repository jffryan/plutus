<script setup>
import { computed } from 'vue'

const { variant } = defineProps({
  variant: { type: String, default: 'default' }
})

const variantClass = computed(() => {
  switch (variant) {
    case 'portfolio': return 'bg-blue-50'
    case 'warning': return 'bg-yellow-50'
    default: return ''
  }
})
</script>
<template>
  <div class="border p-4 rounded shadow-sm" :class="variantClass">
    <slot name="title" />
    <slot name="description" />
    <slot name="footer" />
  </div>
</template>


