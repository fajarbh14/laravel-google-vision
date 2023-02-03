<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LogActivity as Model;
use Auth;
use DB;
use DataTables;

class LogActivityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Superadmin');
    }

    public function index()
    {
        return view("admin.log-activity.index");
    }

    public function api(Request $request)
    {
        $data = Model::orderBy("id", "DESC");
        return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn("user", function($data) {
                    return $data->user_id ? $data->user->name : "Registrant";
                })
                ->addColumn('action', function($data) {
                    return view("admin.log-activity.partials.action", [
                        "detail"    => url("/log/detail/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function detail($id)
    {
        $data = Model::with("user")->findOrFail($id);
        return view("admin.log-activity.detail", compact("data"));
    }
}
