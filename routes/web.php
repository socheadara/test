<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

// Route::group(['middleware' => ['auth']], function () {});
// the same public function __construct(){$this->middleware('auth');}
Route::group(['middleware' => ['auth']], function () {
    Route::get('/', "DashboardController@index");
    //user route
    Route::get('user','UserController@index');
    Route::post('user/save','UserController@save');
    Route::post('user/update','UserController@update');
    Route::get('user/logout','UserController@logout');
    Route::get('user/delete/{id}','UserController@delete');
    Route::get('user/edit/{id}','UserController@edit');
    Route::get('user/create','UserController@create');
    Route::get('user/search','UserController@search');
    //role rout
    Route::get('role','RoleController@index');
    Route::get('role/create','RoleController@create');
    Route::get('role/edit/{id}','RoleController@edit');
    Route::get('role/delete/{id}','RoleController@delete');
    Route::get('role/detail/{id}','RoleController@detail');
    Route::post('role/save','RoleController@save');
    Route::post('role/update','RoleController@update');
    Route::post('role/permission/save','RoleController@save_permission');
    Route::get('role/search','RoleController@search');
    //Catetory route resource
    Route::resource('category','CategoryController')->except(['show','destroy']);
    Route::get('category/delete/{id}','CategoryController@delete');
    //Warehouse route resource
    Route::resource('warehouse', 'WarehouseController')->except(['show','destroy']);
    Route::get('warehouse/delete/{id}','WarehouseController@delete');
    //Route unit resource
    Route::resource('unit','UnitController')->except(['show','destroy']);
    Route::get('unit/delete/{id}','UnitController@delete');
    //Route product resource
    Route::resource('product', 'ProductController')->except(['show','destroy']);
    Route::get('product/delete/{id}','ProductController@delete')->name('product.delete');
    Route::get('product/detail/{id}','ProductController@detail')->name('product.detail');
    Route::get('product/search','ProductController@search');
    Route::post('product/import','ProductController@importfile');
    //stock in route
    Route::resource('stock-in','StockInController')->except(['show','destroy']);
    Route::get('stock-in/detail/{id}','StockInController@detail')->name('stock-in.detail');
    Route::get('stock-in/item/delete/{id}','StockInController@delete_item');
    Route::get('stock-in/delete/{id}','StockInController@delete')->name('stock-in.delete');
    Route::post('stock-in/item/save_new','StockInController@save_new_item');
    Route::post('stock-in/master/save_master','StockInController@save_master');
    Route::get('stock-in/print/{id}','StockInController@print')->name('stock-in.print');
    //stock out route
    Route::resource('stock-out','StockOutController')->except(['show','destroy']);
    Route::get('stock-out/detail/{id}','StockOutController@detail')->name('stock-out.detail');
    Route::get('stock-out/item/delete/{id}','StockOutController@delete_item');
    Route::get('stock-out/delete/{id}','StockOutController@delete')->name('stock-out.delete');
    Route::post('stock-out/item/save_new','StockOutController@save_new_item');
    Route::post('stock-out/master/save_master','StockOutController@save_master');
    Route::get('stock-out/print/{id}','StockOutController@print')->name('stock-out.print');
});

Auth::routes();


