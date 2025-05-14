import { defineStore } from "pinia";
import axios from "axios";

export const useUserDataStore = defineStore("UserDataStore", {
    state: () => ({
        budgets: [],
        portfolios: [],
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
        async fetchPortfolios() {
            try {
                const res = await axios.get("/api/portfolios");
                this.portfolios = res.data.data;
            } catch (error) {
                this.portfolios = [];
                console.error("Failed to fetch portfolios", error);
            }
        },
        clearData() {
            this.budgets = [];
        },
    },
});
