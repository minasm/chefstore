import { defineStore } from "pinia";
import axios from "@/plugins/axios";

export const useFaqStore = defineStore("faq", {
  state: () => ({
    categories: [],
    selectedCategory: null,
    faqCategories: {},
    loading: false,
    error: null,
  }),

  actions: {
    async fetchCategories() {
      this.loading = true;
      try {
        const response = await axios.get("/categories");
        this.categories = response.data.data;
      } catch (error) {
        this.error = "Kategoriler alınamadı";
        this.categories = [];
      } finally {
        this.loading = false;
      }
    },
    async fetchCategoryDetail(id, page = 1) {
        if (id === undefined || id === null || id === '' || Number.isNaN(Number(id))) {
            console.warn('fetchCategoryDetail called with invalid id:', id, 'page:', page);
            return null;
        }
      this.loading = true;
      try {
        const response = await axios.get(`/categories/${id}`, {
          params: { page },
        });
        const result = response.data.data;

        const category = result.category;
        const faqs = result.faqs;
        const pagination = result.pagination;

        const formattedFaqs = faqs.map((faq) => ({
          id: faq.id,
          q: faq.question,
          a: faq.answer,
        }));

        const slug = category.slug;

        this.selectedCategory = category;
        this.faqCategories[slug] = {
          title: category.name,
          questions: formattedFaqs,
          pagination,
        };

        return {
          ...category,
          slug,
          faqs: formattedFaqs,
          pagination,
        };
      } catch (error) {
        this.error = "Kategori detayı alınamadı";
        return null;
      } finally {
        this.loading = false;
      }
    },
  },
});
