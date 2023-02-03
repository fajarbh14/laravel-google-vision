<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', function() {
    return response()->redirectTo("/home");
});

Route::get("/login", "AuthController@index")->name("login");
Route::post("/login", "AuthController@login");
Route::get('logout', 'AuthController@logout')->name('logout');

Route::get("/register","RegisterController@index")->name("register");
Route::post("/register","RegisterController@create");

Route::get("/home", "HomeController@index");

Route::get("/ingredient", "IngredientController@index");
Route::get("/ingredient/api", "IngredientController@api");
Route::get("/ingredient/create", "IngredientController@create");
Route::post("/ingredient/store", "IngredientController@store");
Route::get("/ingredient/edit/{id}", "IngredientController@edit");
Route::post("/ingredient/update/{id}", "IngredientController@update");
Route::get("/ingredient/delete/{id}", "IngredientController@delete");

Route::get("/enumeration", "EnumerationController@index");
Route::get("/enumeration/api", "EnumerationController@api");
Route::get("/enumeration/create", "EnumerationController@create");
Route::post("/enumeration/store", "EnumerationController@store");
Route::get("/enumeration/edit/{id}", "EnumerationController@edit");
Route::post("/enumeration/update/{id}", "EnumerationController@update");
Route::get("/enumeration/delete/{id}", "EnumerationController@delete");

Route::get("/recipe", "RecipeController@index");
Route::post("/recipe/searchRecipe", "RecipeController@searchRecipe");
Route::post("/recipe/favoriteRecipe", "RecipeController@favoriteRecipe");
Route::get('/recipe/detailRecipe/{id}',"RecipeController@detailRecipe");

Route::get('/favorite-recipe',"FavoriteRecipeController@index");
Route::get("/favorite-recipe/delete/{id}", "FavoriteRecipeController@delete");

Route::get("/users", "UserController@index");
Route::get("/users/api", "UserController@api");
Route::get("/users/create", "UserController@create");
Route::post("/users/store", "UserController@store");
Route::get("/users/edit/{id}", "UserController@edit");
Route::post("/users/update/{id}", "UserController@update");
Route::get("/users/delete/{id}", "UserController@delete");

Route::get("/log", "LogActivityController@index");
Route::get("/log/api", "LogActivityController@api");
Route::get("/log/detail/{id}", "LogActivityController@detail");