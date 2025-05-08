<script setup>
import { computed } from 'vue'
import { useSortableTable } from '@/composables/useSortableTable'

const props = defineProps({
  holdings: Array,  // raw holdings data from snapshot or portfolio
  showTotals: Boolean,
})

const gainLossMap = computed(() =>
  props.holdings.map((h) => ({
    id: h.asset.id,
    gainLoss: parseFloat(h.value) - parseFloat(h.cost_basis),
  }))
)

const maxGain = computed(() => Math.max(...gainLossMap.value.map((r) => r.gainLoss)))
const maxLoss = computed(() => Math.min(...gainLossMap.value.map((r) => r.gainLoss)))

function rowClass(h) {
  const gain = parseFloat(h.value) - parseFloat(h.cost_basis)
  if (gain === maxGain.value) return 'bg-blue-50 hover:bg-blue-100'
  if (gain === maxLoss.value) return 'bg-red-50 hover:bg-red-100'
  return ''
}

const totals = computed(() => {
  const cost_basis = props.holdings.reduce((sum, h) => sum + parseFloat(h.cost_basis), 0)
  const value = props.holdings.reduce((sum, h) => sum + parseFloat(h.value), 0)
  const gain_loss = value - cost_basis

  return { cost_basis, value, gain_loss }
})

const { sortKey, sortDirection, toggleSort, sortedData } = useSortableTable(
  computed(() => props.holdings),
  'value',
  'desc'
)
</script>

<template>
  <table class="w-full text-sm border border-gray-300 mt-4">
    <thead class="bg-gray-100">
      <tr>
        <th class="text-left p-2 cursor-pointer" @click="toggleSort('asset.label')">
          Asset
          <span v-if="sortKey === 'asset.label'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
        </th>
        <th class="text-right p-2 cursor-pointer" @click="toggleSort('quantity')">
          Quantity
          <span v-if="sortKey === 'quantity'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
        </th>
        <th class="text-right p-2 cursor-pointer" @click="toggleSort('cost_basis')">
          Cost Basis
          <span v-if="sortKey === 'cost_basis'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
        </th>
        <th class="text-right p-2 cursor-pointer" @click="toggleSort('value')">
          Market Value
          <span v-if="sortKey === 'value'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
        </th>
        <th class="text-right p-2 cursor-pointer" @click="toggleSort('cost_per_unit')">
          Cost/Unit
          <span v-if="sortKey === 'cost_per_unit'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
        </th>
        <th class="text-right p-2 cursor-pointer" @click="toggleSort('price_per_unit')">
          Price/Unit
          <span v-if="sortKey === 'price_per_unit'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
        </th>
        <th class="text-right p-2 cursor-pointer" @click="toggleSort('gain')">
          Gain/Loss
          <span v-if="sortKey === 'gain'">{{ sortDirection === 'asc' ? '▲' : '▼' }}</span>
        </th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="(h, i) in sortedData" :key="i" :class="['border-t border-gray-200 hover:bg-gray-50', rowClass(h)]">
        <td class="p-2">
          <span class="font-medium">{{ h.asset.label }}</span>
          <span class="text-xs text-gray-500"> ({{ h.asset.ticker }})</span>
        </td>
        <td class="p-2 text-right">{{ parseFloat(h.quantity).toFixed(2) }}</td>
        <td class="p-2 text-right">${{ parseFloat(h.cost_basis).toFixed(2) }}</td>
        <td class="p-2 text-right">${{ parseFloat(h.value).toFixed(2) }}</td>
        <td class="p-2 text-right">${{ (h.cost_basis / h.quantity).toFixed(2) }}</td>
        <td class="p-2 text-right">${{ (h.value / h.quantity).toFixed(2) }}</td>
        <td class="p-2 text-right font-semibold" :class="h.value - h.cost_basis >= 0 ? 'text-blue-600' : 'text-red-600'">
          ${{ (h.value - h.cost_basis).toFixed(2) }}
        </td>
      </tr>
    </tbody>
    <tfoot v-if="showTotals" class="bg-gray-50 font-semibold border-t border-gray-300">
      <tr>
        <td class="p-2 text-right" colspan="2">Totals</td>
        <td class="p-2 text-right">${{ totals.cost_basis.toFixed(2) }}</td>
        <td class="p-2 text-right">${{ totals.value.toFixed(2) }}</td>
        <td class="p-2 text-right" colspan="2"></td>
        <td class="p-2 text-right" :class="totals.gain_loss >= 0 ? 'text-blue-600' : 'text-red-600'">
          ${{ totals.gain_loss.toFixed(2) }}
        </td>
      </tr>
    </tfoot>
  </table>
</template>
