<script setup>
import NarrowColumnLayout from "@/components/layouts/NarrowColumnLayout.vue";
import CreatePortfolioForm from "@/components/portfolios/CreatePortfolioForm.vue";
</script>

<template>
    <narrow-column-layout>
        <h1 class="text-2xl font-bold mb-4">Create New Portfolio</h1>
        <p class="mb-4">
            Use the form below to create a new portfolio.
            <router-link
                :to="{ name: 'portfolios.index' }"
                class="text-blue-500 hover:underline"
            >
                Back to Portfolios
            </router-link>
        </p>
        <CreatePortfolioForm />
    </narrow-column-layout>
</template>
