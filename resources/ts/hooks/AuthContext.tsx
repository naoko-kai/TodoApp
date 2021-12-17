import React, { createContext, useState, useContext, ReactNode } from 'react'

type AuthContextProps = {
  isAuth: boolean
  setIsAuth: React.Dispatch<React.SetStateAction<boolean>>
}

// 作成する時に AuthContextProps を設定して初期値を書く
const AuthContext = createContext<AuthContextProps>({
  isAuth: false,
  setIsAuth: () => {}
})

export const AuthProvider: React.VFC<{children:ReactNode}> = ({ children }) => {
  const [isAuth, setIsAuth] = useState(false)

  return (
    <AuthContext.Provider value={{ isAuth, setIsAuth }}>
      { children }
    </AuthContext.Provider>
  )
}

export const useAuth = () => useContext(AuthContext)