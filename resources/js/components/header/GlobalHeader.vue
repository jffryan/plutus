<script setup>
import { computed, onMounted } from "vue";
import { useRouter } from "vue-router";
import { useAuthStore, useUserDataStore } from "@/stores";
import UserDropdown from "@/components/header/UserDropdown.vue";

const router = useRouter();
const AuthStore = useAuthStore();
const UserDataStore = useUserDataStore();

const generalLinks = [];
// const generalLinks = [{ name: "Home", path: "/" }];

const authorizedLinks = [
    { name: "Dashboard", path: "/dashboard" },
    { name: "Portfolios", path: "/portfolios" },
    { name: "Budgets", path: "/budgets" },
];

const filteredAuthorizedLinks = computed(() =>
    authorizedLinks.filter((link) => link.name !== "Budgets")
);

const guestLinks = [{ name: "Register", path: "/register" }];

const isLoggedIn = computed(() => AuthStore.isLoggedIn);

const handleLogout = async () => {
    try {
        await AuthStore.logout();
        UserDataStore.clearData();
        router.push({ name: "home" });
    } catch (error) {
        console.error("Logout failed:", error);
    }
};

onMounted(async () => {
    if (isLoggedIn.value) {
        await UserDataStore.fetchBudgets();
    }
});
</script>

<template>
    <header>
        <div class="container flex justify-between items-center p-4">
            <div>
                <router-link
                    to="/"
                    class="font-bold hover:text-plutus-green hover:underline"
                >
                    <h1>Plutus</h1>
                </router-link>
            </div>
            <nav class="flex items-center space-x-6">
                <ul class="flex space-x-4">
                    <li
                        v-for="(link, index) in generalLinks"
                        :key="'g-' + index"
                    >
                        <router-link
                            :to="link.path"
                            class="hover:text-plutus-green hover:underline"
                            >{{ link.name }}</router-link
                        >
                    </li>

                    <template v-if="isLoggedIn">
                        <li
                            v-for="(link, index) in filteredAuthorizedLinks"
                            :key="'a-' + index"
                        >
                            <router-link
                                :to="link.path"
                                class="hover:text-plutus-green hover:underline"
                            >
                                {{ link.name }}
                            </router-link>
                        </li>
                        <UserDropdown />
                    </template>

                    <template v-else>
                        <li
                            v-for="(link, index) in guestLinks"
                            :key="'u-' + index"
                        >
                            <router-link
                                :to="link.path"
                                class="hover:text-plutus-green hover:underline"
                                >{{ link.name }}</router-link
                            >
                        </li>
                    </template>
                </ul>

                <!-- Auth Button -->
                <button
                    v-if="isLoggedIn"
                    @click="handleLogout"
                    class="btn ml-4"
                >
                    Logout
                </button>

                <router-link v-else to="/login" class="btn ml-4"
                    >Login</router-link
                >
            </nav>
        </div>
    </header>
</template>
