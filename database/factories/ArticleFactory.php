<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $content = ["blocks"=>[["type"=>"paragraph","data"=>['text'=>fake()->paragraph(5)]]]] ;
        return [
            'title' => fake()->name(),
            'content' => json_encode($content),
            'author_id' => User::inRandomOrder()->first()->id ,
        ];
    }
}
