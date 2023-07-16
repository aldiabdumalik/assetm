<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\PackingList;
use App\Models\ScanningItem;
use App\Models\TestingItem;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() 
    {
        $user = UserInfo::with('branch')->where('user_id', Auth::user()->id)->first();
        $total_item = ScanningItem::count();
        $total_ok = TestingItem::where('status', 1)->count();
        $total_pl = PackingList::count();
        $total_pengiriman = Delivery::where('status', 1)->count();
        return view('pages.admin.dashboard', compact('total_item', 'total_ok', 'total_pl', 'total_pengiriman'));
    }
}
