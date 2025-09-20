import { Faq, FAQResource } from './faq.interface';

export interface Category {
  id: number;
  name: string;
  slug: string;
  faqs_count: number;
  description?: string | null;
  image?: string | null;
  created_at?: string;
  updated_at?: string;
  faqs: FAQResource[];
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

export interface SelectedCategory {
    id: number;
    name: string;
    slug: string;
    description: string;
    image: string | null;
    created_at: string;
    updated_at: string;
    faqs?: Faq[];
}
