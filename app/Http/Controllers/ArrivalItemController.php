<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArrivalRequest;
use App\Models\ArrivalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArrivalItemController extends Controller
{
    public function index() {
        return view('pages.admin.igi.index');
    }

    public function itemData(Request $request) {
        
    }

    public function addItem(ArrivalRequest $request) {
        
        $create = new ArrivalItem();
        $create->user_id = Auth::user()->id;
        $create->branch_id = $request->branch_id;
        $create->regional_desc = $request->regional_desc;
        $create->branch_desc = $request->branch_desc;
        $create->delivery_pic = $request->delivery_pic;
        $create->no_po = $request->no_po;
        $create->user_pic = $request->user_pic;
        $create->arrival_date = $request->arrival_date;
        $create->arrival_total = $request->arrival_total;
        $create->arrival_note = $request->arrival_note;
        $create->save();

        if ($create) {
            return thisSuccess('Berhasil menambah data', null, 201);
        }

        return thisError('Data gagal ditambahkan, periksa kembali form');
    }
}
