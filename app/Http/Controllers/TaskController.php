<?php

namespace App\Http\Controllers;

use App\Models\Task;
// use App\Http\Requests\StoreTaskRequest;
// use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * タスク一覧を表示
     *
     * @return Task[] | \Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Task::orderByDesc('id')->get();
    
    }

    /**
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
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
}
