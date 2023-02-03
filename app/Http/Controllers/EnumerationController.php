<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Enumeration as Model;

use Auth;
use DB;
use DataTables;
use Log;

class EnumerationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Superadmin');
    }

    public function index()
    {
        return view("admin.enumeration.index");
    }

    public function api(Request $request)
    {
        return DataTables::of(Model::orderBy("key", "ASC"))
                ->addIndexColumn()
                ->addColumn('action', function($data) {
                    return view("components.action", [
                        "edit"      => url("/enumeration/edit/".$data->id),
                        "delete"    => url("/enumeration/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function create()
    {
        return view("admin.enumeration.create");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key'   => "required", 
            'name'  => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["status_code" => 400, "message" => "Validation error", "errors" => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $data = Model::create([
    			'key'  => $request['key'], 
    			'name' => $request['name'],
    		]);

    		DB::commit();
            Log::addToLog("Created ".substr(Model::class, 11)." Id ". $data->id, $data, "-");

            return response()->json(["status_code" => 200, "message" => "Successfully Created Data", "data" => $data]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["status_code" => 500, "message" => $e->getMessage(), "data" => null]);
        }
    
    }
    public function edit($id)
    {
        $data   = Model::findOrFail($id);
        return view("admin.enumeration.edit", compact("data"));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'key'   => "required", 
            'name'  => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["status_code" => 400, "message" => "Validation error", "errors" => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);

            $data ->update([
    			'key'  => $request['key'], 
    			'name' => $request['name'],
    		]);

    		DB::commit();
            Log::addToLog("Updated ".substr(Model::class, 11)." Id ". $data->id, $dataOld, $data);

            return response()->json(["status_code" => 200, "message" => "Successfully Updated Data", "data" => $data]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["status_code" => 500, "message" => $e->getMessage(), "data" => null]);
        }
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try 
        {
            $data = Model::findOrFail($id);
            $data->delete();

            DB::commit();
            Log::addToLog("Deleted ".substr(Model::class, 11)." Id ". $data->id, $data, "-");

            return response()->json(["status_code" => 200, "message" => "Successfully Deleted Data", "data" => $data]);
        }
        catch (Exception $e) 
        {
            DB::rollback();
            return response()->json(["status_code" => 500, "message" => $e->getMessage(), "data" => null]);
        }
    }
}
