<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\ItemBrand;
use App\Models\ItemModel;
use App\Models\ItemType;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ModelController extends Controller
{
    public function index()
    {
        return view('pages.admin.master.item.index');    
    }

    public function itemDt(Request $request)
    {
        $query = ItemModel::with('itemBrand.itemType')->get();
        return DataTables::of($query)
            ->addColumn('merk', function($query) {
                return $query->itemBrand->brand_name;
            })
            ->addColumn('tipe', function($query) {
                return $query->itemBrand->itemType->type_name;
            })
            ->addColumn('action', function($query){
                return view('pages.admin.master.user.components.action', ['id' => $query->id]);
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function modelAdd(Request $request)
    {
        $item = new ItemModel();
        $item->item_brand_id = $request->brand_id;
        $item->model_name = $request->model_name;
        $item->save();

        if ($item) {
            return thisSuccess('Berhasil menambah data');
        }

        return thisError('Gagal menambah data');
    }

    public function brandAdd(Request $request)
    {
        $item = new ItemBrand();
        $item->item_type_id = $request->type_id;
        $item->brand_name = $request->brand_name;
        $item->save();

        if ($item) {
            return thisSuccess('Berhasil menambah data');
        }

        return thisError('Gagal menambah data');
    }

    public function typeAdd(Request $request)
    {
        $item = new ItemType();
        $item->type_name = $request->type_name;
        $item->save();

        if ($item) {
            return thisSuccess('Berhasil menambah data');
        }

        return thisError('Gagal menambah data');
    }
}
