import { defineStore } from "pinia";
import axios from "axios";

export const useAuthStore = defineStore("AuthStore", {
    state: () => ({
        user: null,
    }),
    getters: {
        isLoggedIn: (state) => !!state.user,
    },
    actions: {
        async fetchUser() {
            try {
                const res = await axios.get("/api/user");
                this.user = res.data;
            } catch {
                this.user = null;
            }
        },
        async logout() {
            await axios.post("/logout");
            this.user = null;
        },
    },
});
