<script setup>
import BaseHoldingsTable from '@/components/ui/tables/BaseHoldingsTable.vue'
const props = defineProps({ snapshot: Object })
</script>

<template>
  <BaseHoldingsTable :holdings="snapshot.holdings" :showTotals="true" />
</template>
