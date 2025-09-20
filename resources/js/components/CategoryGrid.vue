<template>
  <div
      class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-7"
  >
    <Link
        v-for="category in categories"
        :key="category.slug"
        :href="show(category.slug)"
        class="cursor-pointer bg-white rounded shadow overflow-hidden hover:shadow-lg transition block"
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
    </Link>
  </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { show } from "@/actions/App/Http/Controllers/CategoryController";
interface Category {
  id: number | string;
  slug: string;
  name: string;
  image?: string | null;
}
// :href="`/categories/${category.id}/${category.slug}`"
defineProps<{
  categories: Category[];
}>();

// const router = useRouter();

// Use VITE_API_URL from your environment
const API_BASE = import.meta.env.VITE_API_URL;

// Safe join to avoid double slashes
const imageSrc = (image?: string | null): string => {
  const base = (API_BASE || '').replace(/\/+$/, '');
  const path = String(image || '').replace(/^\/+/, '');
  return path ? `${base}/${path}` : `${base}/placeholder.jpg`;
};
</script>
