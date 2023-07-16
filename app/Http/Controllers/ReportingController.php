<?php

namespace App\Http\Controllers;

use App\Exports\DeliveriesExport;
use App\Exports\PackingListsExport;
use App\Exports\ScanningsExport;
use App\Exports\TestingsExport;
use App\Models\Delivery;
use App\Models\PackingList;
use App\Models\ScanningItem;
use App\Models\TestingItem;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class ReportingController extends Controller
{
    public function index()
    {
        $user = UserInfo::with('branch.regional')->where('user_id', Auth::user()->id)->first();
        return view('pages.admin.report.index', compact('user'));    
    }

    public function download(Request $request)
    {
        $user_id = Auth::user()->id;
        $userInfo = UserInfo::where('user_id', $user_id)->first();
        $q = $request->q;
        $start = $request->start;
        $end = $request->end;

        if ($q == 'igi') {
            return $this->igi($start, $end, $userInfo->branch_id);
        }

        if ($q == 'uji_fungsi') {
            return $this->uji_fungsi($start, $end, $userInfo->branch_id);
        }

        if ($q == 'packing_list') {
            return $this->packing_list($start, $end, $userInfo->branch_id);
        }

        if ($q == 'pengiriman') {
            return $this->pengiriman($start, $end, $userInfo->branch_id);
        }

        return redirect('/reporting')->with("errorMsg", "Data tidak ditemukan");
    }

    private function igi($start, $end, $branch_id)
    {
        $query = ScanningItem::with(['arrivalItem', 'user.userInfo', 'itemModel.itemBrand.itemType'])
            ->whereRelation('user.userInfo', 'branch_id', '=', $branch_id);
        if (isset($start)) {
            $query = $query->whereDate('created_at', '>=', $start);
        }
        if (isset($end)) {
            $query = $query->whereDate('created_at', '<=', $end);
        }

        $query = $query->get();
        if ($query->isNotEmpty()) {
            $data = [];

            foreach ($query as $val) {
                $data[] = [
                    'barcode' => $val->scan_sn,
                    'mac' => $val->scan_mac,
                    'jenis' => $val->itemModel->itemBrand->itemType->type_name,
                    'merk' => $val->itemModel->itemBrand->brand_name,
                    'tipe' => $val->itemModel->model_name,
                    'scan_time' => date('d/m/Y', strtotime($val->created_at)),
                    'scan_by' => $val->user->username,
                    'regional' => $val->arrivalItem->regional_desc,
                    'branch' => $val->arrivalItem->branch_desc,
                    'id_igi' => $val->arrivalItem->id
                ];
            }

            $data = collect($data);
            $name = 'REPORTING_IGI_TGL_'.date('d_m_Y');
            return Excel::download(new ScanningsExport($data), $name . '.xlsx');
        }

        return redirect('/reporting')->with("errorMsg", "Data tidak ditemukan");
    }

    private function uji_fungsi($start, $end, $branch_id)
    {
        $query = TestingItem::with(['user.userInfo', 'itemModel.itemBrand.itemType', 'scanningItem.arrivalItem'])
            ->whereRelation('user.userInfo', 'branch_id', '=', $branch_id);
        if (isset($start)) {
            $query = $query->whereDate('created_at', '>=', $start);
        }
        if (isset($end)) {
            $query = $query->whereDate('created_at', '<=', $end);
        }

        $query = $query->get();
        // return $query;
        if ($query->isNotEmpty()) {
            $data = [];

            foreach ($query as $val) {
                $data[] = [
                    'barcode' => $val->scanningItem->scan_sn,
                    'mac' => $val->scanningItem->scan_mac,
                    'jenis' => $val->itemModel->itemBrand->itemType->type_name,
                    'merk' => $val->itemModel->itemBrand->brand_name,
                    'tipe' => $val->itemModel->model_name,
                    'status' => $val->status == 0 ? 'NOK':'OK',
                    'scan_time' => date('d/m/Y', strtotime($val->created_at)),
                    'scan_by' => $val->user->username,
                    // 'regional' => $val->arrivalItem->regional_desc,
                    // 'branch' => $val->arrivalItem->branch_desc,
                    'id_igi' => $val->scanningItem->arrivalItem->id
                ];
            }


            // return $data;

            $data = collect($data);
            $name = 'REPORTING_UJI_FUNGSI_TGL_'.date('d_m_Y');
            return Excel::download(new TestingsExport($data), $name . '.xlsx');
        }

        return redirect('/reporting')->with("errorMsg", "Data tidak ditemukan");
    }

    private function packing_list($start, $end, $branch_id)
    {
        $query = PackingList::with(['user.userInfo', 'packingListItem'])
            ->whereRelation('user.userInfo', 'branch_id', '=', $branch_id);
        if (isset($start)) {
            $query = $query->whereDate('created_at', '>=', $start);
        }
        if (isset($end)) {
            $query = $query->whereDate('created_at', '<=', $end);
        }

        $query = $query->get();
        // return $query;
        if ($query->isNotEmpty()) {
            $data = [];
            $status = '';

            foreach ($query as $val) {
                if ($val->pl_status == 0) {
                    $status = 'Belum masuk pengiriman';
                }

                if ($val->pl_status == 1) {
                    $status= 'Belum dikirim';
                }

                if ($val->pl_status == 2) {
                    $status= 'Sudah dikirim';
                }

                $data[] = [
                    'code' => $val->pl_code,
                    'jenis' => $val->pl_type == 'service_handling' ? 'Service Handling' : ucwords($val->pl_type),
                    'jumlah' => $val->packingListItem->count(),
                    'status' => $status,
                    'scan_time' => date('d/m/Y', strtotime($val->created_at)),
                    'scan_by' => $val->user->username,
                ];
            }


            // return $data;

            $data = collect($data);
            $name = 'REPORTING_PACKING_LIST_TGL_'.date('d_m_Y');
            return Excel::download(new PackingListsExport($data), $name . '.xlsx');
        }

        return redirect('/reporting')->with("errorMsg", "Data tidak ditemukan");
    }

    private function pengiriman($start, $end, $branch_id)
    {
        $query = Delivery::with(['packingList', 'branchDelivery', 'deliveryItem', 'user.userInfo'])
            ->whereRelation('user.userInfo', 'branch_id', '=', $branch_id);
        if (isset($start)) {
            $query = $query->whereDate('created_at', '>=', $start);
        }
        if (isset($end)) {
            $query = $query->whereDate('created_at', '<=', $end);
        }

        $query = $query->get();
        // return $query;
        if ($query->isNotEmpty()) {
            $data = [];
            $status = '';

            foreach ($query as $val) {

                if ($val->status == 1) {
                    $status= 'Belum dikirim';
                }

                if ($val->status == 1) {
                    $status= 'Sudah dikirim';
                }

                $data[] = [
                    'code' => $val->delivery_no,
                    'resi' => $val->delivery_resi,
                    'jumlah' => $val->packingList->count(),
                    'status' => $status,
                    'estimasi' => date('d/m/Y', strtotime($val->estimasi)),
                    'scan_time' => date('d/m/Y', strtotime($val->created_at)),
                    'scan_by' => $val->user->username,
                ];
            }


            // return $data;

            $data = collect($data);
            $name = 'REPORTING_PENGIRIMAN_TGL_'.date('d_m_Y');
            return Excel::download(new DeliveriesExport($data), $name . '.xlsx');
        }

        return redirect('/reporting')->with("errorMsg", "Data tidak ditemukan");
    }
}
