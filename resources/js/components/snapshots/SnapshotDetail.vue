<script setup>
import { ref, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import axios from 'axios'

import SnapshotHeader from '@/components/snapshots/SnapshotHeader.vue'
import SnapshotHoldingsTable from '@/components/snapshots/SnapshotHoldingsTable.vue'

const route = useRoute()
const snapshot = ref(null)

async function fetchSnapshot() {
  try {
    const res = await axios.get(`/api/snapshots/${route.params.id}`)
    snapshot.value = res.data.data
  } catch (err) {
    console.error('Failed to load snapshot:', err)
  }
}

onMounted(fetchSnapshot)
</script>

<template>
  <div class="p-6 max-w-5xl mx-auto">
    <div v-if="snapshot">
      <SnapshotHeader :snapshot="snapshot" />
      <SnapshotHoldingsTable :snapshot="snapshot" />
    </div>
    <div v-else class="text-gray-500">Loading snapshot...</div>
  </div>
</template>