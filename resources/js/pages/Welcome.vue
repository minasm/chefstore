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
          @results="searchResults = $event"
          @select="handleSelectedResult"
      />
    </div>
    <!-- KATEGORİLER YÜKLENİYORSA SPINNER GÖSTER -->
    <LoadingSpinner v-if="categoryStore.loading" />

    <!-- KATEGORİLER YÜKLENDİYSE GÖSTER -->
    <div v-else>
      <!-- Desktop için kategori grid -->
      <div class="hidden xl:block">
        <CategoryGrid :categories="categories" />

        <!-- Use the paginator with the pagination prop and listen to update:page -->
        <Paginator :pagination="pagination" @update:page="changePage" />
      </div>

      <!-- Mobil için kategori menüsü -->
      <div class="block xl:hidden">
        <CategoryMobile :categories="paginatedCategories" />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from "vue";
import { useFaqStore } from "@/stores/categories.js";


import ContactCard from "@/components/ContactCard.vue";
import CategoryGrid from "@/components/CategoryGrid.vue";
import CategoryMobile from "@/components/CategoryMobile.vue";
import LoadingSpinner from "@/components/LoadingSpinner.vue";
import SearchBar from "@/components/SearchBar.vue";

import serviceImg from "../../assets/Settings.svg";
import salesImg from "../..//assets/sales.svg";
import phoneImg from "../..//assets/phone.svg";
import Paginator from "@/components/Paginator.vue";

const props = defineProps({
  categories: {
    type: Array,
    required: true,
    validator: (value) =>
      Array.isArray(value) &&
      value.every(
        (category) =>
          category &&
          typeof category.id === "number" &&
          typeof category.name === "string" &&
          typeof category.slug === "string" &&
          typeof category.faqs_count === "number"
      ),
  },
});


// Store
const categoryStore = useFaqStore();
// const categories = computed(() => categoryStore.categories);

//Search
const searchResults = ref([]);
const handleSelectedResult = async (faq) => {
  if (categoryStore.categories.length === 0) {
    // await categoryStore.fetchCategories(); // ensure categories are available
  }

  const matchedCategory = categoryStore.categories.find(
      (cat) => cat.id === faq.category_id
  );

  if (matchedCategory) {
    const slug = matchedCategory.slug;
    const id = matchedCategory.id;

    // router.push({
    //   name: "CategoryDetail",
    //   params: { id, slug },
    //   query: { highlight: faq.id, page: faq.page ?? 1 }, // include page so correct paginated data loads
    // });
    // alert(2)
    // await router.replace({
    //   name: "CategoryDetail",
    //   params: { id: id, slug: slug },
    //   query: { page: 1 },
    // });
  } else {
    console.warn("Kategori bulunamadı:", faq.category_id);
  }
};

// Sayfa bilgisi ve limiti
const currentPage = ref(1);
const pageSize = 8;

const paginatedCategories = computed(() => {
  const cats = props.categories.value;
  if (!Array.isArray(cats)) return [];
  const start = (currentPage.value - 1) * pageSize;
  return cats.slice(start, start + pageSize);
});

const totalPages = computed(() => {
  debugger
  const cats = props.categories.value;
  return Array.isArray(cats) ? Math.ceil(cats.length / pageSize) : 1;
});

// Build the pagination object expected by Paginator
const pagination = computed(() => ({
  total: Array.isArray(props.categories.value) ? props.categories.value.length : 0,
  current_page: currentPage.value,
  last_page: totalPages.value,
}));

// Sayfa yüklendiğinde kategorileri al
onMounted(() => {
  // categoryStore.fetchCategories();
});

// Sayfa değiştirme işlevi
const changePage = (page) => {
  if (page >= 1 && page <= totalPages.value) {
    currentPage.value = page;
    window.scrollTo({ top: 0, behavior: "smooth" });
  }
};
</script>
