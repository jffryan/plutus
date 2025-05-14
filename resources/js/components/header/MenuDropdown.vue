<script setup>
import { computed } from "vue";
import { useRoute, useRouter } from "vue-router";

defineProps({
    label: {
        type: String,
        required: true,
    },
    items: {
        type: Array,
        required: true, // [{ name: "Budget 1", path: "/budgets/1" }]
    },
    createItem: {
        type: Object,
        default: null, // { name: "Create Budget", path: "/budgets/create" }
    },
});
</script>

<template>
    <li class="relative group">
        <span class="cursor-pointer hover:text-plutus-green hover:underline">
            {{ label }}
        </span>
        <ul
            class="absolute left-0 pt-2 mt-0 bg-transparent shadow rounded-md min-w-[180px] z-50 flex-col invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-opacity duration-150"
        >
            <div class="bg-white">
                <li
                    v-for="item in items"
                    :key="item.path"
                    class="text-sm text-green-800 whitespace-nowrap"
                >
                    <router-link
                        :to="item.path"
                        class="block px-4 py-2 hover:bg-gray-100"
                    >
                        {{ item.name }}
                    </router-link>
                </li>

                <li v-if="createItem" class="border-t">
                    <router-link
                        :to="createItem.path"
                        class="block px-4 py-2 text-sm font-semibold text-green-800 hover:bg-gray-100"
                    >
                        + {{ createItem.name }}
                    </router-link>
                </li>
            </div>
        </ul>
    </li>
</template>
