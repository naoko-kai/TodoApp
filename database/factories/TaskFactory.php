<?php

namespace Database\Factories;

use App\Model\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user_id = $this->faker->numberBetween(1,3); // 3人のダミーデータなので1～3までランダムで入るように設定

        return [
            'title' => $user_id .':' . $this->faker->realText(rand(15,40)), // ユーザーIDをタイトルに入れる
            'is_done' => $this->faker->boolean(10),
            'user_id' => $user_id, 
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
