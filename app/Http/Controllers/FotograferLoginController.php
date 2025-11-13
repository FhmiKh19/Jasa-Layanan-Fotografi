<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FotograferLoginController extends Controller
{
    private $users = [
        'fotografer1' => 'foto123',
        'fotografer2' => 'pass456'
    ];

    public function showLogin()
    {
        return view('login_fotografer');
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        if(isset($this->users[$username]) && $this->users[$username] === $password){
            session(['username' => $username, 'role' => 'fotografer']);
            return redirect()->route('dashboard.fotografer');
        } else {
            return redirect()->back()->with('error', 'Username atau password salah!');
        }
    }

    public function dashboard()
    {
        if(session('role') !== 'fotografer'){
            return redirect()->route('login.fotografer');
        }
        return view('dashboard_fotografer', ['username' => session('username')]);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login.fotografer');
    }
}
