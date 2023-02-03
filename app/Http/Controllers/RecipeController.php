<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use App\Models\FavoriteRecipe;
use App\Models\Ingredient;
use Google\Cloud\Vision\V1\Feature\Type;
use Google\Cloud\Vision\V1\ImageAnnotatorClient;
use Google\Cloud\Vision\V1\Likelihood;

use Auth;
use DB;
use Log;

class RecipeController extends Controller
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
        return view('admin.recipe.index');
    }

    public function searchRecipe(Request $request){ 
        try{ 
            $apiKey    = "a2fabfbf46bb40b799d40b69eaedd3d7";
            if($request['findby'] == 'image') {
                $image = file_get_contents($request->file('ingredientImage'));
                $imageAnnotator  = new ImageAnnotatorClient([
                    'credentials' => base_path().'/google-key.json'
                ]);
                $response = $imageAnnotator->objectLocalization($image);
                $labels = $response->getlocalizedObjectAnnotations()[0];
                $ingredient = $labels->getName();
            }else{
                $ingredient = $request['ingredient'];
            }
            $getRecipe = Http::get('https://api.spoonacular.com/recipes/findByIngredients?apiKey='.$apiKey.'&ingredients='.$ingredient.'&number=20&ignorePantry=true');
            return response()->json(["status_code" => 200, "message" => "Successfully Search Recipe", "data" => $getRecipe->json()]);
        }catch (Exception $e) {
            return response()->json(["status_code" => 500, "message" => $e->getMessage(), "data" => null]);
        }  
    }

    public function favoriteRecipe(Request $request){
        $validator = Validator::make($request->all(), [
            'recipe_id' => Rule::unique('favorite_recipes')->where(function ($query) {
                return $query->where('user_id', Auth::user()->id);
            })
        ]);

        if ($validator->fails()) {
            return response()->json(["status_code" => 400, "errors" => "Favorite recipe already exists"]);
        }

        DB::beginTransaction();
        try {
            $data = FavoriteRecipe::create([
    			'recipe_id'  => $request['recipe_id'], 
                'image'      => $request['image'],
                'url'        => $request['url'],
                'name'       => $request['name'],
                'user_id'    => Auth::user()->id
    		]);

    		DB::commit();
            Log::addToLog("Created ".substr(FavoriteRecipe::class, 11)." Id ". $data->id, $data, "-");

            return response()->json(["status_code" => 200, "message" => "Successfully Add To Favorite", "data" => $data]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(["status_code" => 500, "message" => $e->getMessage(), "data" => null]);
        }
    }
}

