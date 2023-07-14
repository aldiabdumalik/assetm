<?php

namespace App\Http\Controllers;

use App\Models\PackingList;
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
        $query = PackingList::where('branch_id', $user->branch_id)->get();
        return DataTables::of($query)
            ->addColumn('jml_item', function($query){
                return 0;
            })
            ->addColumn('proses', function($query){
                if ($query->pl_status == 0) {
                    return 'Belum masuk pengiriman';
                }

                if ($query->pl_status == 1) {
                    return 'Belum dikirim';
                }

                if ($query->pl_status == 2) {
                    return 'Sudah dikirim';
                }

                return $query->pl_status;
            })
            ->addColumn('action', function($query){
                return view('pages.admin.packing.components.action', ['id' => $query->id, 'status' => $query->pl_status]);
            })
            ->rawColumns(['action'])
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
}
