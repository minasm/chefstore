<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Faq;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categoryCount = 20;
        $faqsPerCategory = 25;

        // Clear existing data
        // Faq::truncate();
        // Category::truncate();

        // Create categories with FAQs
        Category::factory()
            ->count($categoryCount)
            ->has(
                Faq::factory()->count($faqsPerCategory),
                'faqs'
            )
            ->create();

        $this->command->info("✅ Seeded {$categoryCount} categories with {$faqsPerCategory} FAQs each.");
    }
}
