import { defineStore } from "pinia";
import axios from "axios";

export const useUserDataStore = defineStore("UserDataStore", {
    state: () => ({
        budgets: [],
    }),
    actions: {
        async fetchBudgets() {
            try {
                const res = await axios.get("/api/budgets");
                this.budgets = res.data;
            } catch (error) {
                this.budgets = [];
                console.error("Failed to fetch budgets", error);
            }
        },
        clearData() {
            this.budgets = [];
        },
    },
});
