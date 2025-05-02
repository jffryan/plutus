<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import { useRoute } from "vue-router";

const route = useRoute();
const portfolio = ref(null);
const assets = ref([]);

async function fetchPortfolio() {
  try {
    const response = await axios.get(`/api/portfolios/${route.params.id}`);
    portfolio.value = response.data.data;
  } catch (err) {
    console.error("Error loading portfolio:", err);
  }
}

async function fetchAssets() {
  try {
    const response = await axios.get('/api/assets')
    assets.value = response.data.data
  } catch (err) {
    console.error('Error loading assets:', err)
  }
}

onMounted(() => {
  fetchPortfolio();
  fetchAssets();
});

const snapshotForm = ref({
  snapshot_date: new Date().toISOString().slice(0, 10),
  notes: "",
});

async function submitSnapshot() {
  if (!portfolio.value || !portfolio.value.holdings.length) return;

  try {
    const payload = {
      snapshot_date: snapshotForm.value.snapshot_date,
      notes: snapshotForm.value.notes,
      holdings: portfolio.value.holdings.map((h) => ({
        asset_id: h.asset.id,
        quantity: h.quantity,
        value: h.current_value, // this can be 0 if you're not computing yet
        price_per_unit: h.current_value / h.quantity,
      })),
    };

    const response = await axios.post(
      `/api/portfolios/${portfolio.value.id}/snapshots`,
      payload
    );

    alert("Snapshot created successfully.");
    snapshotForm.value.notes = "";
  } catch (err) {
    console.error("Failed to create snapshot:", err);
    alert("Snapshot creation failed.");
  }
}

const manualMode = ref(false);

const manualHoldings = ref([
  { asset_id: null, quantity: 0, value: 0, price_per_unit: null }
])

function addManualRow() {
  manualHoldings.value.push({ asset_id: null, quantity: 0, value: 0, price_per_unit: null })
}

async function submitManualSnapshot() {
  try {
    const payload = {
      snapshot_date: snapshotForm.value.snapshot_date,
      notes: snapshotForm.value.notes,
      holdings: manualHoldings.value
    }

    await axios.post(`/api/portfolios/${portfolio.value.id}/snapshots`, payload)
    alert("Manual snapshot created.")
    manualHoldings.value = [{ asset_id: null, quantity: 0, value: 0, price_per_unit: null }]
  } catch (err) {
    console.error("Failed to submit manual snapshot:", err)
    alert("Submission failed.")
  }
}
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

      <div class="flex items-center gap-3 mt-10">
        <h2 class="text-xl font-semibold">Create Snapshot</h2>
        <label class="flex items-center text-sm">
          <input type="checkbox" v-model="manualMode" class="mr-2" />
          Manual Entry Mode
        </label>
      </div>
      <div v-if="!manualMode">
        <form @submit.prevent="submitSnapshot" class="bg-gray-100 p-4 mt-3 rounded space-y-3">
          <label class="block">
            <span class="text-sm text-gray-700">Snapshot Date</span>
            <input v-model="snapshotForm.snapshot_date" type="date" class="input" required />
          </label>

          <label class="block">
            <span class="text-sm text-gray-700">Notes (optional)</span>
            <textarea v-model="snapshotForm.notes" class="input"></textarea>
          </label>

          <button type="submit" class="btn">Create Snapshot</button>
        </form>
      </div>

      <div v-else class="bg-gray-100 p-4 mt-3 rounded space-y-3">
        <form @submit.prevent="submitManualSnapshot">
          <input v-model="snapshotForm.snapshot_date" type="date" required class="input" />
          <textarea v-model="snapshotForm.notes" placeholder="Notes" class="input"></textarea>

          <div v-for="(entry, index) in manualHoldings" :key="index" class="grid grid-cols-4 gap-2 mt-2">
            <!-- We want to eventually make asset_id a dropdown here so that we can just select one instead of forcing the raw ID -->
            <select v-model="entry.asset_id" class="input" required>
              <option disabled value="">Select asset</option>
              <option v-for="asset in assets" :key="asset.id" :value="asset.id">
                {{ asset.ticker ? `${asset.ticker} – ${asset.label}` : asset.label }} ({{ asset.type }})
              </option>
            </select>
            <input v-model="entry.quantity" type="number" placeholder="Quantity" class="input" />
            <input v-model="entry.value" type="number" placeholder="Total Value" class="input" />
            <input v-model="entry.price_per_unit" type="number" placeholder="Price/Unit" class="input" />
          </div>

          <button type="button" @click="addManualRow" class="btn mt-2 mr-2">+ Add Row</button>
          <button type="submit" class="btn">Submit Manual Snapshot</button>
        </form>
      </div>

    </div>

    <div v-else class="text-gray-500">Loading portfolio...</div>
  </div>
</template>

<style scoped>
.input {
  width: 100%;
  padding: 0.5rem;
  border: 1px solid #ccc;
  border-radius: 0.375rem;
  font-size: 1rem;
}

.btn {
  padding: 0.5rem 1rem;
  background-color: #2563eb;
  color: white;
  font-weight: bold;
  border: none;
  border-radius: 0.375rem;
  cursor: pointer;
}

.btn:hover {
  background-color: #1d4ed8;
}
</style>
