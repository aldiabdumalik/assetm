<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScanningRequest;
use App\Models\ItemType;
use App\Models\ScanningItem;
use Illuminate\Http\Request;

class ScanningController extends Controller
{
    public function index($id) 
    {
        return view('pages.admin.scanning.index', ['id' => $id]);
    }

    public function scanItem($id, ScanningRequest $request) 
    {
        if (isset($id)) {
            $scan = new ScanningItem();
            $scan->user_id = $request->user_id;
            $scan->arrival_item_id = $request->arrival_item_id;
            $scan->model_id = $request->model_id;
            $scan->scan_box = $request->scan_box;
            $scan->scan_sn = $request->scan_sn;
            $scan->scan_mac = $request->scan_mac;

            $scan->save();

            if ($scan) {
                return thisSuccess('Berhasil menambah data', null, 201);
            }
    
            return thisError('Data gagal ditambahkan, periksa kembali form');
        }

        return thisError('Data gagal ditambahkan, periksa kembali form');
    }

    public function scanItemCancel($id) 
    {
        if (isset($id)) {
            $scan = ScanningItem::find($id);

            $scan->delete();

            if ($scan) {
                return thisSuccess('Berhasil menghapus data', null, 200);
            }
    
            return thisError('Data gagal dihapus');
        }

        return thisError('Data gagal dihapus');
    }

}
