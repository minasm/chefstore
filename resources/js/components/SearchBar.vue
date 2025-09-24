<script setup lang="ts">
import { ref, watch } from "vue";
import { debounce } from "lodash";
import { router } from '@inertiajs/vue3'
import { show } from "@/actions/App/Http/Controllers/CategoryController";
import type { PageProps as InertiaPageProps } from '@inertiajs/core'

interface SearchResult {
    id: number
    category_id: number|string
    category_slug: string
    question: string
    answer: string
    page?: number|string
}


// Refs
const searchTerm = ref<string>("");
const results = ref<SearchResult[]>([]);
defineEmits<{
  (e: "results", payload: SearchResult[]): void;
  (e: "select", payload: SearchResult): void;
}>();
import { usePage } from '@inertiajs/vue3';

type LocalProps = { searchResults?: SearchResult[] }
const page = usePage<InertiaPageProps & LocalProps>()

watch(
    () => page.props.searchResults,
    (val) => { results.value = val ?? []; },
    { immediate: true }
);


// When the page re-renders with the lazy prop, you'll receive it via props.
// If SearchBar lives inside the page, just accept it as a prop:
const props = defineProps<{ searchResults?: SearchResult[] }>()
watch(() => props.searchResults, (val) => {
    if (val) results.value = val
})

const runSearch = debounce(() => {
    router.reload({
        only: ['searchResults'],   // ask only for our lazy prop
        data: { term: searchTerm.value.trim() },
        replace: true,
    })
}, 250)

function selectResult(hit: SearchResult) {
    const page = Number(hit.page ?? 1)

    // Ziggy (named route):
    // const url = route('category.show', hit.category_slug ?? hit.category_id)

    // If using Wayfinder:
    // const url = show(hit.category_slug ?? hit.category_id)
    const url = show(hit.category_slug ?? hit.category_id)
    router.get(url, { highlight: hit.id, page }, { preserveScroll: true })
}
</script>
<template>
    <div class="w-full relative">
        <div
            class="h-12 px-8 py-2.5 bg-[#2f86de]/5 rounded-full outline outline-[#2f86de] flex justify-between items-center gap-2.5"
        >
            <input
                v-model="searchTerm"
                @input="runSearch"
                type="text"
                placeholder="Zoek de vragen die u heeft."
                class="bg-transparent text-[#4c84df] placeholder-[#4c84df]/50 w-full outline-none"
            />
            <img class="w-6 h-6" src="../../assets/search.svg" alt="Search Icon"/>
        </div>

        <ul
            v-if="results.length > 0 && searchTerm.trim()"
            class="absolute z-10 text-[#4c84df] bg-white border border-[#2f86de] w-full mt-1 rounded-lg shadow-lg max-h-60 overflow-y-auto"
        >
            <li
                v-for="faq in results"
                :key="faq.id"
                @mousedown.prevent.stop="selectResult(faq)"

                class="p-3 hover:bg-[#2f86de]/5 cursor-pointer"
            >
                {{ faq.question }}
            </li>
        </ul>
    </div>
</template>
