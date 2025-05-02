import { createRouter, createWebHistory } from "vue-router";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "home",
            component: () => import("@/views/Home.vue"),
        },
        {
            path: "/assets",
            name: "Assets",
            component: () => import("@/components/fin-assets/AssetList.vue"),
        },
        {
            path: "/portfolios",
            name: "Portfolios",
            component: () => import("@/components/portfolios/PortfolioList.vue"),
        },
        {
            path: "/portfolios/:id",
            name: "PortfolioDetail",
            component: () => import("@/components/portfolios/PortfolioDetail.vue"),
        },
        {
            path: "/page/:slug",
            name: "IndexPage",
            component: () => import("@/views/IndexPage.vue"),
        }
    ],
});

export default router;
