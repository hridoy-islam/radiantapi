<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\BlogPost;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BlogPost>
 */
class BlogPostFactory extends Factory
{
    protected $model = BlogPost::class;

    public function definition(): array
    {
        $title = $this->faker->sentence;
        $slug = Str::slug($title, '-');

        return [
            'title' => $title,
            'content' => $this->faker->paragraphs(asText: true),
            'thumbnail' => $this->faker->optional()->imageUrl(1200, 800, 'business'),
            'seo_title' => $this->faker->optional()->sentence,
            'meta_description' => $this->faker->optional()->text(150),
            'slug' => $slug,
            'meta_keywords' => json_encode($this->faker->words(5)),
            'og_title' => $this->faker->optional()->sentence,
            'og_description' => $this->faker->optional()->text(150),
            'og_image' => $this->faker->optional()->imageUrl(1200, 630, 'business'),
            'canonical_url' => $this->faker->optional()->url,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
