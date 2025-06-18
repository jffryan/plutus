import { createRouter, createWebHistory } from "vue-router";
import { useAuthStore } from "@/stores";

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: "/",
            name: "home",
            component: () => import("@/views/Home.vue"),
        },
        {
            path: "/page/:slug",
            name: "IndexPage",
            component: () => import("@/views/IndexPage.vue"),
        },
        {
            path: "/assets",
            name: "Assets",
            component: () => import("@/components/fin-assets/AssetList.vue"),
            meta: { requiresAuth: true },
        },
        {
            path: "/budgets",
            name: "budgets.index",
            component: () => import("@/components/budgets/BudgetList.vue"),
            meta: { requiresAuth: true },
        },
        {
            path: "/budgets/create",
            name: "budgets.create",
            component: () => import("@/components/budgets/CreateBudget.vue"),
            meta: { requiresAuth: true },
        },
        {
            path: "/dashboard",
            name: "UserDashboard",
            component: () => import("@/components/users/UserDashboard.vue"),
            meta: { requiresAuth: true },
        },
        {
            path: "/portfolios",
            name: "portfolios.index",
            component: () =>
                import("@/components/portfolios/PortfolioList.vue"),
            meta: { requiresAuth: true },
        },
        {
            path: "/portfolios/create",
            name: "portfolios.create",
            component: () =>
                import("@/components/portfolios/PortfolioCreate.vue"),
            meta: { requiresAuth: true },
        },
        {
            path: "/portfolios/:id",
            name: "PortfolioDetail",
            component: () =>
                import("@/components/portfolios/PortfolioDetail.vue"),
            meta: { requiresAuth: true },
        },
        {
            path: "/portfolios/:id/transactions",
            name: "PortfolioTransactionEditor",
            component: () =>
                import(
                    "@/components/portfolios/PortfolioTransactionEditor.vue"
                ),
            meta: { requiresAuth: true },
        },
        {
            path: "/snapshots/:id",
            name: "SnapshotDetail",
            component: () =>
                import("@/components/snapshots/SnapshotDetail.vue"),
            meta: { requiresAuth: true },
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
    ],
});

router.beforeEach(async (to, from, next) => {
    const AuthStore = useAuthStore();

    // Load the user if not already loaded (initial page load)
    if (!AuthStore.user && to.meta.requiresAuth) {
        try {
            await AuthStore.fetchUser();
        } catch {
            // If fetch fails, fallback to null
            AuthStore.user = null;
        }
    }

    // Redirect unauthenticated users from protected routes
    if (to.meta.requiresAuth && !AuthStore.isLoggedIn) {
        next({ name: "UserLogin", query: { redirect: to.fullPath } });
    } else {
        next();
    }
});

export default router;
