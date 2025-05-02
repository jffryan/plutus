<template>
  <div class="p-6 max-w-3xl mx-auto">
    <h1 class="text-2xl font-bold mb-4">Manage Assets</h1>

    <form @submit.prevent="createAsset" class="space-y-3 bg-gray-100 p-4 rounded mb-6">
      <h2 class="font-semibold">Add New Asset</h2>
      <input v-model="form.ticker" type="text" placeholder="Ticker (optional)" class="input" />
      <input v-model="form.label" type="text" placeholder="Label (required)" class="input" required />
      <select v-model="form.type" required class="input">
        <option disabled value="">Select Type</option>
        <option value="stock">Stock</option>
        <option value="crypto">Crypto</option>
        <option value="cash">Cash</option>
        <option value="etf">ETF</option>
        <option value="bond">Bond</option>
        <option value="other">Other</option>
      </select>
      <button type="submit" class="btn">Add Asset</button>
    </form>

    <h2 class="text-xl font-semibold mb-2">Existing Assets</h2>
    <ul v-if="assets.length" class="space-y-2">
      <li v-for="asset in assets" :key="asset.id" class="border p-3 rounded">
        <strong>{{ asset.label }}</strong>
        <span v-if="asset.ticker">&nbsp;({{ asset.ticker }})</span>
        <span class="text-sm text-gray-500">&nbsp;—&nbsp;{{ asset.type }}</span>
      </li>
    </ul>
    <p v-else class="text-gray-500">No assets yet.</p>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'

const assets = ref([])
const form = ref({
  ticker: '',
  label: '',
  type: ''
})

async function fetchAssets() {
  const res = await axios.get('/api/assets')
  assets.value = res.data.data
}

async function createAsset() {
  const res = await axios.post('/api/assets', form.value)
  assets.value.push(res.data.asset)
  form.value = { ticker: '', label: '', type: '' }
}

onMounted(fetchAssets)
</script>

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
