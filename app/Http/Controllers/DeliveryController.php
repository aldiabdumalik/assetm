<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function index() 
    {
        return view('pages.admin.delivery.index');    
    }

    public function buatPengiriman(Request $request)
    {
        $pengiriman = new Delivery();
        $pengiriman->delivery_branch_id = $request->tujuan;
        $pengiriman->user_id = Auth::user()->id;
        $pengiriman->delivery_no = '';
        $pengiriman->delivery_resi = $request->resi;
        $pengiriman->estimasi = $request->estimasi;
        $pengiriman->save();

        if ($pengiriman) {
            $update = Delivery::find($pengiriman->id);
            $update->delivery_no = str_pad($pengiriman->id, 5, '0', STR_PAD_LEFT).'/'.$request->type.$request->tujuan.'/'.date('m/Y');
            $update->save();
            
            return thisSuccess('Tunggu sebentar Anda akan di arahkan ke halaman tambah packing list', ['redirect' => route('pengiriman.view', [$pengiriman->id])]);
        }

        return thisError('Gagal membuat pengiriman');
    }

    public function pengirimanView($id)
    {
        return false;
    }
}
