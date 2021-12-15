import axios from 'axios'
import { Task } from '../types/Task'

const getTasks = async () => {
  const { data } = await axios.get<Task[]>('api/tasks')
  return data
}

const updateDoneTask = async ({ id, is_done }: Task) => {
  const { data } = await axios.patch<Task>(
    `/api/tasks/update-done/${id}`,
    { is_done: !is_done } // 送信する値 is_doneが切り替わる
  )
  return data
}

const updateTask = async ({ id, task }: { id: number, task: Task}) => {
  const { data } = await axios.put<Task>(
    `/api/tasks/${id}`,
    task // 送信する値 task を渡す
  )
  return data
}

const deleteTask = async (id: number) => {
  const { data } = await axios.delete<Task>(
    `/api/tasks/${id}`,
  )
  return data
}

const createTask = async (title: string) => {
  const { data } = await axios.post<Task>(
    `/api/tasks`,
    { title: title } 
  )
  return data
}

export {
  getTasks,
  updateDoneTask,
  createTask,
  updateTask,
  deleteTask
}