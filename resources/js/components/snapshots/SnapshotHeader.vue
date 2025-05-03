<script setup>
defineProps({
  snapshot: {
    type: Object,
    required: true
  }
})
</script>


<template>
  <div>
    <h1 class="text-2xl font-bold mb-2">
      Snapshot – {{ snapshot.snapshot_date }}
    </h1>
    <p class="text-gray-600 mb-4 italic">{{ snapshot.notes }}</p>
    <p class="text-lg font-semibold mb-6">
      Total Value: ${{ parseFloat(snapshot.total_value).toFixed(2) }}
    </p>
  </div>
</template>

