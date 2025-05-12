<script setup>
import { computed } from "vue";
import { useAuthStore } from "@/stores";

const AuthStore = useAuthStore();

const generalLinks = [{ name: "Home", path: "/" }];

const authorizedLinks = [
    { name: "Portfolios", path: "/portfolios" },
    { name: "Expense Trackers", path: "/expense-trackers" },
];

const guestLinks = [{ name: "Register", path: "/register" }];

const isLoggedIn = computed(() => AuthStore.isLoggedIn);
</script>

<template>
    <header>
        <div class="container flex justify-between items-center p-4">
            <div>
                <h1>Plutus</h1>
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
                            v-for="(link, index) in authorizedLinks"
                            :key="'a-' + index"
                        >
                            <router-link
                                :to="link.path"
                                class="hover:text-plutus-green hover:underline"
                                >{{ link.name }}</router-link
                            >
                        </li>
                    </template>

                    <template v-else>
                        <li
                            v-for="(link, index) in guestLinks"
                            :key="'u-' + index"
                        >
                            <a
                                :href="link.path"
                                class="hover:text-plutus-green hover:underline"
                                >{{ link.name }}</a
                            >
                        </li>
                    </template>
                </ul>

                <!-- Auth Button -->
                <button
                    v-if="isLoggedIn"
                    @click="AuthStore.logout"
                    class="btn ml-4"
                >
                    Logout
                </button>

                <a v-else href="/login" class="btn ml-4">Login</a>
            </nav>
        </div>
    </header>
</template>
