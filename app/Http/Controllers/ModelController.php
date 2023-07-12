<?php

namespace App\Http\Controllers;

use App\Models\ItemBrand;
use App\Models\ItemModel;
use App\Models\ItemType;
use Illuminate\Http\Request;

class ModelController extends Controller
{
    public function getJenis(Request $request) {
        if ($request->ajax()) {
            $search = $request->search;

            $type = ItemType::limit(5);

            if (isset($search)) {
                $type->where('type_name', 'LIKE', "%$search%");
            }

            $result = $type->get();

            return thisSuccess('ok', $result, 200);
        }

        return thisError('Hmmm access denied', null, 401);
    }

    public function getMerk(Request $request) {
        if ($request->ajax()) {
            $search = $request->search;

            $brand = ItemBrand::where('item_type_id', $request->type)->limit(5);

            if (isset($search)) {
                $brand->where('brand_name', 'LIKE', "%$search%");
            }

            $result = $brand->get();

            return thisSuccess('ok', $result, 200);
        }

        return thisError('Hmmm access denied', null, 401);
    }

    public function getTipe(Request $request) {
        if ($request->ajax()) {
            $search = $request->search;

            $model = ItemModel::where('item_brand_id', $request->brand)->limit(5);

            if (isset($search)) {
                $model->where('model_name', 'LIKE', "%$search%");
            }

            $result = $model->get();

            return thisSuccess('ok', $result, 200);
        }

        return thisError('Hmmm access denied', null, 401);
    }
}
