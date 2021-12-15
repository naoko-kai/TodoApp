import React, { useState } from 'react';
import { Task } from '../../../types/Task';
import { useUpdateDoneTask, useUpdateTask, useDeleteTask } from '../../../queries/TaskQuery'
import { toast } from 'react-toastify'

type Props = {
  task: Task
}

const TaskItem: React.VFC<Props> = ({ task }) => {
  
  const updateDoneTask = useUpdateDoneTask()
  const updateTask = useUpdateTask()
  const deleteTask = useDeleteTask()

  const [editTitle, setEditTitle] = useState<string|undefined>(undefined) // 初期値にundefined

  const handleToggleEdit = () => {
    setEditTitle(task.title) // タイトルが入るとundefinedじゃなくなるので見た目も切り替わる
  }

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setEditTitle(e.target.value) // 入力の度にデータが保持される
  }

  const handleUpdate = (e: React.FormEvent<HTMLFormElement> | React.MouseEvent<HTMLButtonElement>) => {
    e.preventDefault()

    if (!editTitle) { // editTitleが入力されてない場合は処理を実行しないようにする
      toast.error('タイトルを入力してください')
      return
    }
    const newTask = { ...task }
    newTask.title = editTitle

    updateTask.mutate({
      id: task.id,
      task: newTask
    })

    setEditTitle(undefined)

  }

  const handleOnKey = (e: React.KeyboardEvent<HTMLInputElement>) => {
    if (['Escape', 'Tab'].includes(e.key)) { // 押されたキーボードがエスケープかタブなら初期のundefinedに戻す
      setEditTitle(undefined)
    }
  }


  const itemInput = () => {
    return (
      <>
        <form onSubmit={handleUpdate}>
          <input
            type='text'
            className='input'
            defaultValue={editTitle}
            onChange={handleInputChange}
            onKeyDown={handleOnKey}
          />
        </form>
        <button className='btn' onClick={handleUpdate}>更新</button>
      </>
    )
  }

  const itemText = () => {
    return (
      <>
        <div onClick={ handleToggleEdit }>
          <span>{ task.title }</span>
        </div>
        <button className='btn is-delete' onClick={() => deleteTask.mutate(task.id)}>
          削除
        </button>
      </>
    )
  }

  return (
    <li className={ task.is_done ? 'done' : ''}>
      <label className="checkbox-label">
        <input
          type="checkbox"
          className="checkbox-input"
          onClick={() => updateDoneTask.mutate(task)}
        />
      </label>
      {/* <div><span>{task.title}</span></div> 
      <button className="btn is-delete">削除</button> */}
      { /**ステートで持たせた情報を基にインプットタグ（タスク内容とボタンの表示をする） */}
      { editTitle === undefined ? itemText() : itemInput() }
    </li>
  )
}

export default TaskItem
