<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Models\Ingredient;
use App\Models\User;
use App\Models\FavoriteRecipe;

class HomeController extends Controller
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
        $data['totalIngredient']        = Ingredient::count(); 
        $data['totalUser']              = User::count(); 
        $data['totalFavoriteRecipe']    = FavoriteRecipe::count(); 
        return view('home',$data);
    }

}