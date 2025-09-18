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

      <img src="../../assets/ok.svg" class="w-6 h-6" />
    </div>
  </div>
</template>
<script setup>
// import { useRouter } from "vue-router";

// const router = useRouter();
const props = defineProps({
  categories: Array,
  selectedCategory: String,
});

const emit = defineEmits(["update:selectedCategory"]);

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
