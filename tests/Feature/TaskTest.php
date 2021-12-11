<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task; // Taskモデルを使う

class TaskTest extends TestCase
{
    use RefreshDatabase; //テスト実行時にDBがリセット
    /**
     * testアノテーションをつけると、test_メソッド名 としなくてよくなる
     *
     * @test
     */
    public function 一覧を取得()
    {
        $tasks = Task::factory()->count(10)->create();

        $response = $this->getJson('api/tasks');

        $response
            ->assertOk()
            ->assertJsonCount($tasks->count()); // Tasksの数をカウントして一致するか確認
    }

    /**
     * @test
     */
    public function 登録することができる()
    {

        $data = [
            'title' => 'テスト投稿'
        ];

        $response = $this->postJson('api/tasks', $data); //post で受け取るので書き方注意。$dataを第二引数に入れる

        $response
            ->assertCreated() // assertOk と同じ
            ->assertJsonFragment($data); // 登録情報が正しいか確認
    }

    /**
     * @test
     */
    public function 更新することができる()
    {

        $task = Task::factory()->create(); //タスクをあらかじめ登録

        $task->title = '書き換え';

        $response = $this->patchJson("api/tasks/{$task->id}", $task->toArray()); //更新は patch。taskの array だけなので第二引数に入れる

        $response
            ->assertOk() 
            ->assertJsonFragment($task->toArray()); //正しい情報かどうかの確認。$task->toArray()を引数に持たせる
    }

    /**
     * @test
     */
    public function 削除することができる()
    {

        $task = Task::factory()->count(10)->create(); //タスクをあらかじめ登録

        $response = $this->deleteJson("api/tasks/1"); //削除は delete。第二引数なし
        $response->assertOk();

        $response = $this->getJson("api/tasks");
        $response->assertJsonCount($task->count()-1); // 期待するカウント数を引数に持たせる

    }
    

}