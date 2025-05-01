<script setup>
import { ref, watch, onMounted } from "vue";
import { useRoute } from "vue-router";

const route = useRoute();
const pageData = ref(null);
const error = ref(null);

const fetchPageData = async (slug) => {
    const response = await fetch(`/api/page/${slug}`);
    if (!response.ok) throw new Error("Page not found");
    return await response.json();
};

const loadPage = async (slug) => {
    try {
        error.value = null;
        pageData.value = await fetchPageData(slug || "index");
    } catch (err) {
        error.value = err.message;
        pageData.value = null;
    }
};

onMounted(() => loadPage(route.params.slug));

watch(
    () => route.params.slug,
    (newSlug) => {
        loadPage(newSlug);
    }
);
</script>
<template>
    <div class="pt-10 container">
        <div v-if="error" class="error">{{ error }}</div>
        <div v-else-if="pageData" class="page-content">
            <h1 class="text-3xl mb-4">{{ pageData.title }}</h1>
            <div>
                <p v-text="pageData.description" class="text-lg mb-4"></p>
                <ul class="flex"> 
                    <li v-for="(item, index) in pageData.links" :key="index" class="mr-4">
                        <a :href="item.url" class="hover:underline">{{ item.label }}</a>
                    </li>

                </ul>
            </div>
        </div>
        <div v-else class="loading">Loading...</div>
    </div>
</template>
