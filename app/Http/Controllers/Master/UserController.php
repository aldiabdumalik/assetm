<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetPasswordRequest;
use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Models\UserInfo;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('pages.admin.master.user.index');
    }

    public function userDt(Request $request)
    {
        $query = User::with('userInfo.branch.regional')->get();

        return DataTables::of($query)
            ->addColumn('wilayah', function($query){
                return $query->userInfo->branch->branch_name;
            })
            ->addColumn('reg', function($query){
                return $query->userInfo->branch->regional->regional_name;
            })
            ->addColumn('level', function($query){
                return $query->level == 1 ? 'Admin' : 'Staff';
            })
            ->addColumn('action', function($query){
                return view('pages.admin.master.user.components.action', ['id' => $query->id]);
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
    }

    public function userAdd(UserRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->photo = 'default.jpg';
        $user->level = $request->level;
        $user->save();

        if ($user) {
            $info = new UserInfo();
            $info->user_id = $user->id;
            $info->branch_id = $request->branch_id;
            $info->save();

            if ($info) {
                return thisSuccess('Berhasil menambah data');
            }

            return thisError('Gagal menambah data');
        }
        return thisError('Gagal menambah data');
    }

    public function userSetPassword($id, SetPasswordRequest $request)
    {
        $user = User::find($id);
        $user->password = bcrypt($request->password);
        $user->save();

        if ($user) {
            return thisSuccess('Password berhasil diubah');
        }

        return thisError('Password gagal diubah');
    }

    public function userEdit($id, Request $request)
    {
        $user = User::find($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->level = $request->level;
        $user->save();

        if ($user) {
            $getInfo = UserInfo::where('user_id', $id)->first();
            $info = UserInfo::find($getInfo->id);
            $info->user_id = $user->id;
            $info->branch_id = $request->branch_id;
            $info->save();

            if ($info) {
                return thisSuccess('Berhasil mengubah data');
            }

            return thisError('Gagal mengubah data');
        }
        return thisError('Gagal mengubah data');
    }

    public function userDelete($id)
    {
        $user = User::find($id);
        $user->delete();

        if ($user) {
            return thisSuccess('Berhasil menghapus data');
        }
        return thisError('Gagal menghapus data');
    }

    public function userDetail(Request $request)
    {
        $query = User::with('userInfo.branch.regional')->find($request->id);

        return thisSuccess('OK', $query);
    }
}
