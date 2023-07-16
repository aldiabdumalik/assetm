<?php

namespace App\Http\Controllers;

use App\Models\PackingList;
use App\Models\PackingListItem;
use App\Models\TestingItem;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PackingListController extends Controller
{
    public function index() 
    {
        return view('pages.admin.packing.index');
    }

    public function packingDetail(Request $request)
    {
        $query = PackingList::find($request->id);

        return thisSuccess('OK', $query);
    }

    public function packingDt(Request $request)
    {
        $user = UserInfo::with('branch')->where('user_id', Auth::user()->id)->first();
        $query = PackingList::with('packingListItem')->where('branch_id', $user->branch_id)->get();
        return DataTables::of($query)
            ->addColumn('jml_item', function($query){
                return 0;
            })
            ->addColumn('jenis', function($query){
                return $query->pl_type == 'service_handling' ? 'Service Handling' : ucwords($query->pl_type);
            })
            ->addColumn('proses', function($query){
                $status = '';
                $warna = '';
                if ($query->pl_status == 0) {
                    $status = 'Belum masuk pengiriman';
                    $warna = 'badge-info';
                }

                if ($query->pl_status == 1) {
                    $status= 'Belum dikirim';
                    $warna = 'badge-danger';
                }

                if ($query->pl_status == 2) {
                    $status= 'Sudah dikirim';
                    $warna = 'badge-success';
                }

                return view('pages.admin.packing.components.badge', compact('status', 'warna'));
            })
            ->addColumn('action', function($query){
                return view('pages.admin.packing.components.action', ['id' => $query->id, 'status' => $query->pl_status]);
            })
            ->rawColumns(['action', 'proses'])
            ->addIndexColumn()
            ->make(true);
    }

    public function packingAdd(Request $request) 
    {
        $user = UserInfo::with('branch')->where('user_id', Auth::user()->id)->first();
        $packing = new PackingList();
        $packing->user_id = Auth::user()->id;
        $packing->regional_id = $user->branch->regional_id;
        $packing->branch_id = $user->branch->id;
        $packing->pl_type = $request->pl_type;
        $packing->save();

        if ($packing) {
            $update = PackingList::find($packing->id);
            $update->pl_code = 'PL'.date('ymdhis');
            $update->save();

            return thisSuccess('Berhasil menambah data', null, 201);
        }

        return thisError('Data gagal ditambahkan, periksa kembali form');
    }

    public function packingEdit($id, Request $request) 
    {
        $user = UserInfo::with('branch')->where('user_id', Auth::user()->id)->first();
        $packing = PackingList::find($id);
        $packing->user_id = Auth::user()->id;
        $packing->regional_id = $user->branch->regional_id;
        $packing->branch_id = $user->branch->id;
        $packing->pl_type = $request->pl_type;
        $packing->save();

        if ($packing) {
            return thisSuccess('Berhasil mengubah data', null, 201);
        }

        return thisError('Data gagal diubah, periksa kembali form');
    }

    public function packingDelete($id) 
    {
        $query = PackingList::find($id);
        if ($query->pl_status == 0) {
            $query->delete();

            if ($query) {
                // $delete= 
            }

            return thisSuccess('Data berhasil dihapus');
        }

        return thisError('Data gagal dihapus');
    }

    public function scanView($id)
    {
        $query = PackingList::with('branch.regional', 'packingListItem')->find($id);
        return view('pages.admin.packing.scan', ['id' => $id, 'data' => $query]);
    }

    public function scanAdd($id, Request $request)
    {
        $get = PackingList::with('branch', 'packingListItem')->find($id);

        if (empty($get)) {
            return thisError('Data tidak ditemukan');
        }

        $valid = TestingItem::where('barcode', $request->barcode)
            ->first();

        if (empty($valid)) {
            return thisError('Data tidak ditemukan');
        }

        if (!empty($valid) && $valid->status == 0) {
            return thisError('Status item yang Anda scan NOK');
        }

        $check = PackingListItem::where('barcode', $request->barcode)->first();

        if (!empty($check)) {
            return thisError('Item sudah terscan');
        }
        
        $scan = new PackingListItem();
        $scan->barcode = $request->barcode;
        $scan->user_id = Auth::user()->id;
        $scan->regional_id = $get->branch->regional_id;
        $scan->model_id = $valid->model_id;
        $scan->mac = $request->barcode;
        $scan->packing_list_id = $id;
        $scan->save();

        if ($scan) {
            return thisSuccess('Berhasil menambah data', null, 201);
        }

        return thisError('Data gagal ditambahkan, periksa kembali form');
    }

    public function scanDt($id, Request $request)
    {
        $query = PackingListItem::with(['itemModel.itemBrand.itemType', 'user', 'packingList'])->where('packing_list_id', $id)->get();
        // return $query;
        return DataTables::of($query)
            ->addColumn('jenis', function($query){
                return $query->itemModel->itemBrand->itemType->type_name;
            })
            ->addColumn('merk', function($query){
                return $query->itemModel->itemBrand->brand_name;
            })
            ->addColumn('tipe', function($query){
                return $query->itemModel->model_name;
            })
            ->addColumn('scan_time', function($query){
                return date('d/m/Y H:i:s', strtotime($query->created_at));
            })
            ->addColumn('action', function($query){
                return $query->packingList->pl_status == 0 ? view('pages.admin.packing.components.btn', ['id' => $query->id]) : '';
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }
    public function scanDel($id)
    {
        $item = PackingListItem::with(['packingList'])->find($id);

        if ($item->packingList->pl_status !== 0) {
            return thisError('Item tidak dapat dihapus');
        }

        $item->delete();
        
        return thisSuccess('Item berhasil dihapus');
    }
}
