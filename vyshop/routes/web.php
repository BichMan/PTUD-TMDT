<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BrandProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryProductController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\PostCategoryController;
use App\Http\Controllers\PostController;
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

//FrontEnd - hoạt động giao tiếp người dùng
Route::get('/', [HomeController::class, 'index']);
Route::get('/trang-chu', [HomeController::class, 'index']);
Route::post('/tim-kiem', [HomeController::class, 'search']);

//Danh muc san pham trang chu
Route::get('/danh-muc-san-pham/{meta_keywords}', [CategoryProductController::class, 'Category_Home']);

//Bai viet trang chu
Route::get('/danh-muc-bai-viet/{cate_post_slug}', [PostCategoryController::class, 'danh_muc_bai_viet']);
Route::get('/bai-viet/{post_slug}', [PostController::class, 'bai_viet']);

//Thuong hieu san pham trang chu
Route::get('/thuong-hieu-san-pham/{meta_keywords}', [BrandProductController::class, 'Brand_Home']);

//Chi tiet san pham trang chu
Route::get('/chi-tiet-san-pham/{meta_keywords}', [ProductController::class, 'details_product']);

//BackEnd - hoạt động ở server
Route::get('/admin', [AdminController::class, 'index']);
Route::get('/dashboard', [AdminController::class, 'show_dashboard']);
Route::get('/logout', [AdminController::class, 'logout']);
Route::post('/admin-dashboard', [AdminController::class, 'dashboard']);
Route::post('/filter-by-date', [AdminController::class, 'filter_by_date']);

//Category Product
Route::get('/add-category-product', [CategoryProductController::class, 'add_category_product']);
Route::get('/all-category-product', [CategoryProductController::class, 'all_category_product']);
Route::get('/edit-category-product/{category_product_id}', [CategoryProductController::class, 'edit_category_product']);
Route::get('/delete-category-product/{category_product_id}', [CategoryProductController::class, 'delete_category_product']);

Route::get('/unactive-category-product/{category_product_id}', [CategoryProductController::class, 'unactive_category_product']);
Route::get('/active-category-product/{category_product_id}', [CategoryProductController::class, 'active_category_product']);

Route::post('/save-category-product', [CategoryProductController::class, 'save_category_product']);
Route::post('/update-category-product/{category_product_id}', [CategoryProductController::class, 'update_category_product']);

//Category Post
Route::get('/add-category-post', [PostCategoryController::class, 'add_category_post']);
Route::post('/save-category-post', [PostCategoryController::class, 'save_category_post']);
Route::get('/all-category-post', [PostCategoryController::class, 'all_category_post']);
Route::get('/delete-category-post/{cate_post_id}', [PostCategoryController::class, 'delete_category_post']);

Route::get('/unactive-category-post/{cate_post_id}', [PostCategoryController::class, 'unactive_category_post']);
Route::get('/active-category-post/{cate_post_id}', [PostCategoryController::class, 'active_category_post']);

Route::get('/edit-category-post/{cate_post_id}', [PostCategoryController::class, 'edit_category_post']);
Route::post('/update-category-post/{cate_post_id}', [PostCategoryController::class, 'update_category_post']);

//Post
Route::get('/add-post', [PostController::class, 'add_post']);
Route::get('/all-post', [PostController::class, 'all_post']);
Route::get('/delete-post/{post_id}', [PostController::class, 'delete_post']);
Route::get('/unactive-post/{post_id}', [PostController::class, 'unactive_post']);
Route::get('/active-post/{post_id}', [PostController::class, 'active_post']);
Route::get('/edit-post/{post_id}', [PostController::class, 'edit_post']);

Route::post('/update-post/{post_id}', [PostController::class, 'update_post']);
Route::post('/save-post', [PostController::class, 'save_post']);

Route::post('/filter-admin-post', [PostController::class, 'filter_admin_post']);
Route::post('/search-admin-post', [PostController::class, 'search_admin_post']);

//Brand Product
Route::get('/add-brand-product', [BrandProductController::class, 'add_brand_product']);
Route::get('/all-brand-product', [BrandProductController::class, 'all_brand_product']);
Route::get('/edit-brand-product/{brand_product_id}', [BrandProductController::class, 'edit_brand_product']);
Route::get('/delete-brand-product/{brand_product_id}', [BrandProductController::class, 'delete_brand_product']);

