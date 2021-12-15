import * as api from '../api/TaskAPI'
import { useQuery, useMutation, useQueryClient } from 'react-query'
import { toast } from 'react-toastify'
import { AxiosError } from 'axios'

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
      toast.error('更新に失敗しました')
    }
  })
}

const useCreateTask = () => {
  const queryClient = useQueryClient()

  return useMutation(api.createTask, {
    onSuccess: () => {
      // コンポーネントの再描画
      queryClient.invalidateQueries('tasks') // useQueryで設定した'tasks'を入れる
      toast.success('登録に成功しました')
    },
    onError: (error: AxiosError) => {
      // もしもエラーだったらオブジェクトの中をループさせてエラーメッセージをトーストする
      if (error.response?.data.errors) {
        Object.values(error.response?.data.errors).map(
          (messages: any) => {
            messages.map((message: string) => {
              toast.error(message);
            })
          }
        );
        
      } else {
        toast.error('登録に失敗しました')
      }
      
    }
  })
}

const useUpdateTask = () => {
  const queryClient = useQueryClient()

  return useMutation(api.updateTask, {
    onSuccess: () => {
      // コンポーネントの再描画
      queryClient.invalidateQueries('tasks') // useQueryで設定した'tasks'を入れる
      toast.success('更新に成功しました')
    },
    onError: (error: AxiosError) => {
      // もしもエラーだったらオブジェクトの中をループさせてエラーメッセージをトーストする
      if (error.response?.data.errors) {
        Object.values(error.response?.data.errors).map(
          (messages: any) => {
            messages.map((message: string) => {
              toast.error(message);
            })
          }
        );
        
      } else {
        toast.error('更新に失敗しました')
      }
      
    }
  })
}

const useDeleteTask = () => {
  const queryClient = useQueryClient()

  return useMutation(api.deleteTask, {
    onSuccess: () => {
      // コンポーネントの再描画
      queryClient.invalidateQueries('tasks') // useQueryで設定した'tasks'を入れる
      toast.success('削除に成功しました')
    },
    onError: () => {
      toast.error('削除に失敗しました')
    }
  })
}

export {
  useTasks,
  useUpdateDoneTask,
  useCreateTask,
  useUpdateTask,
  useDeleteTask
}