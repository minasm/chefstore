<template>

    <Navbar />
    <div class="xl:px-32 xl:py-5">

        <h1 class="mb-32 hidden text-3xl font-extrabold text-[#4c84df] xl:flex">Klantenservice</h1>

        <div class="mb-10 flex h-full w-full flex-col bg-[#2e567d] px-4 py-8 xl:h-46 xl:flex-row xl:px-16 xl:py-8">
            <!-- Image Section -->
            <div class="hidden h-60 w-60 items-center justify-start xl:flex">
                <a href="https://www.chefstore.nl/" target="_blank">
                    <img class="mb-54" src="../../assets/man.png" alt="Chefstore" />
                </a>
            </div>
            <div class="flex w-full items-center justify-start xl:hidden">
                <a href="https://www.chefstore.nl/" target="_blank">
                    <img class="w-[180px]" src="../../assets/man.png" alt="Chefstore" />
                </a>
                <p class="mb-4 flex text-sm font-extrabold text-white xl:hidden xl:text-xl">
                    Voor alle contactmogelijkheden,<br />klik bovenin op het telefoon icoontje.
                </p>
            </div>


            <div class="flex flex-col justify-center xl:ml-8">
                <p class="mb-4 hidden text-base font-extrabold text-white xl:flex xl:text-xl">
                    Voor alle contactmogelijkheden,<br />klik bovenin op het telefoon icoontje.
                </p>

                <div class="flex flex-col gap-3 md:flex-row md:gap-6">
                    <ContactCard title="Service" value="service@chefstore.nl" :imgSrc="serviceImg" />
                    <ContactCard title="Sales" value="sales@chefstore.nl" :imgSrc="salesImg" />
                    <ContactCard title="Telefoon" value="+31 85 0441003" :imgSrc="phoneImg" />
                </div>
            </div>
        </div>

        <div class="mb-4 flex px-4 text-lg font-extrabold text-[#4c84df] xl:hidden">Klantenservice</div>
        <div class="relative mb-10 flex w-full gap-8 px-4 xl:px-0">
            <div class="hidden text-3xl font-extrabold text-[#4c84df] xl:flex">Categorieën</div>

            <SearchBar />
        </div>
        <LoadingSpinner v-if="!categories" />

        <div v-else>

            <div class="hidden xl:block">
                <CategoryGrid :categories="categories.data" />

                <Paginator :links="categories.links" @navigate="changePage" />
            </div>

            <div class="block xl:hidden">
                <CategoryMobile :categories="categories.data" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { router } from '@inertiajs/vue3';

import ContactCard from '@/components/ContactCard.vue';
import CategoryGrid from '@/components/CategoryGrid.vue';
import CategoryMobile from '@/components/CategoryMobile.vue';
import LoadingSpinner from '@/components/LoadingSpinner.vue';
import SearchBar from '@/components/SearchBar.vue';

import serviceImg from '../../assets/Settings.svg';
import salesImg from '@/../assets/sales.svg';
import phoneImg from '../../assets/phone.svg';
import Paginator from '@/components/Paginator.vue';
import { CategoriesSimpleResource } from '@/interfaces/categories.interface';
import Navbar from '@/components/Navbar.vue';


defineProps<{
    categories?: CategoriesSimpleResource;
}>();


const changePage = (url: string | null) => {
    if (!url) return;
    router.visit(url, {
        preserveState: true,
        preserveScroll: true,
    });
};
</script>
