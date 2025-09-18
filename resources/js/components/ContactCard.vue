<template>
  <component
    :is="link ? 'a' : 'div'"
    :href="link || undefined"
    target="_blank"
    rel="noopener noreferrer"
    class="w-full xl:w-[260px] h-full xl:h-18 px-4 bg-gradient-to-l from-[#4c84df] to-[#204050] outline outline-[#4c84df] flex items-center gap-3 cursor-pointer"
  >
    <img :src="imgSrc" alt="icon" class="w-6 h-6 object-contain" />
    <div class="text-white text-lg">
      <span class="font-bold">{{ title }}<br /></span>
      <span>{{ value }}</span>
    </div>
  </component>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
  title: String,
  value: String,
  imgSrc: String,
});

const link = computed(() => {
  if (!props.value) return null;

  if (props.value.includes("@")) {
    return `mailto:${props.value}`;
  }

  if (props.value.trim().startsWith("+")) {
    return `tel:${props.value.replace(/\s+/g, "")}`;
  }

  return null;
});
</script>
