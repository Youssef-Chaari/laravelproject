<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\ForumTopic;

class ForumCommentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'topic_id' => ForumTopic::inRandomOrder()->value('id') ?? ForumTopic::factory(),
            'user_id'  => User::inRandomOrder()->value('id') ?? User::factory(),
            'content'  => $this->faker->paragraph(2),
        ];
    }
}
