<?php

namespace Database\Factories;

use App\Models\Faq;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Faq>
 */
class FaqFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Faq::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'question' => $this->faker->sentence(8) . '?',
            'answer' => $this->faker->paragraph(2),
        ];
    }

    /**
     * Indicate that the FAQ should not have a category.
     */
    public function withoutCategory(): static
    {
        return $this->state(fn (array $attributes) => [
            'category_id' => null,
        ]);
    }

    /**
     * Indicate that the FAQ should belong to a specific category.
     */
    public function forCategory(int $categoryId): static
    {
        return $this->state(fn (array $attributes) => [
            'category_id' => $categoryId,
        ]);
    }
}