<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Task; // Taskモデルを使う
use App\Models\User; // Userモデルを使う


class TaskTest extends TestCase
{
    use RefreshDatabase; //テスト実行時にDBがリセット

    public function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();
        $this->actingAs($user);
    }
    /**
     * testアノテーションをつけると、test_メソッド名 としなくてよくなる
     *
     * @test
     */
    public function testgetLIst()
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
    // public function タイトルが空の場合は登録できない()
    // {

    //     $data = [
    //         'title' => ''
    //     ];

    //     $response = $this->postJson('api/tasks', $data); //post で受け取るので書き方注意。$dataを第二引数に入れる

    //     $response
    //         ->assertStatus(302) 
    //         ->assertJsonValidationErrors(
    //             ['title' => 'titleは、必ず指定してください。']
    //         ); // バリデーションエラーを確認
    // }

    /**
     * @test
     */
    // public function タイトルが255文字より多い場合は登録できない()
    // {

    //     $data = [
    //         'title' => str_repeat('あ', 256)
    //     ];

    //     $response = $this->postJson('api/tasks', $data); //post で受け取るので書き方注意。$dataを第二引数に入れる
    //     // dd($response);

    //     $response
    //         // ->assertStatus(302) 
    //         ->assertJsonValidationErrors(
    //             ['title' => 'titleは、255文字以下にしてください。']
    //         ); // バリデーションエラーを確認
    // }
    
    /**
     * @test
     */
    // public function 更新することができる()
    // {

    //     $task = Task::factory()->create(); //タスクをあらかじめ登録

    //     $task->title = '書き換え';

    //     $response = $this->patchJson("api/tasks/{$task->id}", $task->toArray()); //更新は patch。taskの array だけなので第二引数に入れる

    //     $response
    //         ->assertOk() 
    //         ->assertJsonFragment($task->toArray()); //正しい情報かどうかの確認。$task->toArray()を引数に持たせる
    // }

    /**
     * @test
     */
    // public function 削除することができる()
    // {

    //     $task = Task::factory()->count(10)->create(); //タスクをあらかじめ登録

    //     $response = $this->deleteJson("api/tasks/1"); //削除は delete。第二引数なし
    //     $response->assertOk();

    //     $response = $this->getJson("api/tasks");
    //     $response->assertJsonCount($task->count()-1); // 期待するカウント数を引数に持たせる

    // }
    

}
