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
            component: () =>
                import("@/components/portfolios/PortfolioList.vue"),
        },
        {
            path: "/portfolios/:id",
            name: "PortfolioDetail",
            component: () =>
                import("@/components/portfolios/PortfolioDetail.vue"),
        },
        {
            path: "/portfolios/:id/transactions",
            name: "PortfolioTransactionEditor",
            component: () =>
                import(
                    "@/components/portfolios/PortfolioTransactionEditor.vue"
                ),
        },
        {
            path: "/login",
            name: "UserLogin",
            component: () => import("@/components/users/UserLogin.vue"),
        },
        {
            path: "/register",
            name: "UserRegister",
            component: () => import("@/components/users/UserRegister.vue"),
        },
        {
            path: "/snapshots/:id",
            name: "SnapshotDetail",
            component: () =>
                import("@/components/snapshots/SnapshotDetail.vue"),
        },
        {
            path: "/page/:slug",
            name: "IndexPage",
            component: () => import("@/views/IndexPage.vue"),
        },
    ],
});

export default router;
