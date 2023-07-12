<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArrivalRequest;
use App\Models\ArrivalItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

use function PHPUnit\Framework\isNull;

class ArrivalItemController extends Controller
{
    public function index() {
        return view('pages.admin.igi.index');
    }

    public function itemData(Request $request) {
        $query = ArrivalItem::with('branch.regional', 'user', 'scanningItem');
        if (isset($request->id)) {
            $query = $query->where('id', $request->id)->first();
        }

        if (!empty($query)) {
            return thisSuccess('data ditemukan', $query, 200);
        }

        return thisSuccess('data tidak ditemukan', null, 204);
    }

    public function itemDataDt(Request $request) {
        $query = ArrivalItem::with('branch.regional', 'user', 'scanningItem')->get();

        return DataTables::of($query)
            ->addColumn('grouping', function($query){
                return $query->branch->branch_name.'|'.$query->branch->regional->regional_name;
            })
            ->editColumn('arrival_date', function($query){
                return date('d/m/Y', strtotime($query->arrival_date));
            })
            ->addColumn('surat_jalan', function($query){
                return 'N/A';
            })
            ->addColumn('action', function($query){
                return view('pages.admin.igi.components.action', ['id' => $query->id]);
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function addItem(ArrivalRequest $request) 
    {
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

    public function editItem($id, ArrivalRequest $request) 
    {
        if (isset($id)) {
            $update = ArrivalItem::find($id);
            $update->user_id = Auth::user()->id;
            $update->branch_id = $request->branch_id;
            $update->regional_desc = $request->regional_desc;
            $update->branch_desc = $request->branch_desc;
            $update->delivery_pic = $request->delivery_pic;
            $update->no_po = $request->no_po;
            $update->user_pic = $request->user_pic;
            $update->arrival_date = $request->arrival_date;
            $update->arrival_total = $request->arrival_total;
            $update->arrival_note = $request->arrival_note;
            $update->save();

            if ($update) {
                return thisSuccess('Berhasil mengupdate data', null, 201);
            }

            return thisError('Data gagal diubah, periksa kembali form');
        }

        return thisError('Data gagal diubah, periksa kembali form');
    }
}
