<template>
  <header>
    <!-- Desktop Menu -->
    <div class="sr-only xl:not-sr-only">
      <div
        class="flex flex-wrap justify-between items-center xl:px-32 px-4 py-2"
      >
        <router-link to="/">
          <img
            src="@/assets/logo.svg"
            class="object-contain self-center w-full"
            alt="Chefstore logo"
          />
        </router-link>
        <a
          href="https://www.chefstore.nl/"
          class="h-9 px-6 bg-[#e8761c] rounded-full flex justify-start items-center gap-2 min-w-60 font-bold text-white"
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
      <!-- Categories -->
      <div class="flex items-center px-32 w-full bg-[#4c84df] h-14">
        <nav class="flex gap-7 font-semibold text-white text-base">
          <a
            v-for="(item, index) in menuItems"
            :key="index"
            :href="item.href"
            >{{ item.name }}</a
          >
        </nav>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div class="xl:sr-only not-sr-only">
      <!-- Navbar -->
      <div class="flex flex-col w-full z-50">
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
        <!-- Chefstore return button -->
        <a
          href="https://www.chefstore.nl/"
          class="h-9 px-6 bg-[#e8761c] flex justify-center items-center gap-2 font-bold text-white"
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
      <div
        v-if="isOpen"
        class="w-full h-full bg-[#4C84DF] overflow-y-auto z-40"
      >
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
  </header>
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
