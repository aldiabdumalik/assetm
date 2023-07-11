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
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return thisSuccess('Login successfully, wait for a minute...');
            }
            return thisError('Login failed, please check email & password again!');
        }
        return thisError('Hmmm access denied');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
