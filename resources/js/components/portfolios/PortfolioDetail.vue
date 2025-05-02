<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRoute } from "vue-router";
import CreatePortfolioSnapshot from "@/components/portfolios/CreatePortfolioSnapshot.vue";

const route = useRoute();
const portfolio = ref(null);

async function fetchPortfolio() {
  try {
    const response = await axios.get(`/api/portfolios/${route.params.id}`);
    portfolio.value = response.data.data;
  } catch (err) {
    console.error("Error loading portfolio:", err);
  }
}

onMounted(() => {
  fetchPortfolio();
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
      <div v-if="portfolio.holdings.length" class="mt-3 space-y-2">
        <div v-for="holding in portfolio.holdings" :key="holding.id" class="border p-4 rounded shadow-sm">
          <div class="flex justify-between">
            <div>
              <p class="font-medium">
                {{ holding.asset.label }}
                <span class="text-xs text-gray-500">({{ holding.asset.ticker }})</span>
              </p>
              <p class="text-sm text-gray-600">
                Quantity: {{ holding.quantity }}
              </p>
              <p class="text-sm text-gray-600">
                Target:
                {{
                  (holding.target_allocation * 100).toFixed(
                    1
                  )
                }}%
              </p>
            </div>
            <div class="text-right">
              <p class="font-semibold text-green-600">
                ${{ holding.current_value?.toFixed(2) }}
              </p>
            </div>
          </div>
        </div>
      </div>
      <div v-else class="text-gray-500 mt-2">No holdings found.</div>
      <CreatePortfolioSnapshot :portfolio-id="portfolio.id" class="mt-12" />
    </div>

    <div v-else class="text-gray-500">Loading portfolio...</div>
  </div>
</template>
