<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController; 
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryProduct;
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

//FrontEnd - hoạt động giao tiếp người dùng
Route::get('/', [HomeController::class, 'index']);
Route::get('/trang-chu',[HomeController::class, 'index']);

//BackEnd - hoạt động ở server
Route::get('/admin',[AdminController::class, 'index']);
Route::get('/dashboard',[AdminController::class, 'show_dashboard']);
Route::get('/logout',[AdminController::class, 'logout']);
Route::post('/admin-dashboard',[AdminController::class, 'dashboard']);

//Category Product
Route::get('/add-category-product',[CategoryProduct::class, 'add_category_product']);
Route::get('/edit-category-product/{category_product_id}',[CategoryProduct::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}',[CategoryProduct::class, 'delete_category_product']);
Route::get('/all-category-product',[CategoryProduct::class, 'all_category_product']);

Route::get('/unactive-category-product/{category_product_id}',[CategoryProduct::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}',[CategoryProduct::class, 'active_category_product']);

Route::post('/save-category-product',[CategoryProduct::class, 'save_category_product']);

Route::post('/update-category-product/{category_product_id}',[CategoryProduct::class, 'update_category_product']);


