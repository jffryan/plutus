<script setup>
import { ref } from "vue";
import axios from "axios";
import BaseForm from "@/components/ui/forms/BaseForm.vue";

const form = ref({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
});
const error = ref(null);
const onSubmit = async () => {
    {
        error.value = null;
        try {
            const response = await axios.post("/api/register", form.value);
        } catch (err) {
            if (err.response && err.response.status === 422) {
                error.value = "Validation error. Please check your input.";
            } else {
                error.value = "An unexpected error occurred. Please try again.";
            }
        }
    }
    form.value = {
        name: "",
        email: "",
        password: "",
        password_confirmation: "",
    };
};
</script>

<template>
    <base-form :onSubmit="onSubmit">
        <template #title>
            <h1 class="text-2xl font-bold mb-4">Register</h1>
        </template>

        <input
            v-model="form.name"
            type="text"
            placeholder="Name"
            class="input"
            required
        />
        <input
            v-model="form.email"
            type="email"
            placeholder="Email"
            class="input"
            required
        />
        <input
            v-model="form.password"
            type="password"
            placeholder="Password"
            class="input"
            required
        />
        <input
            v-model="form.password_confirmation"
            type="password"
            placeholder="Confirm Password"
            class="input"
            required
        />
        <button type="submit" class="btn">Register</button>
        <p v-if="error" class="text-red-500 mt-2">{{ error }}</p>
        <template #footer>
            <p class="text-sm text-gray-500">
                Already have an account?
                <a href="/login" class="text-blue-500">Login</a>
            </p>
        </template>
    </base-form>
</template>
