<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Regional;
use Illuminate\Http\Request;

class RegionalController extends Controller
{
    public function index() {
        
    }

    public function getRegional(Request $request) {
        if ($request->ajax()) {
            $search = $request->search;

            $regional = Regional::limit(5);

            if (isset($search)) {
                $regional->where('regional_name', 'LIKE', "%$search%");
            }

            $result = $regional->get();

            return thisSuccess('ok', $result, 200);
        }

        return thisError('Hmmm access denied', null, 401);
    }

    public function getBranch(Request $request) {
        if ($request->ajax()) {
            $search = $request->search;

            $branch = Branch::where('regional_id', $request->regional)->limit(5);

            if (isset($search)) {
                $branch->where('branch_name', 'LIKE', "%$search%");
            }

            $result = $branch->get();

            return thisSuccess('ok', $result, 200);
        }

        return thisError('Hmmm access denied', null, 401);
    }
}
