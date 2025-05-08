<script setup>
import { ref, computed } from 'vue'

const props = defineProps({
  localHoldings: Array,
  usdHolding: Object
})

const emit = defineEmits(['sellApplied'])

const selectedAssetId = ref('')
const sellQuantity = ref(0)
const sellPrice = ref(0)
const error = ref(null)

const assetOptions = computed(() =>
  props.localHoldings.map(h => ({
    id: h.asset.id,
    label: `${h.asset.ticker || 'Unnamed'} – ${h.asset.label}`
  }))
)

function applySell() {
  const asset = props.localHoldings.find(h => h.asset.id === parseInt(selectedAssetId.value))
  if (!asset || sellQuantity.value <= 0 || sellPrice.value <= 0) {
    error.value = 'Invalid asset or input.'
    return
  }

  if (parseFloat(asset.quantity) < sellQuantity.value) {
    error.value = 'Cannot sell more than you own.'
    return
  }

  emit('sellApplied', {
    assetId: asset.asset.id,
    quantity: sellQuantity.value,
    price: sellPrice.value
  })

  selectedAssetId.value = ''
  sellQuantity.value = 0
  sellPrice.value = 0
  error.value = null
}
</script>

<template>
  <div class="mt-10 border-t pt-6">
    <h2 class="text-lg font-semibold mb-2">Sell Asset</h2>
    <div class="grid grid-cols-3 gap-4 items-end">
      <label class="block">
        <span class="text-sm text-gray-700">Asset</span>
        <select v-model="selectedAssetId" class="input w-full">
          <option disabled value="">Select an asset</option>
          <option v-for="opt in assetOptions" :key="opt.id" :value="opt.id">
            {{ opt.label }}
          </option>
        </select>
      </label>

      <label class="block">
        <span class="text-sm text-gray-700">Quantity</span>
        <input
          v-model.number="sellQuantity"
          type="number"
          class="input w-full"
          min="0"
          step="any"
        />
      </label>

      <label class="block">
        <span class="text-sm text-gray-700">Price per Unit</span>
        <input
          v-model.number="sellPrice"
          type="number"
          class="input w-full"
          min="0"
          step="any"
        />
      </label>
    </div>

    <button class="btn mt-4" @click="applySell">Apply Sell</button>
    <p v-if="error" class="text-red-600 text-sm mt-2">{{ error }}</p>
  </div>
</template>
