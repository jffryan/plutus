<script setup>
const props = defineProps({
  onSubmit: {
    type: Function,
    required: true
  },
  customClass: {
    type: String,
    default: ''
  }
})
</script>

<template>
  <form @submit.prevent="onSubmit" class="space-y-3 bg-gray-100 p-4 rounded" :class="customClass">
    <slot name="title" />
    <slot />
    <slot name="footer" />
  </form>
</template>

