<script setup>
import NarrowColumnLayout from "@/components/layouts/NarrowColumnLayout.vue";
// import CreateBudgetForm from "@/components/budgets/CreateBudgetForm.vue";
</script>

<template>
    <narrow-column-layout>
        <h1 class="text-2xl font-bold mb-4">Create New Budget</h1>
        <p class="mb-4">
            Use the form below to create a new budget.
            <router-link
                :to="{ name: 'budgets.index' }"
                class="text-blue-500 hover:underline"
            >
                Back to Budgets
            </router-link>
        </p>
        <!-- <CreateBudgetForm /> -->
    </narrow-column-layout>
</template>
