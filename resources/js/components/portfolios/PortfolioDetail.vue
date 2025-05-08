<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRoute } from "vue-router";
import CreatePortfolioSnapshot from "@/components/portfolios/CreatePortfolioSnapshot.vue";
import PortfolioHoldingsTable from "@/components/portfolios/PortfolioHoldingsTable.vue";

const route = useRoute();
const portfolio = ref(null);
const snapshots = ref([]);

async function fetchPortfolio() {
  try {
    const response = await axios.get(`/api/portfolios/${route.params.id}`);
    portfolio.value = response.data.data;
  } catch (err) {
    console.error("Error loading portfolio:", err);
  }
}

async function fetchSnapshots() {
  try {
    const response = await axios.get(`/api/portfolios/${route.params.id}/snapshots`);
    snapshots.value = response.data.data.sort((a, b) => {
      return new Date(b.snapshot_date) - new Date(a.snapshot_date);
    });
  } catch (err) {
    console.error("Error loading portfolio snapshots:", err);
  }
}

onMounted(() => {
  fetchPortfolio();
  fetchSnapshots();
});


</script>

<template>
  <div class="p-6 max-w-5xl mx-auto">
    <div v-if="portfolio">
      <h1 class="text-2xl font-bold mb-2">{{ portfolio.name }}</h1>
      <p class="text-gray-600">{{ portfolio.description }}</p>
      <p class="text-sm text-gray-500 italic mb-4">
        {{ portfolio.notes }}
      </p>

      <h2 class="text-xl font-semibold mt-6">Holdings</h2>
      <div v-if="portfolio.holdings.length" class="mt-3">
        <PortfolioHoldingsTable :holdings="portfolio.holdings" />
        <router-link :to="{ name: 'PortfolioTransactionEditor', params: { id: portfolio.id } }" class="btn mt-4">
          + Add / Edit Transactions
        </router-link>
      </div>
      <h2 class="text-xl font-semibold mt-8">Snapshots</h2>
      <div v-if="snapshots.length" class="mt-3 space-y-2">
        <div v-for="snapshot in snapshots" :key="snapshot.id"
          class="border p-3 rounded shadow-sm hover:bg-gray-50 flex justify-between items-center">
          <div>
            <p class="font-medium">{{ snapshot.snapshot_date }}</p>
            <p class="text-sm text-gray-500 italic">{{ snapshot.notes || '—' }}</p>
          </div>
          <router-link class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700"
            :to="{ name: 'SnapshotDetail', params: { id: snapshot.id } }">
            View
          </router-link>
        </div>
      </div>
      <div v-else class="text-gray-500 mt-2">No snapshots yet.</div>
      <div v-else class="text-gray-500 mt-2">No holdings found.</div>
      <CreatePortfolioSnapshot :portfolio-id="portfolio.id" class="mt-12" />
    </div>

    <div v-else class="text-gray-500">Loading portfolio...</div>
  </div>
</template>
