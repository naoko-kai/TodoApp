<?php

namespace App\Http\Controllers;

use App\Models\Task;
// use App\Http\Requests\StoreTaskRequest;
// use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * TaskPolicyを実行する
     */
    public function __construct() 
    {
        // ポリシーの指定と範囲の限定
        $this->middleware('can:checkUser,task')->only([
            'updateDone', 'update', 'destroy'
        ]);
    }


    /**
     * タスク一覧を表示
     *
     * @return Task[] | \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        // タスクのユーザーIDとログインユーザーIDが一致しているものを返す
        // AuthファサードからIDを指定する
        return Task::where('user_id', Auth::id())->orderByDesc('id')->get();
        // return Task::orderByDesc('id')->get();
    
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // マージ機能でユーザーIDを追加する
        $request->merge([
            'user_id' => Auth::id()
        ]);

        $validator = Validator::make($request->all(), [
            'title'  => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
            ->withInput()
            ->withErrors($validator);
        }

        $task = Task::create($request->all());

        return $task
            ? response()->json($task, 201)
            : response()->json([],500);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        //使わない
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Task $task)
    {
        // 更新するのはタスクのタイトル
        $task->title = $request->title;

        return $task->update()
            ? response()->json($task) // デフォルトが200
            : response()->json([],500);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Task $task)
    {
        return $task->delete()
            ? response()->json($task) // デフォルトが200
            : response()->json([],500);
    }

    /**
     * チェックリストの is_done アップデート
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateDone(Request $request, Task $task)
    {
        $task->is_done = $request->is_done;

        return $task->update()
            ? response()->json($task)
            : response()->json([], 500);
    }
}
