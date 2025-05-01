<script setup>
import { ref } from "vue";

const headerLinks = [
  { name: "Home", path: "/" },
  { name: "Spreadsheets", path: "/page/spreadsheets" },
  { name: "Transactions", path: "/page/transactions" },
  { name: "Reports", path: "/page/reports" },
];
</script>

<template>
  <header>
    <div class="container flex justify-between items-center p-4">
      <div>
        <h1>Plutus</h1>
      </div>
      <nav>
        <ul class="flex space-x-4">
          <li v-for="(link, index) in headerLinks" :key="index">
            <a :href="link.path" class="hover:text-plutus-green hover:underline">{{ link.name }}</a>
          </li>
        </ul>
      </nav>
    </div>
  </header>
</template>
