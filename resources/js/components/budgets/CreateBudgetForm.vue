<script setup>
import { ref } from "vue";
import BaseForm from "@/components/ui/forms/BaseForm.vue";

const createBudget = () => {
    // Logic to create a budget
    console.log("Budget created:", form);
};

const form = ref({
    name: "",
    description: "",
    notes: "",
});
</script>

<template>
    <base-form :onSubmit="createBudget" customClass="mb-6">
        <input
            v-model="form.name"
            type="text"
            placeholder="Name"
            required
            class="input"
        />
        <textarea
            v-model="form.description"
            placeholder="Description"
            class="input"
        />
        <textarea v-model="form.notes" placeholder="Notes" class="input" />

        <template #footer>
            <button type="submit" class="btn">Create</button>
        </template>
    </base-form>
</template>
