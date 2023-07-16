<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\DeliveryItem;
use App\Models\PackingList;
use App\Models\PackingListItem;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DeliveryController extends Controller
{
    public function index() 
    {
        return view('pages.admin.delivery.index');    
    }

    public function deliveryDt(Request $request) 
    {
        $query = Delivery::with(['packingList', 'branchDelivery', 'deliveryItem'])
            ->get();
        // $chek = DeliveryItem::where('delivery_id', )
        // return $query;
        return DataTables::of($query)
            ->addColumn('jml_pl', function($query){
                return $query->packingList->count();
            })
            ->addColumn('status_string', function($query){
                $status = $query->status == 0 ? 'Belum dikirim':'Sudah dikirim';
                $warna = $query->status == 0 ? 'badge-danger':'badge-success';
                return view('pages.admin.delivery.components.badge', compact('status', 'warna'));
            })
            ->addColumn('tujuan', function($query){
                return $query->branchDelivery->branch_type.' '.$query->branchDelivery->branch_name;
            })
            ->addColumn('action', function($query){
                return view('pages.admin.delivery.components.action', [
                    'id' => $query->id,
                    'status' => $query->status
                ]);
            })
            ->rawColumns(['action', 'status_string'])
            ->addIndexColumn()
            ->make(true);
    }

    public function deliveryDetail($id) 
    {
        $query = Delivery::with(['packingList', 'branchDelivery', 'deliveryItem'])
            ->find($id);

        return thisSuccess('OK', $query);
    }

    public function buatPengiriman(Request $request)
    {
        $pengiriman = new Delivery();
        $pengiriman->delivery_branch_id = $request->tujuan;
        $pengiriman->user_id = Auth::user()->id;
        $pengiriman->delivery_no = '';
        $pengiriman->delivery_resi = $request->resi;
        $pengiriman->estimasi = $request->estimasi;
        $pengiriman->save();

        if ($pengiriman) {
            $update = Delivery::find($pengiriman->id);
            $update->delivery_no = str_pad($pengiriman->id, 5, '0', STR_PAD_LEFT).'/'.$request->type.$request->tujuan.'/'.date('m/Y');
            $update->save();

            return thisSuccess('Tunggu sebentar Anda akan di arahkan ke halaman tambah packing list', ['redirect' => route('pengiriman.view', [$pengiriman->id])]);
        }

        return thisError('Gagal membuat pengiriman');
    }

    public function pengirimanView($id)
    {
        $query = Delivery::with('branchDelivery')->find($id);
        $user = UserInfo::with('branch.regional')->where('user_id', Auth::user()->id)->first();
        // return $user;
        return view('pages.admin.delivery.view', [
            'user_branch' => $user->branch->branch_name,
            'user_regional' => $user->branch->regional->regional_name,
            'data' => $query
        ]);
    }

    public function belumDt(Request $request)
    {
        $user = UserInfo::with('branch')->where('user_id', Auth::user()->id)->first();
        $query = PackingList::with('packingListItem')
            ->has('packingListItem')
            ->where('pl_status', 0)
            ->where('branch_id', $user->branch_id)
            ->get();
        return DataTables::of($query)
            ->addColumn('jml_item', function($query){
                return $query->packingListItem->count();
            })
            ->addColumn('jenis', function($query){
                return $query->pl_type == 'service_handling' ? 'Service Handling' : ucwords($query->pl_type);
            })
            ->addColumn('action', function($query){
                return view('pages.admin.delivery.components.add', ['id' => $query->id]);
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);    
    }

    public function doneDt($id, Request $request)
    {
        // $user = UserInfo::with('branch')->where('user_id', Auth::user()->id)->first();
        $query = PackingList::with(['delivery', 'packingListItem'])
            ->whereRelation('delivery', 'deliveries.id', $id)
            ->get();
        // return $query;
        return DataTables::of($query)
            ->addColumn('jml_item', function($query){
                return $query->packingListItem->count();
            })
            ->addColumn('jenis', function($query){
                return $query->pl_type == 'service_handling' ? 'Service Handling' : ucwords($query->pl_type);
            })
            ->addColumn('action', function($query){
                return view('pages.admin.delivery.components.del', ['id' => $query->id]);
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);    
    }

    public function addPl($id, Request $request)
    {
        $packing = PackingList::find($id);
        $packing->pl_status = 1;
        $packing->save();

        if ($packing) {
            $items = PackingListItem::where('packing_list_id', $id)
                ->update([
                    'delivery_status' => 1
                ]);

            if ($items) {
                $delivery = new DeliveryItem();

                $delivery->user_id = Auth::user()->id;
                $delivery->delivery_id = $request->delivery_id;
                $delivery->packing_list_id = $id;
                $delivery->save();

                return thisSuccess('OK');
            }

        }

        return thisError('Gagal menambah PL');
    }

    public function delPl($id, Request $request)
    {
        $packing = PackingList::find($id);
        $packing->pl_status = 0;
        $packing->save();

        if ($packing) {
            $items = PackingListItem::where('packing_list_id', $id)
                ->update([
                    'delivery_status' => 0
                ]);
            
            $delivery = DeliveryItem::where('delivery_id', $request->delivery_id)->delete();
            // $delivery->delete();

            return thisSuccess('OK');
        }

        return thisError('Gagal membatalkan PL');
    }

    public function sendPl($id)
    {

    }
}
