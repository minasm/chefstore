<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $index = 0;
        $index++;

        return [
            'name' => "Category {$index}",
            'slug' => "category-{$index}",
            'description' => $this->faker->paragraph(),
            'image' => 'https://placehold.co/640x480?text='.urlencode("Category {$index}"),
            'sort' => $index,
        ];
    }
}
