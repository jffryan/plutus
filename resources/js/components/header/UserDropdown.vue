<script setup>
// @TODO: Revise this to be more agnostic
import { useUserDataStore } from "@/stores/UserDataStore";
import { computed } from "vue";

const UserDataStore = useUserDataStore();

const budgets = computed(() => UserDataStore.budgets);
</script>

<template>
    <li class="relative group">
        <span class="cursor-pointer hover:text-plutus-green hover:underline">
            Budgets
        </span>
        <ul
            class="absolute left-0 pt-2 mt-0 bg-transparent shadow rounded-md min-w-[180px] z-50 flex-col invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-opacity duration-150"
        >
            <div class="bg-white">
                <li
                    v-for="budget in budgets"
                    :key="budget.id"
                    class="text-sm text-green-800 whitespace-nowrap"
                >
                    <router-link
                        :to="`/budgets/${budget.id}`"
                        class="block px-4 py-2 hover:bg-gray-100"
                    >
                        {{ budget.name || `Budget ${budget.id}` }}
                    </router-link>
                </li>
                <li class="border-t">
                    <router-link
                        to="/budgets/create"
                        class="block px-4 py-2 text-sm font-semibold text-green-800 hover:bg-gray-100"
                    >
                        + Create Budget
                    </router-link>
                </li>
            </div>
        </ul>
    </li>
</template>
