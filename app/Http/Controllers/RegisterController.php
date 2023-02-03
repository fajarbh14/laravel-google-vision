<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use DB;
use Log;

class RegisterController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view("register");
    }
    
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'   => "required", 
            'email'  => "required|unique:users",
            'password'   => "required", 
        ]);

        if ($validator->fails()) {
            return response()->json(["status_code" => 400, "message" => "Validation error", "errors" => $validator->errors()]);
        }

        DB::beginTransaction();
        try {
            $data = User::create([
    			'name'      => $request['name'], 
    			'email'     => $request['email'],
                'password'  => bcrypt($request['password']),
                'role_id'   => 2, //user
    		]);
    		DB::commit();
            Log::addToLog("Created Pendaftar Id ". $data->id, $data, "-");
            return response()->json(["status_code" => 200, "message" => "Successfully Create Account", "data" => $data]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["status_code" => 500, "message" => $e->getMessage(), "data" => null]);
        }
    
    }
}
