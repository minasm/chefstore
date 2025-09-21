<template>
  <div class="xl:px-32 xl:py-5">
    <!-- SERVİS KISMI -->
    <h1 class="xl:flex hidden text-[#4c84df] text-3xl font-extrabold mb-32">
      Klantenservice
    </h1>

    <div
        class="w-full h-full xl:h-46 xl:px-16 px-4 py-8 xl:py-8 bg-[#2e567d] flex xl:flex-row flex-col mb-10"
    >
      <!-- Image Section -->
      <div class="xl:flex hidden w-60 h-60 justify-start items-center">
        <a href="https://www.chefstore.nl/" target="_blank">
          <img class="mb-54" src="../../assets/man.png" alt="Chefstore"/>
        </a>
      </div>
      <div class="flex xl:hidden w-full justify-start items-center">
        <a href="https://www.chefstore.nl/" target="_blank">
          <img class="w-[180px]" src="../../assets/man.png" alt="Chefstore" />
        </a>
        <p
            class="flex xl:hidden text-white text-sm xl:text-xl font-extrabold mb-4"
        >
          Voor alle contactmogelijkheden,<br />klik bovenin op het telefoon
          icoontje.
        </p>
      </div>

      <!-- Text & Cards Section -->
      <div class="flex flex-col justify-center xl:ml-8">
        <p
            class="xl:flex hidden text-white text-base xl:text-xl font-extrabold mb-4"
        >
          Voor alle contactmogelijkheden,<br />klik bovenin op het telefoon
          icoontje.
        </p>

        <div class="flex flex-col md:flex-row gap-3 md:gap-6">
          <ContactCard
              title="Service"
              value="service@chefstore.nl"
              :imgSrc="serviceImg"
          />
          <ContactCard
              title="Sales"
              value="sales@chefstore.nl"
              :imgSrc="salesImg"
          />
          <ContactCard
              title="Telefoon"
              value="+31 85 0441003"
              :imgSrc="phoneImg"
          />
        </div>
      </div>
    </div>

    <div class="flex xl:hidden text-[#4c84df] text-lg font-extrabold px-4 mb-4">
      Klantenservice
    </div>
    <div class="relative w-full flex gap-8 mb-10 xl:px-0 px-4">
      <div class="xl:flex hidden text-[#4c84df] text-3xl font-extrabold">
        Categorieën
      </div>

      <!-- ARAMA KATEGORİ KISMI -->
      <SearchBar

      />
    </div>
    <!-- KATEGORİLER YÜKLENİYORSA SPINNER GÖSTER -->
    <LoadingSpinner v-if="categoryStore.loading" />

    <!-- KATEGORİLER YÜKLENDİYSE GÖSTER -->
    <div v-else>
      <!-- Desktop için kategori grid -->
      <div class="hidden xl:block">
         <CategoryGrid :categories="categories" />

        <Paginator :links="paginationLinks" @navigate="changePage" />
      </div>

      <!-- Mobil için kategori menüsü -->
      <div class="block xl:hidden">
        <CategoryMobile :categories="paginatedCategories" />
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { computed } from "vue";
import { router } from "@inertiajs/vue3";
import { useFaqStore } from "@/stores/categories.js";


import ContactCard from "@/components/ContactCard.vue";
import CategoryGrid from "@/components/CategoryGrid.vue";
import CategoryMobile from "@/components/CategoryMobile.vue";
import LoadingSpinner from "@/components/LoadingSpinner.vue";
import SearchBar from "@/components/SearchBar.vue";

import serviceImg from "../../assets/Settings.svg";
import salesImg from "@/../assets/sales.svg";
import phoneImg from "../../assets/phone.svg";
import Paginator from "@/components/Paginator.vue";
import { Category, Categories } from "@/interfaces/categories.interface";
import { PaginatedCategories } from "@/interfaces/paginatedCategories.interface";
import { PaginationLink } from "@/interfaces/paginationLink.interface";

type CategoriesProp = Categories | PaginatedCategories;

const props = defineProps<{
  categories?: CategoriesProp;
}>();

const isPaginatedCategories = (
  value: CategoriesProp | undefined
): value is PaginatedCategories =>
  !!value && !Array.isArray(value) && Array.isArray(value.data);


// Store
const categoryStore = useFaqStore();
const categories = computed<Category[]>(() => {
  const incoming = props.categories;
  if (Array.isArray(incoming)) {
    return incoming;
  }
  if (isPaginatedCategories(incoming)) {
    return incoming.data;
  }
  return [];
});

const paginationLinks = computed<PaginationLink[]>(() => {
  const incoming = props.categories;
  if (isPaginatedCategories(incoming)) {
    return incoming.links || [];
  }
  return [];
});

const paginatedCategories = computed<Category[]>(() => categories.value);


const changePage = (url: string | null) => {
  if (!url) return;
  router.visit(url, {
    preserveState: true,
    onSuccess: () => {
      window.scrollTo({ top: 0, behavior: "smooth" });
    },
  });
};
</script>
