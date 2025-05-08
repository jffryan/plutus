<script setup>
import BaseHoldingsTable from '@/components/ui/tables/BaseHoldingsTable.vue'
const props = defineProps({ holdings: Array })
</script>

<template>
  <BaseHoldingsTable :holdings="holdings" :showTotals="true" />
</template>
