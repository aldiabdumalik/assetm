<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScanningRequest;
use App\Models\ArrivalItem;
use App\Models\ItemType;
use App\Models\ScanningItem;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class ScanningController extends Controller
{
    public function index($id) 
    {
        if (!isset($id)) {
            return redirect('/arrival_item');
        }
        $arrival = ArrivalItem::with('branch.regional')->where('id', $id)->first();
        $user_id = Auth::user()->id;
        $userInfo = UserInfo::with('branch.regional')->where('user_id', $user_id)->first();
        return view('pages.admin.scanning.index', [
            'id' => $id, 
            'data' => $arrival,
            'user' => $userInfo,
        ]);
    }

    public function scanDt(Request $request) 
    {
        $query = ScanningItem::with('user', 'arrivalItem', 'itemModel.itemBrand.itemType')
            ->where('status', $request->status)
            ->where('arrival_item_id', $request->id)
            ->get();
        return DataTables::of($query)
            ->editColumn('scan_time', function($query){
                return date('d/m/Y H:i:s', strtotime($query->created_at));
            })
            ->addColumn('jenis', function($query){
                return $query->itemModel->itemBrand->itemType->type_name;
            })
            ->addColumn('merk', function($query){
                return $query->itemModel->itemBrand->brand_name;
            })
            ->addColumn('tipe', function($query){
                return $query->itemModel->model_name;
            })
            ->addColumn('action', function($query){
                return view('pages.admin.scanning.components.action', ['id' => $query->id]);
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);

        // return $query->isNotEmpty();
    }

    public function scanItem($id, ScanningRequest $request) 
    {
        if (isset($id)) {
            $scan = new ScanningItem();
            $scan->user_id = Auth::user()->id;
            $scan->arrival_item_id = $id;
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

    public function updateStatus()
    {
        $query = ScanningItem::where('status', 0)
            ->where('user_id', Auth::user()->id)
            ->update([
                'status' => 1
            ]);

        return redirect('/arrival_item');
    }

}
