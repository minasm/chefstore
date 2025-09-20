<script setup lang="ts">
import { ref, watch } from "vue";
import { debounce } from "lodash";
import { router } from '@inertiajs/vue3'
import { show } from "@/actions/App/Http/Controllers/CategoryController";
// === Types ===
interface SearchResult {
    id: number
    category_id: number|string
    category_slug?: string|null
    question: string
    answer: string
    page?: number|string
}

// interface SearchApiPayload {
//   data: {
//     results: SearchResult[];
//   };
// }

interface CategorySummary {
  id: number;
  slug: string;
  name?: string;
}

// Refs
const searchTerm = ref<string>("");
const results = ref<SearchResult[]>([]);
defineEmits<{
  (e: "results", payload: SearchResult[]): void;
  (e: "select", payload: SearchResult): void;
}>();
import { usePage } from '@inertiajs/vue3';

type PageProps = { searchResults?: SearchResult[] };
const page = usePage<PageProps>();

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
//
// const handleSearch = debounce(async (): Promise<void> => {
//   const term = searchTerm.value.trim();
//   if (term === "") {
//     results.value = [];
//     emit("results", []);
//     return;
//   }
//
//   try {
//     // If your axios instance already unwraps `response.data`, adjust as needed.
//     const response = await axios.get<SearchApiPayload>("/search", {
//       params: { term },
//     });
//
//     // Some backends return {data: {...}} already unwrapped by axios interceptor; safeguard both shapes.
//     const payload: SearchApiPayload["data"] =
//         // @ts-expect-error – tolerate either shape at runtime
//         (response?.data?.data ?? response?.data) as SearchApiPayload["data"];
//
//     results.value = Array.isArray(payload?.results) ? payload.results : [];
//     emit("results", results.value);
//   } catch (err) {
//     console.error("Arama hatası:", err);
//   }
// }, 400);
const runSearch = debounce(() => {
    router.reload({
        only: ['searchResults'],   // ask only for our lazy prop
        data: { term: searchTerm.value.trim() },
        preserveState: true,
        preserveScroll: true,
        replace: true,
    })
}, 250)
// const selectResult = async (faq: SearchResult): Promise<void> => {
//   // console.log to verify types at runtime
//   // console.log("Selected result:", faq);
//   searchTerm.value = faq.question;
//   results.value = [];
//
//   // Ensure categories exist (Home.vue may render SearchBar before categories load)
//   if (!Array.isArray(faqStore.categories) || faqStore.categories.length === 0) {
//     await faqStore.fetchCategories();
//   }
//
//   const idNum = Number(faq.category_id);
//   const pageNum = faq.page != null ? Number(faq.page) : 1;
//
//
//   const fromStore: CategorySummary | undefined = Array.isArray(faqStore.categories)
//       ? (faqStore.categories as CategorySummary[]).find(
//           (c) => Number(c.id) === idNum
//       )
//       : undefined;
//
//   const slug = faq.category_slug ?? fromStore?.slug ?? (route.params.slug as string | undefined);
//
//   if (!idNum || !slug) {
//     console.warn("Cannot navigate: missing id or slug", { idNum, slug, faq });
//     return;
//   }
//
//   await router.push({
//     name: "CategoryDetail",
//     params: { id: idNum, slug },
//     query: { highlight: faq.id, page: pageNum },
//   });
// };
//

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
