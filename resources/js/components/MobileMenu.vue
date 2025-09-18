<template>
  <div class="xl:sr-only not-sr-only">
    <!-- Navbar -->
    <div class="fixed top-0 left-0 flex flex-col w-full h-full z-50">
      <div class="w-full h-20 flex justify-between items-center bg-white">
        <div class="lg:min-w-36 min-w-20 lg:max-w-60 max-w-40 ml-6">
          <router-link to="/">
            <img src="@/assets/logo.svg" alt="Chef Store Logo" />
          </router-link>
        </div>
        <!-- Mobile menu button -->
        <button @click="toggleMenu" class="p-6 z-50">
          <img
            :src="isOpen ? closeIcon : menuIcon"
            :alt="isOpen ? 'Close Icon' : 'Menu Icon'"
          />
        </button>
      </div>
      <!-- Chefstore dönme butonu -->
      <a
        href="https://www.chefstore.nl/"
        class="h-9 px-6 bg-[#e8761c] flex justify-center items-center gap-2 font-bold text-white"
        target="_blank"
      >
        <img
          src="@/assets/Reply.svg"
          class="object-contain w-6 h-6"
          alt="reply"
        />
        <p>Terug naar Chefstore</p>
      </a>
    </div>
    <!-- Category Menu -->
    <div v-if="isOpen" class="w-full h-full bg-[#4C84DF] overflow-y-auto z-40">
      <nav>
        <ul>
          <li v-for="(item, index) in menuItems" :key="index">
            <a
              :href="item.href"
              class="flex items-center gap-3 p-4 pl-6 text-white text-lg font-bold"
              @click="toggleMenu"
            >
              <img src="@/assets/forward.svg" alt="forward" />
              {{ item.name }}
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import menuIcon from "@/assets/menu.svg";
import closeIcon from "@/assets/close.svg";

const isOpen = ref(false);

const menuItems = ref([
  { name: "Koelingen", href: "https://www.chefstore.nl/koelingen.html" },
  { name: "Apparatuur", href: "https://www.chefstore.nl/apparatuur-1.html" },
  { name: "Kooklijnen", href: "https://www.chefstore.nl/kooklijnen.html" },
  { name: "RVS", href: "https://www.chefstore.nl/rvs.html" },
  {
    name: "Bar- en Tafelgerei",
    href: "https://www.chefstore.nl/bar-en-tafelgerei.html",
  },
  { name: "Keukengerei", href: "https://www.chefstore.nl/keukengerei.html" },
  { name: "Werkkleding", href: "https://www.chefstore.nl/horeca-kleding.html" },
  { name: "Disposables", href: "https://www.chefstore.nl/disposables.html" },
  { name: "Meubilair", href: "https://www.chefstore.nl/meubilair.html" },
  { name: "Hygiëne", href: "https://www.chefstore.nl/hygiene.html" },
  { name: "Onderdelen", href: "https://www.chefstore.nl/onderdelen.html" },
  { name: "Branches", href: "https://www.chefstore.nl/voor.html" },
  { name: "SALE", href: "https://www.chefstore.nl/promoties.html" },
]);

function toggleMenu() {
  isOpen.value = !isOpen.value;
}

watch(isOpen, (newVal) => {
  document.body.style.overflow = newVal ? "hidden" : "";
});
</script>
