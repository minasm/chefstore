<script setup lang="ts">
import { onMounted, onBeforeUnmount, computed, ref, watch, nextTick } from 'vue';
import { useFaqStore } from '@/stores/categories.js';

import ContactCard from '@/components/ContactCard.vue';
import CategoryMobile from '@/components/CategoryMobile.vue';
import CategoryFaq from '@/components/CategoryFaq.vue';
import LoadingSpinner from '@/components/LoadingSpinner.vue';

import serviceImg from '@/../assets/Settings.svg';
import salesImg from '@/../assets/sales.svg';
import phoneImg from '@/../assets/phone.svg';
import { Categories, CategoriesSimpleResource, Category } from '@/interfaces/categories.interface';

const props = defineProps<{
    categories: CategoriesSimpleResource;
    category: Category;
}>();

// const id = Number(route.params.id);
// const highlightId = computed(() => Number(route.query.highlight));

const faqStore = useFaqStore();
const faqCategories = ref({});
const selectedCategory = ref(null);
// const allCategories = computed(() => faqStore.categories);
const openIndexes = ref([]);
const currentCategoryId = ref(props.category.id);

const scrollToRelevantFaq = async () => {
    const questions = faqCategories.value[selectedCategory.value]?.questions || [];

    if (questions.length === 0) return;

    await nextTick();

    let indexToOpen = 0;
    let highlightElementId = '';

    // if (highlightId.value) {
    //     const foundIndex = questions.findIndex((q) => q.id === highlightId.value);
    //     if (foundIndex !== -1) {
    //         indexToOpen = foundIndex;
    //         highlightElementId = `faq-${highlightId.value}`;
    //     }
    // } else {
    //     highlightElementId = `faq-${questions[0].id}`;
    // }

    openIndexes.value = [indexToOpen];

    // Prefer the visible element when duplicate IDs exist (mobile and desktop renderings)
    const isVisible = (node) => {
        if (!node) return false;
        // Hidden elements typically have no client rects
        const rects = node.getClientRects();
        if (!rects || rects.length === 0) return false;
        // Also check computed style display/visibility where possible
        const style = window.getComputedStyle(node);
        if (style.display === 'none' || style.visibility === 'hidden' || style.opacity === '0') return false;
        return true;
    };

    let el = document.getElementById(highlightElementId);
    if (!isVisible(el)) {
        const candidates = document.querySelectorAll(`[id="${highlightElementId}"]`);
        for (const n of candidates) {
            if (isVisible(n)) {
                el = n;
                break;
            }
        }
    }

    if (el) {
        const inViewport = (node, margin = 16) => {
            if (!node) return false;
            const rect = node.getBoundingClientRect();
            const vh = window.innerHeight || document.documentElement.clientHeight;
            const vw = window.innerWidth || document.documentElement.clientWidth;
            const topOk = rect.top >= 0 + margin;
            const leftOk = rect.left >= 0;
            const bottomOk = rect.bottom <= vh - margin;
            const rightOk = rect.right <= vw;
            return topOk && leftOk && bottomOk && rightOk;
        };

        if (!inViewport(el, 24)) {
            el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
        el.classList.add('highlight');
        setTimeout(() => el.classList.remove('highlight'), 1500);
    }
};

const loadCategory = async (category) => {
    // Defensive: ignore bad emits
    if (!category || !category.id) {
        console.warn('loadCategory called without a valid category:', category);
        return;
    }

    const targetId = Number(category.id);
    const targetSlug = category.slug;
    const currentPage = 1; //Number(route.query.page) > 0 ? Number(route.query.page) : 1;

    // If we're already on the same category+page (e.g., caused by re-renders), skip.
    if (props.category.id === targetId) {
        // Ensure selectedCategory syncs with slug but do not refetch.
        selectedCategory.value = targetSlug || selectedCategory.value;
        return;
    }

    // Only update the route; the route watcher will perform the fetch, state updates and scrolling
    // await router.replace({
    //     name: "CategoryDetail",
    //     params: { id: targetId, slug: targetSlug },
    //     query: { page: currentPage },
    // });

    // Optimistically update selected slug to keep sidebar highlight responsive; data will sync in watcher
    selectedCategory.value = category.slug;
};

onMounted(async () => {
    // await faqStore.fetchCategories();
    // const initialPage = 1//Number(route.query.page) > 0 ? Number(route.query.page) : 1;
    // const data = await faqStore.fetchCategoryDetail(props.category.id, initialPage);
    const data = props.category.faqs;
    if (data) {
        faqCategories.value = {
            [data.slug]: {
                title: data.name,
                questions: data.faqs,
                pagination: data.pagination,
            },
        };
        selectedCategory.value = data.slug;
        currentCategoryId.value = data.id ?? props.category.id;
        await scrollToRelevantFaq();
    }
});

// Debounced combined watcher: coalesce id/page changes and fetch once with final values
let _routeRefetchTimer = null;
// watch(
//     [() => route.params.id, () => route.query.page],
//     () => {
//         if (_routeRefetchTimer) clearTimeout(_routeRefetchTimer);
//         _routeRefetchTimer = setTimeout(async () => {
//             const numericId = Number(route.params.id);
//             if (!numericId) return;
//             const page = Number(route.query.page) > 0 ? Number(route.query.page) : 1;
//             const data = await faqStore.fetchCategoryDetail(numericId, page);
//             if (data) {
//                 faqCategories.value = {
//                     [data.slug]: {
//                         title: data.name,
//                         questions: data.faqs,
//                         pagination: data.pagination,
//                     },
//                 };
//                 selectedCategory.value = data.slug;
//                 currentCategoryId.value = numericId;
//                 // Reset accordions when page/id changes; scroll function will open relevant one
//                 openIndexes.value = [];
//                 await nextTick();
//                 await scrollToRelevantFaq();
//             }
//         }, 0);
//     }
// );

// Re-scroll when highlight query changes to keep UX consistent
watch();
// () => route.query.highlight,
// async () => {
//     await scrollToRelevantFaq();
// }

onBeforeUnmount(() => {
    if (_routeRefetchTimer) clearTimeout(_routeRefetchTimer);
});

// Handle page change from CategoryFaq: update URL only, combined watcher will refetch
async function changePage(page) {
    // const catId = currentCategoryId.value || Number(route.params.id);
    // if (!catId) return;
    // await router.replace({
    //     name: 'CategoryDetail',
    //     params: { id: catId, slug: selectedCategory.value || route.params.slug },
    //     query: { ...route.query, page }
    // });
}
</script>

<template>
    <div class="xl:px-32 xl:py-5">
        <!-- Web -->
        <div class="hidden flex-col xl:flex">
            <h1 class="mb-32 text-3xl font-extrabold text-[#4c84df]">Klantenservice</h1>
            <div class="mb-10 flex h-46 bg-[#2e567d] px-16">
                <div class="h-60 w-60 items-center justify-start">
                    <a href="https://www.chefstore.nl/" target="_blank">
                        <img class="mt-[-6rem]" src="@/../assets/man.png" alt="Chefstore" />
                    </a>
                </div>
                <div class="ml-8 flex flex-col justify-center">
                    <p class="mb-4 text-xl font-extrabold text-white">Voor alle contactmogelijkheden,<br />klik bovenin op het telefoon icoontje.</p>
                    <div class="flex gap-6">
                        <ContactCard title="Service" value="service@chefstore.nl" :imgSrc="serviceImg" />
                        <ContactCard title="Sales" value="sales@chefstore.nl" :imgSrc="salesImg" />
                        <ContactCard title="Telefoon" value="+31 85 0441003" :imgSrc="phoneImg" />
                    </div>
                </div>
            </div>
        </div>

        <!-- Mobile -->
        <div class="mt-6 flex w-full flex-col px-5 xl:hidden">
            <LoadingSpinner v-if="category.faqs?.length === 0" />
            <CategoryFaq
                v-else
                :categories="category.faqs"
                :selectedCategory="selectedCategory"
                isMobile
                :highlight-id="highlightId"
                :open-indexes="openIndexes"
                :pagination="faqCategories[selectedCategory]?.pagination"
                @page-change="changePage"
            />
        </div>

        <div class="flex w-full flex-col xl:hidden">
            <CategoryMobile :categories="categories.data" v-model:selectedCategory="selectedCategory" />
        </div>

        <!-- Web Category -->
        <div class="hidden xl:block">
            <LoadingSpinner v-if="category.faqs?.length === 0" />
            <CategoryFaq
                v-else
                :categories="category.faqs"
                :selectedCategory="selectedCategory"
                :all="categories.data"
                :highlight-id="highlightId"
                :open-indexes="openIndexes"
                :pagination="faqCategories[selectedCategory]?.pagination"
                isMobile
                @change="loadCategory"
                @page-change="changePage"
            />
        </div>
    </div>
</template>

<style scoped></style>
