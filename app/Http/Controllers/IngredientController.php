<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Ingredient as Model;

use Auth;
use DB;
use DataTables;
use Log;

class IngredientController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:Superadmin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('admin.ingredient.index');
    }

    public function api(Request $request)
    {
        return DataTables::of(Model::orderBy("name", "ASC"))
                ->addIndexColumn()
                ->addColumn('action', function($data) {
                    return view("components.action", [
                        "edit"      => url("/ingredient/edit/".$data->id),
                        "delete"    => url("/ingredient/delete/".$data->id),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
    }

    public function create()
    {
        return view("admin.ingredient.create");
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => "required", 
            'type'   => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["status_code" => 400, "message" => "Validation error", "errors" => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $data = Model::create([
    			'name'  => $request['name'], 
    			'type' => $request['type'],
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
        return view("admin.ingredient.edit", compact("data"));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name'   => "required", 
            'type'  => "required",
        ]);

        if ($validator->fails()) {
            return response()->json(["status_code" => 400, "message" => "Validation error", "errors" => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $data       = Model::findOrFail($id);
            $dataOld    = Model::findOrFail($id);

            $data ->update([
    			'name'  => $request['name'], 
    			'type' => $request['type'],
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