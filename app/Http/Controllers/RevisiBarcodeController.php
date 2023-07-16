<?php

namespace App\Http\Controllers;

use App\Models\ItemModel;
use App\Models\PackingListItem;
use App\Models\ScanningItem;
use App\Models\TestingItem;
use Illuminate\Http\Request;

class RevisiBarcodeController extends Controller
{
    public function index()
    {
        return view('pages.admin.revisi.index');    
    }

    public function detail(Request $request)
    {
        $query = ScanningItem::with(['user.userInfo', 'ujiFungsi', 'packingListItem', 'itemModel.itemBrand.itemType'])
            ->where('scan_sn', $request->barcode)
            ->first();

        if (!$query) {
            return thisError('Data tidak ditemukan');
        }

        return thisSuccess('OK', $query);
    }

    public function update(Request $request)
    {
        $barcode = $request->barcode;
        $model_id = $request->model_id;
        
        $itemModel = ItemModel::with('itemBrand.itemType')->find($model_id);

        $scanning = ScanningItem::where('scan_sn', $barcode)->update([
            'model_id' => $model_id
        ]);

        $testing = TestingItem::where('barcode', $barcode)->update([
            'type_id' => $itemModel->itemBrand->item_type_id,
            'model_id' => $model_id,
            'type_desc' => $itemModel->itemBrand->itemType->type_name,
            'brand_desc' => $itemModel->itemBrand->brand_name,
            'model_desc' => $itemModel->model_name,
        ]);

        $pl = PackingListItem::where('barcode', $barcode)->update([
            'model_id' => $model_id
        ]);

        return thisSuccess('Berhasil update item');
    }
}
