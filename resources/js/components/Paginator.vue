<script setup lang="ts">
import { Links } from "@/interfaces/pagination.interface";
import { computed } from "vue";

const props = defineProps<{
  links: Links;
}>();

const links = computed(() => props.links ?? []);

const emit = defineEmits<{
  (e: "navigate", url: string | null): void;
}>();

function changePage(url: string | null, active: boolean) {
  if (!url || active) return;
  emit("navigate", url);
}
</script>

<template>
  <div class="flex justify-center items-center mt-6 gap-2 flex-wrap">
    <button
        v-for="(link, index) in links"
        :key="`${link.label}-${index}`"
        type="button"
        class="px-3 py-1 cursor-pointer"
        :class="{
          'bg-[#2f86de] text-white rounded': link.active,
          'text-[#2f86de]': !link.active,
          'opacity-50 cursor-not-allowed': !link.url && !link.active,
        }"
        :disabled="!link.url || link.active"
        @click="changePage(link.url, link.active)"
    >
      <span v-html="link.label" />
    </button>
  </div>
</template>

<style scoped>
</style>
