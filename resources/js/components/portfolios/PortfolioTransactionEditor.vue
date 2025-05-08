<script setup>
import { ref, onMounted, computed } from "vue";
import { useRoute, useRouter } from "vue-router";
import axios from "axios";
import cloneDeep from "lodash/cloneDeep";
import BuyAssetForm from "@/components/fin-assets/BuyAssetForm.vue";
import SellAssetForm from "@/components/fin-assets/SellAssetForm.vue";
import ManualOverrideAssetsPanel from "@/components/fin-assets/ManualOverrideAssetsPanel.vue";
import PortfolioHoldingsTable from "@/components/portfolios/PortfolioHoldingsTable.vue";

const route = useRoute();
const router = useRouter();
const portfolio = ref(null);
const localHoldings = ref([]);
const manualEdits = ref({});

const usdHolding = computed(() =>
    localHoldings.value.find((h) => h.asset.ticker === "USD")
);

function handleBuy({ assetId, quantity, price }) {
    const asset = localHoldings.value.find((h) => h.asset.id === assetId);
    const usd = usdHolding.value;
    const totalCost = quantity * price;

    if (!asset || !usd) return;

    usd.quantity = parseFloat(usd.quantity) - totalCost;
    usd.cost_basis = parseFloat(usd.cost_basis) - totalCost;
    usd.value = parseFloat(usd.value) - totalCost;

    asset.quantity = parseFloat(asset.quantity) + quantity;
    asset.cost_basis = parseFloat(asset.cost_basis) + totalCost;
    asset.value = parseFloat(asset.value) + totalCost;
}

function handleSell({ assetId, quantity, price }) {
    const asset = localHoldings.value.find((h) => h.asset.id === assetId);
    const usd = usdHolding.value;
    if (!asset || !usd) return;

    const assetQty = parseFloat(asset.quantity);
    const proceeds = quantity * price;
    const proportion = quantity / assetQty;

    usd.quantity = parseFloat(usd.quantity) + proceeds;
    usd.cost_basis = parseFloat(usd.cost_basis) + proceeds;
    usd.value = parseFloat(usd.value) + proceeds;

    asset.quantity = assetQty - quantity;
    asset.cost_basis = parseFloat(asset.cost_basis) * (1 - proportion);
    asset.value = parseFloat(asset.value) - proceeds;

    if (asset.quantity <= 0) {
        asset.quantity = 0;
        asset.cost_basis = 0;
        asset.value = 0;
    }
}

function handleManualEdit({ assetId, field, value }) {
  const asset = localHoldings.value.find(h => h.asset.id === assetId)
  if (!asset) return

  asset[field] = value

  if (!manualEdits.value[assetId]) {
    manualEdits.value[assetId] = {}
  }
  manualEdits.value[assetId][field] = true
}


async function saveSnapshot() {
    try {
        const payload = {
            snapshot_date: new Date().toISOString().slice(0, 10),
            notes: "Snapshot from transaction batch save",
            holdings: localHoldings.value.map((h) => ({
                asset_id: h.asset.id,
                quantity: parseFloat(h.quantity),
                value: parseFloat(h.value),
                cost_basis: parseFloat(h.cost_basis),
            })),
        };

        const res = await axios.post(
            `/api/portfolios/${route.params.id}/snapshots`,
            payload
        );
        alert("Snapshot created successfully.");
        router.push({
            name: "SnapshotDetail",
            params: { id: res.data.snapshot_id },
        });
    } catch (err) {
        console.error("Snapshot creation failed:", err);
        alert("Failed to save snapshot.");
    }
}

async function fetchPortfolio() {
    try {
        const response = await axios.get(`/api/portfolios/${route.params.id}`);
        portfolio.value = response.data.data;
        localHoldings.value = cloneDeep(portfolio.value.holdings);
    } catch (err) {
        console.error("Failed to load portfolio:", err);
    }
}

onMounted(fetchPortfolio);
</script>

<template>
    <div class="p-6 max-w-6xl mx-auto">
        <div v-if="portfolio">
            <h1 class="text-2xl font-bold mb-4">
                Editing Portfolio - {{ portfolio.name }}
            </h1>
            <p class="text-sm text-gray-600 mb-6">
                Preview changes before committing. This will not affect your
                data until you save.
            </p>

            <PortfolioHoldingsTable :holdings="localHoldings" />

            <div class="mt-12">
                <button
                    class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700"
                    @click="saveSnapshot"
                >
                    Create Snapshot
                </button>
            </div>

            <BuyAssetForm
                :localHoldings="localHoldings"
                :usdHolding="usdHolding"
                @buyApplied="handleBuy"
            />
            <SellAssetForm
                :localHoldings="localHoldings"
                :usdHolding="usdHolding"
                @sellApplied="handleSell"
            />
            <ManualOverrideAssetsPanel
                :localHoldings="localHoldings"
                :manualEdits="manualEdits"
                @manualEdited="handleManualEdit"
            />
        </div>
        <div v-else class="text-gray-500">Loading portfolio...</div>
    </div>
</template>
