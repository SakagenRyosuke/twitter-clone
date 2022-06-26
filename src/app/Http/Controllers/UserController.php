<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function userList()
    {
        $allUser = User::all();
        $loginUser = Auth::user();
        unset($allUser[$loginUser["id"] - 1]);
        return $allUser;
    }

    public function loginUser()
    {
        return Auth::user();
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }

    public function show(User $id)
    {
        return $id;
    }

    public function followCheck($id)
    {
        $check_user = Auth::user();
        return $check_user->isFollowing($id);
    }
}
