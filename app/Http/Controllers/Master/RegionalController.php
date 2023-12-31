<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Regional;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RegionalController extends Controller
{
    public function index() 
    {
        return view('pages.admin.master.regional.index');
    }

    public function regionalDt(Request $request) 
    {
        $query = Branch::with('regional')->get();

        return DataTables::of($query)
            ->addColumn('regionalID', function($query){
                return $query->regional_id.'|'.$query->regional->regional_name;
            })
            ->addColumn('action', function($query){
                return view('pages.admin.master.regional.components.action', ['id' => $query->id, 'regional_id' => $query->regional_id]);
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function regionalAdd(Request $request) 
    {
        $reg = new Regional();
        $reg->regional_name = $request->regional_name;
        $reg->save();

        if ($reg) {
            return thisSuccess('Berhasil menambah data', null, 201);
        }

        return thisError('Data gagal ditambahkan, periksa kembali form');
    }

    public function regionalEdit($id, Request $request) 
    {
        $reg = Regional::find($id);
        $reg->regional_name = $request->regional_name;
        $reg->save();

        if ($reg) {
            return thisSuccess('Berhasil mengubah data', null, 201);
        }

        return thisError('Data gagal diubah, periksa kembali form');
    }

    public function reqDetail(Request $request)
    {
        $get = $request->q;
        $id = $request->id;
        
        if ($get === 'regional') {
            $query = Regional::find($id);

            return thisSuccess('OK', $query);
        }

        $query = Branch::with('regional')->find($id);

        return thisSuccess('OK', $query);
    }

    public function branchAdd(Request $request) 
    {
        $reg = new Branch();
        $reg->regional_id = $request->regional_id;
        $reg->branch_name = $request->branch_name;
        $reg->branch_type = $request->branch_type;
        $reg->save();

        if ($reg) {
            return thisSuccess('Berhasil menambah data', null, 201);
        }

        return thisError('Data gagal ditambahkan, periksa kembali form');
    }

    public function branchEdit($id, Request $request) 
    {
        $reg = Branch::find($id);
        $reg->regional_id = $request->regional_id;
        $reg->branch_name = $request->branch_name;
        $reg->branch_type = $request->branch_type;
        $reg->save();

        if ($reg) {
            return thisSuccess('Berhasil mengubah data', null, 201);
        }

        return thisError('Data gagal diubah, periksa kembali form');
    }
}
