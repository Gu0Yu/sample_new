<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class SessionsController extends Controller
{
    //登陆首页
    public function create() {
        return view('sessions.create');
    }
    //登陆验证
    public function store(Request $request) {
        $credentials = $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);
        //var_dump($credentials);
        if (Auth::attempt($credentials, $request->has('remember'))) {
            //登陆成功
            session()->flash('success', '欢迎回来');
            return redirect()->route('users.show', [Auth::user()]);
        } else {
            //登录失败
            session()->flash('danger', '邮箱和密码不正确');
            return redirect()->back();
        }

        return;
    }

    public function destroy() {
        Auth::logout();
        session()->flash('success', '你已成功退出');
        return redirect('login');
    }
}
