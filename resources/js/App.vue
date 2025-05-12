<template>
    <GlobalHeader class="bg-gray-800 text-white" />
    <RouterView />
</template>
<script>
import { onMounted } from "vue";
import { RouterView } from "vue-router";
import { useAuthStore } from "./stores";
import GlobalHeader from "./components/header/GlobalHeader.vue";

export default {
    name: "App",
    setup() {
        const AuthStore = useAuthStore();
        onMounted(() => AuthStore.fetchUser());
        return {
            AuthStore,
        };
    },
    components: {
        GlobalHeader,
        RouterView,
    },
};
</script>
