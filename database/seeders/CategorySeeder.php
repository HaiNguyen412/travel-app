<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class CategorySeeder extends Seeder
{
    /**
     * The current Faker instance.
     *
     * @var \Faker\Generator
     */
    protected $faker;

    /**
     * Create a new seeder instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = Faker::create();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cat = Category::query()->create([
            'name' => 'Blog Du Lịch',
            'code' => 'blog',
            'description' => $this->faker->realText(50),
        ]);
        $blogSubject = [];
        for ($i = 0; $i < 5; $i++) {
            $blogSubject[] = [
                'name' => 'subject ' . $cat->name . ' ' . ($i + 1),
            ];
        }
        $blogSubjects = $cat->blogSubjects()->createMany($blogSubject);
        $blogs = [];

        foreach ($blogSubjects as $key => $subject) {
            for ($i = 0; $i < 5; $i++) {
                $blogs[] = [
                    'name' => 'BLOG ' . $blogSubjects[$key]->name . ' ' . $i,
                    'content' => $this->faker->realText(200, 1),
                    'author_id' => $this->faker->numberBetween(1, 10),
                    'status' => $this->faker->numberBetween(1, 3),
                    'like_total' => $this->faker->numberBetween(1, 100),
                    'dislike_total' => $this->faker->numberBetween(1, 100),
                    'comment_total' => $this->faker->numberBetween(1, 100),
                ];
            }
            $subject->blogs()->createMany($blogs);
        }


        $cat = Category::query()->create([
            'name' => 'Seeking Tour Guide',
            'code' => 'seeking_tour_guide',
            'description' => $this->faker->realText(50),
        ]);
        $blogSubject = [];
        for ($i = 0; $i < 5; $i++) {
            $blogSubject[] = [
                'name' => 'subject ' . $cat->name . ' ' . ($i + 1),
            ];
        }
        $blogSubjects = $cat->blogSubjects()->createMany($blogSubject);
        $blogs = [];

        foreach ($blogSubjects as $key => $subject) {
            for ($i = 0; $i < 5; $i++) {
                $blogs[] = [
                    'name' => 'BLOG ' . $blogSubjects[$key]->name . ' ' . $i,
                    'content' => $this->faker->realText(200, 1),
                    'author_id' => $this->faker->numberBetween(1, 10),
                    'status' => $this->faker->numberBetween(1, 3),
                    'like_total' => $this->faker->numberBetween(1, 100),
                    'dislike_total' => $this->faker->numberBetween(1, 100),
                    'comment_total' => $this->faker->numberBetween(1, 100),
                ];
            }
            $subject->blogs()->createMany($blogs);
        }

        $cat = Category::query()->create([
            'name' => 'Hotel',
            'code' => 'hotel',
            'description' => $this->faker->realText(50),
        ]);

        $blogSubject = [];
        for ($i = 0; $i < 5; $i++) {
            $blogSubject[] = [
                'name' => 'subject ' . $cat->name . ' ' . ($i + 1),
            ];
        }
        $blogSubjects = $cat->blogSubjects()->createMany($blogSubject);
        $blogs = [];

        foreach ($blogSubjects as $key => $subject) {
            for ($i = 0; $i < 5; $i++) {
                $blogs[] = [
                    'name' => 'BLOG ' . $blogSubjects[$key]->name . ' ' . $i,
                    'content' => $this->faker->realText(200, 1),
                    'author_id' => $this->faker->numberBetween(1, 10),
                    'status' => $this->faker->numberBetween(1, 3),
                    'like_total' => $this->faker->numberBetween(1, 100),
                    'dislike_total' => $this->faker->numberBetween(1, 100),
                    'comment_total' => $this->faker->numberBetween(1, 100),
                ];
            }
            $subject->blogs()->createMany($blogs);
        }

        $cat = Category::query()->create([
            'name' => 'Restaurant',
            'code' => 'restaurant',
            'description' => $this->faker->realText(50),
        ]);
        $blogSubject = [];
        for ($i = 0; $i < 5; $i++) {
            $blogSubject[] = [
                'name' => 'subject ' . $cat->name . ' ' . ($i + 1),
            ];
        }
        $blogSubjects = $cat->blogSubjects()->createMany($blogSubject);
        $blogs = [];

        foreach ($blogSubjects as $key => $subject) {
            for ($i = 0; $i < 5; $i++) {
                $blogs[] = [
                    'name' => 'BLOG ' . $blogSubjects[$key]->name . ' ' . $i,
                    'content' => $this->faker->realText(200, 1),
                    'author_id' => $this->faker->numberBetween(1, 10),
                    'status' => $this->faker->numberBetween(1, 3),
                    'like_total' => $this->faker->numberBetween(1, 100),
                    'dislike_total' => $this->faker->numberBetween(1, 100),
                    'comment_total' => $this->faker->numberBetween(1, 100),
                ];
            }
            $subject->blogs()->createMany($blogs);
        }
    }
}
