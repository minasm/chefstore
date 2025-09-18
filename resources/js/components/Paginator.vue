<script setup lang="ts">
import { computed } from "vue";

type Pagination = {
  total: number;
  current_page: number;
  last_page: number;
};

const props = defineProps<{
  pagination: Pagination;
}>();

const emit = defineEmits<{
  (e: "update:page", page: number): void;
  (e: "page-change", page: number): void;
}>();

const currentPage = computed(() => props.pagination?.current_page ?? 1);
const totalPages = computed(() => props.pagination?.last_page ?? 1);

function changePage(page: number) {
  const total = totalPages.value;
  if (page < 1 || page > total) return;
  if (page === currentPage.value) return;
  emit("update:page", page);
  emit("page-change", page);
}
</script>

<template>
  <div class="flex justify-center items-center mt-6 gap-2 flex-wrap">
    <button
        class="px-3 py-1 text-[#2f86de] disabled:opacity-50 cursor-pointer"
        :disabled="currentPage === 1"
        @click="changePage(currentPage - 1)"
    >
      &lt;
    </button>

    <button
        v-for="page in totalPages"
        :key="page"
        @click="changePage(page)"
        class="px-3 py-1 cursor-pointer"
        :class="{
        'bg-[#2f86de] text-white rounded': currentPage === page,
        'text-[#2f86de]': currentPage !== page
      }"
    >
      {{ page }}
    </button>

    <button
        class="px-3 py-1 text-[#2f86de] disabled:opacity-50 cursor-pointer"
        :disabled="currentPage === totalPages"
        @click="changePage(currentPage + 1)"
    >
      &gt;
    </button>
  </div>
</template>

<style scoped>
</style>