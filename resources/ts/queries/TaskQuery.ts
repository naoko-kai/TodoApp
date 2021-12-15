import * as api from '../api/TaskAPI'
import { useQuery, useMutation, useQueryClient } from 'react-query'
import { toast } from 'react-toastify'

const useTasks = () => {
  return useQuery('tasks', () => {
    return api.getTasks()
  })
}

const useUpdateDoneTask = () => {
  const queryClient = useQueryClient()

  return useMutation(api.updateDoneTask, {
    onSuccess: () => {
      // コンポーネントの再描画
      queryClient.invalidateQueries('tasks') // useQueryで設定した'tasks'を入れる
    },
    onError: () => {
      console.log('再描画に失敗')
      toast.error('更新に失敗しました')
    }
  })
}

export {
  useTasks,
  useUpdateDoneTask
}