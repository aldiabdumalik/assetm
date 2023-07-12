<?php

namespace App\Http\Controllers;

use App\Http\Requests\UjiFungsiRequest;
use App\Models\ScanningItem;
use App\Models\TestingItem;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class TestingController extends Controller
{

    public function index()
    {
        $user = UserInfo::with('branch')->where('user_id', Auth::user()->id)->first();
        return view('pages.admin.uji_fungsi.index', ['branch' => $user->branch->branch_name]);
    }

    public function scan() 
    {
        $user = UserInfo::with('branch')->where('user_id', Auth::user()->id)->first();
        return view('pages.admin.uji_fungsi.scan', ['branch' => $user->branch->branch_name]);    
    }

    public function scanItem(UjiFungsiRequest $request) 
    {
        $query = ScanningItem::with('itemModel.itemBrand.itemType')
            ->where('scan_sn', $request->barcode)
            ->first();
        if (empty($query)) {
            return thisError('Item tidak ada');
        }

        $check = TestingItem::where('barcode', $request->barcode)->first();

        if (!empty($check)) {
            return thisError('Item sudah di scan');
        }

        $scan = new TestingItem();
        $scan->user_id = Auth::user()->id;
        $scan->model_id = $query->model_id;
        $scan->barcode = $request->barcode;
        $scan->status = $request->status;
        $scan->box_ok = $request->box_ok;
        $scan->box_nok = $request->box_nok;
        $scan->type_desc = $query->itemModel->itemBrand->itemType->type_name;
        $scan->brand_desc = $query->itemModel->itemBrand->brand_name;
        $scan->model_desc = $query->itemModel->model_name;
        $scan->status_scan = 0;

        $scan->save();

        if ($scan) {
            return thisSuccess('Berhasil menambah data', null, 201);
        }

        return thisError('Data gagal ditambahkan, periksa kembali form');
    }

    public function testingDt(Request $request) 
    {
        $query = TestingItem::where('status_scan', $request->status_scan)->get();
        return DataTables::of($query)
            ->editColumn('scan_time', function($query){
                return date('d/m/Y H:i:s', strtotime($query->created_at));
            })
            ->addColumn('result', function($query){
                return view('pages.admin.uji_fungsi.components.badge', ['status' => $query->status]);
            })
            ->addColumn('action', function($query){
                return view('pages.admin.uji_fungsi.components.action', ['id' => $query->id]);
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function scanCancel($id) 
    {
        if (isset($id)) {
            $scan = TestingItem::find($id);

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
        $query = TestingItem::where('status_scan', 0)
            ->where('user_id', Auth::user()->id)
            ->update([
                'status_scan' => 1
            ]);

        return redirect('/uji_fungsi');
    }
}
