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

    public function itemDetail(Request $request)
    {
        $get = $request->q;
        $id = $request->id;
        $query = null;
        if ($get === 'model') {
            $query = ItemModel::with('itemBrand.itemType')->find($id);
        }

        if ($get === 'brand') {
            $query = ItemBrand::with('itemType')->find($id);
        }

        if ($get === 'type') {
            $query = ItemBrand::find($id);
        }

        return thisSuccess('OK', $query);
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

    public function modelEdit($id, Request $request)
    {
        $item = ItemModel::find($id);
        $item->item_brand_id = $request->brand_id;
        $item->model_name = $request->model_name;
        $item->save();

        if ($item) {
            return thisSuccess('Berhasil mengubah data');
        }

        return thisError('Gagal mengubah data');
    }

    public function modelDelete($id, Request $request)
    {
        $item = ItemModel::find($id);
        $item->delete();

        if ($item) {
            return thisSuccess('Berhasil menghapus data');
        }

        return thisError('Gagal menghapus data');
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

    public function brandEdit($id, Request $request)
    {
        $item = ItemBrand::find($id);
        $item->item_type_id = $request->type_id;
        $item->brand_name = $request->brand_name;
        $item->save();

        if ($item) {
            return thisSuccess('Berhasil mengubah data');
        }

        return thisError('Gagal mengubah data');
    }

    public function brandDelete($id, Request $request)
    {
        $item = ItemBrand::find($id);
        $item->delete();

        if ($item) {
            return thisSuccess('Berhasil menghapus data');
        }

        return thisError('Gagal menghapus data');
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

    public function typeEdit($id, Request $request)
    {
        $item = ItemType::find($id);
        $item->type_name = $request->type_name;
        $item->save();

        if ($item) {
            return thisSuccess('Berhasil mengubah data');
        }

        return thisError('Gagal mengubah data');
    }

    public function typeDelete($id, Request $request)
    {
        $item = ItemType::find($id);
        $item->delete();

        if ($item) {
            return thisSuccess('Berhasil menghapus data');
        }

        return thisError('Gagal menghapus data');
    }
}
