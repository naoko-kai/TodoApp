<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class); // タスクはユーザーデータを見ることになるので先にユーザーデータを生成する
        $this->call(TaskSeeder::class);
    }
}
