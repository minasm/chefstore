<script setup lang="ts">
import { computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { useMediaQuery } from '@vueuse/core';

import ContactCard from '@/components/ContactCard.vue';
import CategoryMobile from '@/components/CategoryMobile.vue';
import CategoryFaq from '@/components/CategoryFaq.vue';
import LoadingSpinner from '@/components/LoadingSpinner.vue';

import serviceImg from '@/../assets/Settings.svg';
import salesImg from '@/../assets/sales.svg';
import phoneImg from '@/../assets/phone.svg';
import { CategoriesSimpleResource, Category } from '@/interfaces/categories.interface';

const props = withDefaults(
    defineProps<{
        categories: CategoriesSimpleResource;
        category: Category;
        highlightId?: number | null;
    }>(),
    {
        highlightId: null,
    },
);

const isDesktop = useMediaQuery('(min-width: 1280px)');
const isFaqLoading = computed(() => {
    const data = props.category.faqs?.data;
    return !Array.isArray(data) || data.length === 0;
});

function handlePageNavigation(url: string | null) {
    if (!url) return;

    router.visit(url, {
        preserveState: true,
        preserveScroll: false,
        onSuccess: () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
    });
}

</script>

<template>
    <div class="xl:px-32 xl:py-5">
        <div v-if="isDesktop" class="flex flex-col">
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

            <div>
                <LoadingSpinner v-if="isFaqLoading" />
                <CategoryFaq
                    v-else
                    :faqs="category.faqs"
                    :selectedCategory="category"
                    :categories="categories.data"
                    :highlight-id="props.highlightId"
                    @navigate="handlePageNavigation"
                />
            </div>
        </div>

        <div v-else class="flex w-full flex-col gap-6">
            <div class="mt-6 flex w-full flex-col px-5">
                <LoadingSpinner v-if="isFaqLoading" />
                <CategoryFaq
                    v-else
                    :faqs="category.faqs"
                    :selectedCategory="category"
                    :highlight-id="props.highlightId"
                    @navigate="handlePageNavigation"
                />
            </div>

            <div class="flex w-full flex-col">
                <CategoryMobile :categories="categories.data" v-model:selectedCategory="category.name" />
            </div>
        </div>
    </div>
</template>

<style scoped></style>
