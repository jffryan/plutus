<script setup>
import { ref, onMounted } from "vue";
import BaseForm from '@/components/ui/forms/BaseForm.vue'

const props = defineProps({
  portfolioId: {
    type: Number,
    required: true,
  },
});

const assets = ref([]);
async function fetchAssets() {
  try {
    const response = await axios.get('/api/assets')
    assets.value = response.data.data
  } catch (err) {
    console.error('Error loading assets:', err)
  }
}

onMounted(() => {
  fetchAssets();
});

const snapshotForm = ref({
  snapshot_date: new Date().toISOString().slice(0, 10),
  notes: "",
});

const manualHoldings = ref([
  { asset_id: null, quantity: 0, value: 0, cost_basis: 0 },
]);

function addManualRow() {
  manualHoldings.value.push({
    asset_id: null,
    quantity: 0,
    value: 0,
    cost_basis: 0,
  });
}

async function submitManualSnapshot() {
  try {
    const payload = {
      snapshot_date: snapshotForm.value.snapshot_date,
      notes: snapshotForm.value.notes,
      holdings: manualHoldings.value,
    };

    await axios.post(
      `/api/portfolios/${props.portfolioId}/snapshots`,
      payload
    );
    alert("Manual snapshot created.");
    manualHoldings.value = [
      { asset_id: null, quantity: 0, value: 0, price_per_unit: null },
    ];
  } catch (err) {
    console.error("Failed to submit manual snapshot:", err);
    alert("Submission failed.");
  }
}
</script>

<template>
  <BaseForm :onSubmit="submitManualSnapshot" customClass="mb-6">
    <template #title>
      <h2 class="font-semibold">Create Snapshot</h2>
    </template>
    <form @submit.prevent="submitManualSnapshot" class="space-y-3">
      <label class="block">
        <span class="text-sm text-gray-700">Snapshot Date</span>
        <input v-model="snapshotForm.snapshot_date" type="date" class="input" required />
      </label>
      <textarea v-model="snapshotForm.notes" placeholder="Notes" class="input"></textarea>

      <div v-for="(entry, index) in manualHoldings" :key="index" class="grid grid-cols-4 gap-2 mt-2">
        <label class="text-sm text-gray-700">Asset
          <select v-model="entry.asset_id" class="input" required>
            <option disabled value="">Select asset</option>
            <option v-for="asset in assets" :key="asset.id" :value="asset.id">
              {{
                asset.ticker
                  ? `${asset.ticker} - ${asset.label}`
                  : asset.label
              }}
              ({{ asset.type }})
            </option>
          </select>
        </label>
        <label class="text-sm text-gray-700">Quantity
          <input v-model="entry.quantity" type="number" step="0.0001" placeholder="Quantity" class="input" />
        </label>
        <label class="text-sm text-gray-700">Value
          <input v-model="entry.value" type="number" step="0.01" placeholder="Total Value" class="input" />
        </label>
        <label class="text-sm text-gray-700">Cost Basis
          <input v-model="entry.cost_basis" type="number" step="0.01" placeholder="Cost Basis" class="input" />
        </label>
      </div>

      <button type="button" @click="addManualRow" class="btn mt-2 mr-2">
        + Add Row
      </button>
      <button type="submit" class="block btn">Create Snapshot</button>
    </form>
  </BaseForm>
</template>