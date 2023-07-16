<?php

namespace App\Http\Controllers;

use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportingController extends Controller
{
    public function index()
    {
        $user = UserInfo::with('branch.regional')->where('user_id', Auth::user()->id)->first();
        return view('pages.admin.report.index', compact('user'));    
    }
}
