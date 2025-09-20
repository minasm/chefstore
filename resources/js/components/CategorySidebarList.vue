<script setup lang="ts">
import { Link } from '@inertiajs/vue3'
import { show } from "@/actions/App/Http/Controllers/CategoryController";
import chefIcon from "@/../assets/chef.svg";
import type { CategoriesSimpleResource, SelectedCategory } from '@/interfaces/categories.interface';

const props = defineProps<{
    categories: CategoriesSimpleResource;
    selectedCategory: SelectedCategory;
}>();
</script>

<template>
    <div class="w-1/4 hidden xl:flex flex-col" id="sidebar">
        <div class="h-12 border-b border-[#2e3638]/20 flex items-center pl-4">
            <span class="text-[#204050] font-extrabold">Klantenservice</span>
        </div>
        <Link
            v-for="category in props.categories"
            :key="category.slug"
            :href="show(category.id)"
            :class="[
          'category-item',
          selectedCategory.slug === category.slug
            ? 'active bg-gradient-to-r from-[#e8761c] to-[#ffb072] text-white'
            : 'text-[#204050] cursor-pointer',
        ]"
            class="h-12 pr-3 pl-4 flex items-center"
        >
            <img
                v-if="selectedCategory.slug === category.slug"
                :src="chefIcon"
                alt="Chef Icon"
                class="w-5 h-5 mr-1"
            />
            <span>{{ category.name }}</span>
        </Link>
    </div>
</template>

<style scoped></style>
