<script setup>
import { ref, onMounted } from "vue";
import axios from "axios";
import NarrowColumnLayout from "@/components/layouts/NarrowColumnLayout.vue";
import CreatePortfolioForm from "@/components/portfolios/CreatePortfolioForm.vue";
import SimplePortfolioTile from "@/components/portfolios/SimplePortfolioTile.vue";

const portfolios = ref([]);
const isFormToggled = ref(false);
const toggleForm = () => {
    isFormToggled.value = !isFormToggled.value;
};

async function fetchPortfolios() {
    try {
        const response = await axios.get("/api/portfolios");
        portfolios.value = response.data.data;
    } catch (err) {
        console.error("Failed to load portfolios:", err);
    }
}

onMounted(fetchPortfolios);
</script>

<template>
    <narrow-column-layout>
        <h1 class="text-2xl font-bold mb-4">Your Portfolios</h1>
        <!-- New Portfolio Form -->
        <button
            v-if="!isFormToggled"
            @click="toggleForm"
            class="text-left font-semibold space-y-3 bg-gray-100 p-4 rounded w-full mb-6"
        >
            {{ isFormToggled ? "Cancel" : "Create New Portfolio +" }}
        </button>
        <CreatePortfolioForm v-if="isFormToggled" @click.self="toggleForm" />
        <!-- List of Portfolios -->
        <div v-if="portfolios.length" class="space-y-4">
            <SimplePortfolioTile
                v-for="p in portfolios"
                :key="p.id"
                :portfolio="p"
            />
        </div>
        <div v-else class="text-gray-600">No portfolios found.</div>
    </narrow-column-layout>
</template>
