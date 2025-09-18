<template>
  <div
      class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-7"
  >
    <div
        v-for="category in categories"
        :key="category.slug"
        @click="goToCategory(category)"
        class="cursor-pointer bg-white rounded shadow overflow-hidden hover:shadow-lg transition"
    >
      <div class="relative">
        <img
            :src="imageSrc(category.image)"
            alt="category image"
            class="w-full h-48 object-cover"
        />
      </div>
      <div class="bg-[#1d4b6e] text-white flex justify-between h-16">
        <p class="text-sm font-medium px-2 flex items-center">
          {{ category.name }}
        </p>
        <div class="w-16 h-full bg-[#e8761c] flex justify-center items-center">
          <span class="text-white font-bold text-xl">→</span>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
// import { useRouter } from "vue-router";

defineProps({
  categories: Array,
});

// const router = useRouter();

// Use VITE_API_URL from your environment
const API_BASE = import.meta.env.VITE_API_URL;

// Safe join to avoid double slashes
const imageSrc = (image) => {
  const base = (API_BASE || "").replace(/\/+$/, "");
  const path = String(image || "").replace(/^\/+/, "");
  return `${base}/${path}`;
};

const goToCategory = (category) => {
  router.push({
    name: "CategoryDetail",
    params: {
      id: category.id,
      slug: category.slug,
    },
  });
};
</script>