<script setup lang="ts">
import { ref, watch } from "vue";
import SearchBar from "@/components/SearchBar.vue";
import Paginator from "@/components/Paginator.vue";
import upIcon from "@/../assets/up.svg";
import downIcon from "@/../assets/down.svg";
import type { Faqs } from '@/interfaces/faq.interface';
import type { CategoriesSimpleResource } from '@/interfaces/categories.interface';
import CategorySidebarList from '@/components/CategorySidebarList.vue';


const props = defineProps({
    faqs: Object as () => Faqs,
    selectedCategory: Object,
    isMobile: Boolean,
    categories: Array as () => CategoriesSimpleResource,
    highlightId: Number,
    openIndexes: Array,
    pagination: Object,
});
const emit = defineEmits(['change', 'navigate']);

const searchResults = ref([]);
// Local state mirrors prop and stays in sync when the parent updates it
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
<template>
  <div class="w-full flex justify-start items-start gap-16 mb-10">

      <CategorySidebarList
          :categories="categories"
          :selected-category="selectedCategory"
            @change="$emit(  'change', $event)" />

    <!-- Content -->
    <div class="w-full xl:w-3/4 flex flex-col gap-6 xl:gap-8">
      <SearchBar @results="searchResults = $event" />
      <h2 class="text-[#4c84df] text-lg xl:text-3xl font-extrabold">
        {{ selectedCategory.name || "Geen titel" }}

      </h2>

      <div
        v-for="(faq, index) in faqs.data || []"
        :key="faq.id"
        :id="`faq-${faq.id}`"
        class="border-b border-[#2e3638]/20 py-2 xl:py-4"
        :class="{
          highlight: highlightId === faq.id,
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
            {{ faq.question }}
          </div>
          <img
            :src="openIndexes.includes(index) ? upIcon : downIcon"
            alt="Toggle Answer"
            class="w-5 h-5"
          />
        </div>
        <div v-if="openIndexes.includes(index)" class="mt-2 text-[#204050]">
          <div v-html="faq.answer"></div>
        </div>
      </div>
        <Paginator
            v-if="faqs?.links"
            :links="faqs.links"
            @navigate="$emit('navigate', $event)"
        />

    </div>
  </div>
</template>

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
