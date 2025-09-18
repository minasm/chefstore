<template>
  <div class="w-full flex justify-start items-start gap-16 mb-10">
    <!-- Sidebar -->
    <div class="w-1/4 hidden xl:flex flex-col" id="sidebar">
      <div class="h-12 border-b border-[#2e3638]/20 flex items-center pl-4">
        <span class="text-[#204050] font-extrabold">Klantenservice</span>
      </div>
      <div
        v-for="cat in props.all"
        :key="cat.slug"
        :class="[
          'category-item',
          selectedCategory === cat.slug
            ? 'active bg-gradient-to-r from-[#e8761c] to-[#ffb072] text-white'
            : 'text-[#204050] cursor-pointer',
        ]"
        class="h-12 pr-3 pl-4 flex items-center"
        @click="$emit('change', cat)"
      >
        <img
          v-if="selectedCategory === cat.slug"
          :src="chefIcon"
          alt="Chef Icon"
          class="w-5 h-5 mr-1"
        />
        <span>{{ cat.name }}</span>
      </div>
    </div>

    <!-- Content -->
    <div class="w-full xl:w-3/4 flex flex-col gap-6 xl:gap-8">
      <SearchBar @results="searchResults = $event" />
      <h2 class="text-[#4c84df] text-lg xl:text-3xl font-extrabold">
        {{ categories[selectedCategory]?.title || "Geen titel" }}
      </h2>

      <div
        v-for="(q, index) in categories[selectedCategory]?.questions || []"
        :key="q.id"
        :id="`faq-${q.id}`"
        class="border-b border-[#2e3638]/20 py-2 xl:py-4"
        :class="{
          highlight: highlightId === q.id,
        }"
      >
        <div
          class="flex justify-between items-center cursor-pointer"
          @click="toggleAccordion(index)"
        >
          <div
            :class="[
              'font-bold',
              openIndexes.includes(index) ? 'text-[#e8761c]' : 'text-[#204050]',
            ]"
          >
            {{ q.q }}
          </div>
          <img
            :src="openIndexes.includes(index) ? upIcon : downIcon"
            alt="Toggle Answer"
            class="w-5 h-5"
          />
        </div>
        <div v-if="openIndexes.includes(index)" class="mt-2 text-[#204050]">
          <div v-html="q.a"></div>
        </div>
      </div>
      <Paginator
        v-if="props.pagination"
        :pagination="props.pagination"
        @page-change="$emit('page-change', $event)"
      />
    </div>
  </div>
</template>

<script setup>
import { ref, watch } from "vue";
import SearchBar from "@/components/SearchBar.vue";
import Paginator from "@/components/Paginator.vue";
import chefIcon from "@/assets/chef.svg";
import upIcon from "@/assets/up.svg";
import downIcon from "@/assets/down.svg";

const props = defineProps({
  categories: Object,
  selectedCategory: String,
  isMobile: Boolean,
  all: Array,
  highlightId: Number,
  openIndexes: Array,
  pagination: Object,
});

const searchResults = ref([]);
// Local state mirrors prop and stays in sync when parent updates it
const openIndexes = ref(Array.isArray(props.openIndexes) ? [...props.openIndexes] : []);

watch(
  () => props.openIndexes,
  (newVal) => {
    openIndexes.value = Array.isArray(newVal) ? [...newVal] : [];
  },
  { deep: true, immediate: true }
);

function toggleAccordion(index) {
  const i = openIndexes.value.indexOf(index);
  if (i > -1) {
    openIndexes.value.splice(i, 1);
  } else {
    openIndexes.value.push(index);
  }
}
</script>

<style scoped>
.category-item {
  width: 100%;
  height: 3rem;
  padding-right: 0.75rem;
  padding-left: 1rem;
  display: flex;
  align-items: center;
}
.category-item.active {
  background: linear-gradient(to right, #ffb072, #e8761c);
  color: white;
}
.highlight {
  background: linear-gradient(to right, #ffb072, #e8761c);
  color: white;
}
</style>
