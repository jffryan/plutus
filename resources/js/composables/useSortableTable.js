import { ref, computed } from 'vue'

export function useSortableTable(data, defaultKey = 'value', defaultDirection = 'desc') {
  const sortKey = ref(defaultKey)
  const sortDirection = ref(defaultDirection) // 'asc' or 'desc'

  function toggleSort(key) {
    if (sortKey.value === key) {
      sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc'
    } else {
      sortKey.value = key
      sortDirection.value = 'asc'
    }
  }

  const sortedData = computed(() => {
    const copied = [...data.value]
    return copied.sort((a, b) => {
      const aVal = extractValue(a, sortKey.value)
      const bVal = extractValue(b, sortKey.value)

      if (aVal === bVal) return 0
      const result = aVal > bVal ? 1 : -1
      return sortDirection.value === 'asc' ? result : -result
    })
  })

  return { sortKey, sortDirection, toggleSort, sortedData }
}

// handles nested keys like 'asset.label' or computed props like gain
function extractValue(row, key) {
  const quantity = parseFloat(row.quantity)
  const value = parseFloat(row.value)
  const cost_basis = parseFloat(row.cost_basis)

  switch (key) {
    case 'gain':
      return value - cost_basis
    case 'price_per_unit':
      return quantity > 0 ? value / quantity : 0
    case 'cost_per_unit':
      return quantity > 0 ? cost_basis / quantity : 0
    default: {
      const keys = key.split('.')
      const val = keys.reduce((obj, k) => obj?.[k], row)
      return typeof val === 'string' && !isNaN(val) ? parseFloat(val) : val
    }
  }
}