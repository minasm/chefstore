import { Faq } from "./faq.interface";

export interface Category {
  id: number;
  name: string;
  slug: string;
  faqs_count: number;
  description?: string | null;
  image?: string | null;
  created_at?: string;
  updated_at?: string;
  faqs?: Faq[];
}

export type Categories = Category[];

export interface CategorySimple {
    id: number;
    name: string;
    slug: string;
}

export interface CategoriesSimpleResource {
    data: CategorySimple[];
}
