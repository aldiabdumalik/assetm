<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        return view('login');
    }

    public function auth(Request $request)
    {
        if ($request->ajax()) {
            if (Auth::attempt(['email' => $request->username, 'password' => $request->password])) {
                return thisSuccess('Login successfully, wait for a minute...');
            }
            // $username = $request->username;
            // $user = User::where('username', $username)
            //     ->first();
            // // dd($user->id);
            // if (!is_null($user->id)) {
            //     if (Auth::attempt(['id' => $user->id, 'password' => bcrypt($request->password)])) {
            //         return thisSuccess('Login successfully, wait for a minute...');
            //     }
            // }
            return thisError('Login failed, please check username & password again!');
        }
        return thisError('Hmmm access denied');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
