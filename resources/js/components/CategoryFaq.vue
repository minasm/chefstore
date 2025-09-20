<script setup lang="ts">
import { ref, watch } from 'vue';
import SearchBar from '@/components/SearchBar.vue';
import Paginator from '@/components/Paginator.vue';
import upIcon from '@/../assets/up.svg';
import downIcon from '@/../assets/down.svg';
import type { FAQResource } from '@/interfaces/faq.interface';
import type { CategoriesSimpleResource, Category } from '@/interfaces/categories.interface';
import CategorySidebarList from '@/components/CategorySidebarList.vue';

const props = defineProps<{
    faqs: { type: FAQResource; required: true };
    selectedCategory: { type: Category, required: true };
    categories: CategoriesSimpleResource;
    highlightId: { type: number; default: null };
}>();

defineEmits(['change', 'navigate']);

const searchResults = ref([]);
// Local state for open accordion indexes managed within this component
const openIndexes = ref<number[]>([]);

// Initialize opened item on first load: open highlighted item if present; otherwise open first item if exists
const initialized = ref(false);
watch(
    () => [props.highlightId, props.faqs.data],
    () => {
        if (initialized.value) return;
        const list = props.faqs?.data || [];
        if (!Array.isArray(list) || list.length === 0) return;

        const idx = list.findIndex((f: any) => f?.id === props.highlightId);
        if (idx !== -1) {
            openIndexes.value = [idx];
            initialized.value = true;
            return;
        }

        // No highlight match; open the first item by default
        openIndexes.value = [0];
        initialized.value = true;
    },
    { immediate: true },
);

function toggleAccordion(index: number) {
    const i = openIndexes.value.indexOf(index);
    if (i > -1) {
        openIndexes.value.splice(i, 1);
    } else {
        openIndexes.value.push(index);
    }
}
</script>
<template>
    <div class="mb-10 flex w-full items-start justify-start gap-16">
        <CategorySidebarList :categories="categories" :selected-category="selectedCategory" @change="$emit('change', $event)" />

        <!-- Content -->
        <div class="flex w-full flex-col gap-6 xl:w-3/4 xl:gap-8">
            <SearchBar @results="searchResults = $event" />
            <h2 class="text-lg font-extrabold text-[#4c84df] xl:text-3xl">
                {{ selectedCategory.name || 'Geen titel' }}
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
                <div class="flex cursor-pointer items-center justify-between" @click="toggleAccordion(index)">
                    <div :class="['font-bold', openIndexes.includes(index) ? 'text-[#e8761c]' : 'text-[#204050]']">
                        {{ faq.question }}
                    </div>
                    <img :src="openIndexes.includes(index) ? upIcon : downIcon" alt="Toggle Answer" class="h-5 w-5" />
                </div>
                <Transition name="faq-accordion">
                    <div v-show="openIndexes.includes(index)" class="mt-2 overflow-hidden text-[#204050]">
                        <div v-html="faq.answer"></div>
                    </div>
                </Transition>
            </div>
            <Paginator v-if="faqs?.links" :links="faqs.links" @navigate="$emit('navigate', $event)" />
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
.faq-accordion-enter-from,
.faq-accordion-leave-to {
    max-height: 0;
    opacity: 0;
}

.faq-accordion-enter-to,
.faq-accordion-leave-from {
    max-height: 500px; /* large enough for typical answers */
    opacity: 1;
}

.faq-accordion-enter-active,
.faq-accordion-leave-active {
    transition:
        max-height 200ms ease,
        opacity 200ms ease;
}
</style>
