<script setup>
const props = defineProps({
  localHoldings: Array,
  manualEdits: Object
})

const emit = defineEmits(['manualEdited'])

function handleEdit(assetId, field, value) {
  emit('manualEdited', { assetId, field, value: parseFloat(value) })
}
</script>

<template>
  <div class="mt-10 border-t pt-6">
    <h2 class="text-lg font-semibold mb-2">Manual Overrides</h2>
    <div class="space-y-4">
      <div
        v-for="h in localHoldings"
        :key="h.asset.id"
        class="grid grid-cols-4 gap-4 items-center border p-4 rounded"
        :class="{ 'bg-gray-100': manualEdits[h.asset.id] }"
      >
        <div>
          <p class="font-semibold">{{ h.asset.label }}</p>
          <p class="text-xs text-gray-500">{{ h.asset.ticker }}</p>
        </div>
        <input
          type="number"
          class="input"
          :value="h.quantity"
          @input="handleEdit(h.asset.id, 'quantity', $event.target.value)"
          placeholder="Quantity"
        />
        <input
          type="number"
          class="input"
          :value="h.cost_basis"
          @input="handleEdit(h.asset.id, 'cost_basis', $event.target.value)"
          placeholder="Cost Basis"
        />
        <input
          type="number"
          class="input"
          :value="h.value"
          @input="handleEdit(h.asset.id, 'value', $event.target.value)"
          placeholder="Value"
        />
      </div>
    </div>
  </div>
</template>
