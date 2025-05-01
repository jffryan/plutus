<template>
    <GlobalHeader class="bg-gray-800 text-white" />
    <RouterView />
</template>
<script>
import { RouterView } from "vue-router";
import GlobalHeader from "./components/header/GlobalHeader.vue";

export default {
    name: "App",
    setup() {},
    components: {
        GlobalHeader,
        RouterView,
    },
};
</script>
