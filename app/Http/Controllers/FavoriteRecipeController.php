<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\FavoriteRecipe;

use Auth;
use DB;
use Log;

class FavoriteRecipeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $recipes  = FavoriteRecipe::where('user_id',Auth::user()->id)->get();
        return view('admin.favorite-recipe.index',compact("recipes"));
    }

    public function delete($id)
    {
        DB::beginTransaction();
        try 
        {
            $data = FavoriteRecipe::findOrFail($id);
            $data->delete();

            DB::commit();
            Log::addToLog("Remove Favorite Recipe ".substr(FavoriteRecipe::class, 11)." Id ". $data->id, $data, "-");

            return response()->json(["status_code" => 200, "message" => "Successfully Remove Favorite", "data" => $data]);
        }
        catch (Exception $e) 
        {
            DB::rollback();
            return response()->json(["status_code" => 500, "message" => $e->getMessage(), "data" => null]);
        }
    }

}

