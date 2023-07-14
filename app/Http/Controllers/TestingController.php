<?php

namespace App\Http\Controllers;

use App\Http\Requests\UjiFungsiRequest;
use App\Models\ScanningItem;
use App\Models\TestingItem;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TestingController extends Controller
{

    public function index()
    {
        $user = UserInfo::with('branch')->where('user_id', Auth::user()->id)->first();
        return view('pages.admin.uji_fungsi.index', ['branch' => $user->branch->branch_name]);
    }

    function scanDetail()
    {
        $user = UserInfo::with('branch')->where('user_id', Auth::user()->id)->first();
        return view('pages.admin.uji_fungsi.scan_view', ['branch' => $user->branch->branch_name]);
    }

    public function testingDtGroup()
    {
        $user = UserInfo::with('branch')->where('user_id', Auth::user()->id)->first();
        $query = DB::table('testing_items', 't1')
            ->leftJoin('item_types as t2', 't2.id', '=', 't1.type_id')
            ->leftJoin('regionals as t4', 't4.id', '=', 't1.regional_id')
            ->leftJoin('user_infos as t5', 't5.user_id', '=', 't1.user_id')
            ->selectRaw('t1.*, t2.type_name, t4.regional_name')
            ->selectRaw('
                SUM(
                    CASE
                    WHEN t1.status = 1 THEN 1
                    ELSE 0
                    END
                ) AS status_1_count,
                SUM(
                    CASE
                    WHEN t1.status = 0 THEN 1
                    ELSE 0
                    END
                ) AS status_0_count
            ')
            ->where('t1.status_scan', 1)
            ->where('t5.branch_id', $user->branch_id)
            ->groupBy('t1.type_id')
            ->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->make(true);
    }

    public function scan() 
    {
        $user = UserInfo::with('branch')->where('user_id', Auth::user()->id)->first();
        return view('pages.admin.uji_fungsi.scan', ['branch' => $user->branch->branch_name]);    
    }

    public function scanItem(UjiFungsiRequest $request) 
    {
        $query = ScanningItem::with('arrivalItem.branch', 'itemModel.itemBrand.itemType')
            ->where('scan_sn', $request->barcode)
            ->where('status', 1)
            ->first();
        if (empty($query)) {
            return thisError('Item tidak ditemukan');
        }

        $check = TestingItem::where('barcode', $request->barcode)->first();

        if (!empty($check)) {
            return thisError('Item sudah di scan');
        }

        $scan = new TestingItem();
        $scan->user_id = Auth::user()->id;
        $scan->regional_id = $query->arrivalItem->branch->regional_id;
        $scan->type_id = $query->itemModel->itemBrand->itemType->id;
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

    public function sumDt(Request $request)
    {
        $query = TestingItem::with('itemType')
            ->groupBy('type_id')
            ->get();

        return $query;
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
