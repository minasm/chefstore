import { CategorySimple } from '@/interfaces/categories.interface';
import { Links } from '@/interfaces/pagination.interface';

export interface Faq {
  id: number;
  question: string;
  answer: string;
  category_id: number;
  created_at: string;
  updated_at: string;
}

export type Faqs = Faq[];

export interface FAQResource {
    data: Faq[];
    links: Links;
    total: number;
}

// export interface FaqEntry {
//     id: number;
//     q: string;
//     a: string;
// }
//
// export interface FaqGroup {
//     title: string;
//     questions: FaqEntry[];
// }
//
// // keyed by category slug
// export type FaqsBySlug = Record<string, FaqGroup>;
