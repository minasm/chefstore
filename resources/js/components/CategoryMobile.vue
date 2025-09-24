<template>
  <div class="w-full px-5 py-8 bg-[#2f86de]/5 flex flex-col">
    <p class="text-[#204050] font-extrabold pb-3 border-b border-[#2e3638]/20">
      Categorieën
    </p>

    <div
       v-for="category in categories"
      :key="category.slug"
      @click="goToCategory(category)"
      class="h-12 pr-3 border-b border-[#2e3638]/20 flex justify-between items-center cursor-pointer"
    >
      <span
        :class="[
          'text-[#204050]',
          selectedCategory === category.slug
            ? 'font-extrabold text-[#e8761c]'
            : '',
        ]"
      >
        {{ category.name }}
      </span>

      <img :src="ok" class="w-6 h-6"  alt="OK"/>
    </div>
  </div>
</template>
<script setup lang="ts">
import ok from '@/../assets/ok.svg';
import { router } from '@inertiajs/vue3';

interface Category {
    id: number | string;
    slug: string;
    name: string;
    image?: string | null;
    image_url?: string | null;
}

defineProps<{
    categories: Category[],
    selectedCategory: string,
}>()


defineEmits(["update:selectedCategory"]);

const goToCategory = (category: Category) => {
    if (!category) return;
    const url = `/categories/${category.slug}`;
    router.visit(url, {
        preserveState: true,
        // preserveScroll: true,
    });

};
</script>
