import React, { useEffect } from 'react';
import {
  BrowserRouter,
  Switch,
  Route,
  Link,
  RouteProps,
  Redirect
} from "react-router-dom";
import TaskPage from './pages/tasks'
import HelpPage from './pages/help'
import LoginPage from './pages/login'
import NotFoundPage from './pages/error'
import { useLogout, useUser } from './queries/AuthQuery'
import { useAuth } from './hooks/AuthContext';


const Router = () => {
  const logout = useLogout();
  const { isAuth, setIsAuth } = useAuth()
  // ログインユーザーの情報が使えるように設定
  const { isLoading, data: authUser } = useUser()
  console.log('authUser', authUser)

  useEffect(() => {
    if (authUser) {
      setIsAuth(true)
    }
  }, [authUser]) // authUser に変更があった時に再度実行されるように設定

  // ログインしていない時はログイン画面に遷移する
  const GuardRoute = (props: RouteProps) => {
    // isAuth が false の時にリダイレクト
    if (!isAuth) return <Redirect to='/login'/>
    // それ以外はアクセスできるようにルートを返す
    return <Route {...props}/>
  }

  // ログイン状態でログインページにアクセスした時にトップページへリダイレクト
  const LoginRoute = (props: RouteProps) => {
    if (isAuth) return <Redirect to='/' />
    // それ以外はアクセスできるようにルートを返す
    return <Route {...props}/>
  }


  // ヘッダーの切替をするためにヘッダー部分を変数に入れる
  // ログイン後に使うもの
  const navigation = (
    <header className="global-head"> 
      <ul>
        <li><Link to="/">ホーム</Link></li>
        <li><Link to="/help">ヘルプ</Link></li>
        <li onClick={() => logout.mutate()}><span>ログアウト</span></li>
      </ul>
    </header>        
  )

  // ログインしていない時に使うもの
  const loginNavigation = (
    <header className="global-head"> 
      <ul>
        <li><Link to="/help">ヘルプ</Link></li>
        <li><Link to="/login">ログイン</Link></li>
      </ul>
    </header>        
  )

  // ローディングアイコンの設定
  if (isLoading) return <div className='loader'></div>

  // ヘッダー部分はisAuthの状態によって切り替わる
  // トップページはログインしないとアクセスできないページなので GuardRoute (完全一致でアクセスなので exact)
  // ログインページはログインしているとアクセスできないので LoginRoute
  return (
    <BrowserRouter>
        { isAuth? navigation : loginNavigation}
        <Switch>
          <Route path="/help">
            <HelpPage />
          </Route>
          <LoginRoute path="/login">
            <LoginPage />
          </LoginRoute>
          <GuardRoute exact path="/">
            <TaskPage />
          </GuardRoute>
          <Route component={NotFoundPage} />
        </Switch>
    </BrowserRouter>
  );
}

export default Router
