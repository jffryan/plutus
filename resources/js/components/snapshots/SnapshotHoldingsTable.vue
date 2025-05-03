<script setup>
import { computed } from 'vue'

const props = defineProps({
  snapshot: Object
})

const gainLossMap = computed(() =>
  props.snapshot.holdings.map(h => ({
    id: h.asset.id,
    gainLoss: parseFloat(h.value) - parseFloat(h.cost_basis)
  }))
)

const maxGain = computed(() =>
  Math.max(...gainLossMap.value.map(r => r.gainLoss))
)

const maxLoss = computed(() =>
  Math.min(...gainLossMap.value.map(r => r.gainLoss))
)

function rowClass(h) {
  const gain = parseFloat(h.value) - parseFloat(h.cost_basis)
  if (gain === maxGain.value) return 'bg-blue-50 hover:bg-blue-100'
  if (gain === maxLoss.value) return 'bg-red-50 hover:bg-red-100'
  return ''
}
</script>


<template>
  <table class="w-full text-sm border border-gray-300 mt-4">
    <thead class="bg-gray-100">
      <tr>
        <th class="text-left p-2">Asset</th>
        <th class="text-right p-2">Quantity</th>
        <th class="text-right p-2">Cost Basis</th>
        <th class="text-right p-2">Market Value</th>
        <th class="text-right p-2">Cost/Unit</th>
        <th class="text-right p-2">Price/Unit</th>
        <th class="text-right p-2">Gain/Loss</th>
      </tr>
    </thead>
    <tbody>
      <tr
        v-for="h in snapshot.holdings"
        :key="h.asset.id"
        :class="['border-t border-gray-200 hover:bg-gray-50', rowClass(h)]"
      >
        <td class="p-2">
          <span class="font-medium">{{ h.asset.label }}</span>
          <span class="text-xs text-gray-500">({{ h.asset.ticker }})</span>
        </td>
        <td class="p-2 text-right">{{ parseFloat(h.quantity).toFixed(2) }}</td>
        <td class="p-2 text-right">${{ parseFloat(h.cost_basis).toFixed(2) }}</td>
        <td class="p-2 text-right">${{ parseFloat(h.value).toFixed(2) }}</td>
        <td class="p-2 text-right">${{ (h.cost_basis / h.quantity).toFixed(2) }}</td>
        <td class="p-2 text-right">${{ (h.value / h.quantity).toFixed(2) }}</td>
        <td
          class="p-2 text-right font-semibold"
          :class="h.value - h.cost_basis >= 0 ? 'text-blue-600' : 'text-red-600'"
        >
          ${{ (h.value - h.cost_basis).toFixed(2) }}
        </td>
      </tr>
    </tbody>
  </table>
</template>

