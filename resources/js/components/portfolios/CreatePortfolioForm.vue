<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import BaseForm from '@/components/ui/forms/BaseForm.vue'

const router = useRouter()
const form = ref({
  name: '',
  description: '',
  notes: ''
})

async function createPortfolio() {
  try {
    const response = await axios.post('/api/portfolios', form.value)
    router.push({ name: 'PortfolioDetail', params: { id: response.data.portfolio.id } })
  } catch (err) {
    console.error('Failed to create portfolio:', err)
  }
}
</script>

<template>
  <BaseForm :onSubmit="createPortfolio" customClass="mb-6">
    <template #title>
      <h2 class="font-semibold">Create New Portfolio</h2>
    </template>

    <input v-model="form.name" type="text" placeholder="Name" required class="input" />
    <textarea v-model="form.description" placeholder="Description" class="input" />
    <textarea v-model="form.notes" placeholder="Notes" class="input" />

    <template #footer>
      <button type="submit" class="btn">Create</button>
    </template>
  </BaseForm>
</template>