Route::get('/unactive-brand-product/{brand_product_id}', [BrandProductController::class, 'unactive_brand_product']);
Route::get('/active-brand-product/{brand_product_id}', [BrandProductController::class, 'active_brand_product']);

Route::post('/save-brand-product', [BrandProductController::class, 'save_brand_product']);
Route::post('/update-brand-product/{brand_product_id}', [BrandProductController::class, 'update_brand_product']);

//Product
Route::get('/add-product', [ProductController::class, 'add_product']);
Route::get('/all-product', [ProductController::class, 'all_product']);
Route::get('/edit-product/{product_id}', [ProductController::class, 'edit_product']);
Route::get('/delete-product/{product_id}', [ProductController::class, 'delete_product']);

Route::get('/unactive-product/{product_id}', [ProductController::class, 'unactive_product']);
Route::get('/active-product/{product_id}', [ProductController::class, 'active_product']);

Route::post('/save-product', [ProductController::class, 'save_product']);
Route::post('/update-product/{product_id}', [ProductController::class, 'update_product']);

Route::post('/filter-admin-product', [ProductController::class, 'filter_admin_product']);
Route::post('/search-admin-product', [ProductController::class, 'search_admin_product']);


//CART -- GIO HANG
Route::post('/save-cart', [CartController::class, 'save_cart']);
Route::get('/show-cart', [CartController::class, 'show_cart']);
Route::get('/delete-cart/{rowId}', [CartController::class, 'delete_cart']);
Route::post('/update-quantity-cart', [CartController::class, 'update_quantity_cart']);
// Route::post('/add-cart-ajax', [CartController::class, 'add_cart_ajax']);
// Route::get('/show-cart-ajax', [CartController::class, 'show_cart_ajax']);

//Check Account

Route::get('/login-checkout', [CheckoutController::class, 'login_checkout']);
Route::get('/logout-checkout', [CheckoutController::class, 'logout_checkout']);
Route::get('/checkout', [CheckoutController::class, 'checkout']);
Route::get('/payment', [CheckoutController::class, 'payment']);
Route::get('/paypal-payment', [CheckoutController::class, 'paypal_payment']);
Route::post('/login-customer', [CheckoutController::class, 'login_customer']);
Route::post('/add-customer', [CheckoutController::class, 'add_customer']);
Route::post('/save-customer', [CheckoutController::class, 'save_customer']);
Route::post('/order-place', [CheckoutController::class, 'order_place']);

//Quên mật khẩu
Route::get('/quen-mat-khau', [CheckoutController::class, 'quen_mat_khau']);
Route::post('/recover-pass', [CheckoutController::class, 'recover_pass']);


//Order
Route::get('/manage-order', [CheckoutController::class, 'manage_order']);
Route::get('/view-order/{order_id}', [CheckoutController::class, 'view_order']);
Route::get('/edit-order-status/{order_id}', [CheckoutController::class, 'edit_order_status']);
Route::post('/update-order-status/{order_id}', [CheckoutController::class, 'update_order_status']);

//send Mail
Route::get('/send-mail', [HomeController::class, 'send_mail']);

//Login Facebook
Route::get('/login-facebook', [AdminController::class, 'login_facebook']);
Route::get('/admin/callback', [AdminController::class, 'callback_facebook']);

//Login Google
Route::get('/login-google',[AdminController::class, 'login_google']);
Route::get('/google/callback',[AdminController::class, 'callback_google']);


//Banner
Route::get('/manage-slider',[SliderController::class, 'manage_slider']);
Route::get('/add-slider',[SliderController::class, 'add_slider']);
Route::post('/insert-slider',[SliderController::class, 'insert_slider']);
Route::get('/unactive-slider/{slider_id}',[SliderController::class, 'unactive_slider']);
Route::get('/active-slider/{slider_id}',[SliderController::class, 'active_slider']);
Route::get('/delete-slider/{slider_id}',[SliderController::class, 'delete_slider']);
Route::post('/filter-admin-banner', [SliderController::class, 'filter_admin_banner']);
Route::post('/search-admin-banner', [SliderController::class, 'search_admin_banner']);






