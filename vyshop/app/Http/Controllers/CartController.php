<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use  Gloudemans\Shoppingcart\Facades\Cart;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\SliderModels;
use App\Models\PostCategoryModels;

session_start();

class CartController extends Controller
{
    public function save_cart(Request $request)
    {
        $productId = $request->productid_hidden;
        $quantity = $request->qty;
        $product_info = DB::table('tbl_product')->where('product_id', $productId)->first();


        // Cart::add('293ad', 'Product 1', 1, 9.99, 550);
        $data['id'] = $product_info->product_id;
        $data['qty'] = $quantity;
        $data['name'] = $product_info->product_name;
        $data['price'] = $product_info->product_price;
        $data['weight'] = '1';
        $data['options']['image'] = $product_info->product_image;
        Cart::add($data);
        Cart::setGlobalTax(0);
        // Cart::destroy();
        $url_canonical = $request->url();
        Toastr::success('Thêm sản phẩm thành công', 'Successful!!');
        return redirect()->back();
    }
    public function show_cart(Request $request)
    {
        $category_post = DB::table('tbl_category_post')->where('cate_post_status', '0')->get();

        $slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_status', '0')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $meta_desc = "Giỏ hàng";
        $meta_keywords = "Giỏ hàng";
        $meta_title = "Giỏ hàng";
        $url_canonical = $request->url();
        return view('pages.cart.show_cart')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)
            ->with('url_canonical', $url_canonical)->with('slider', $slider)->with('category_post', $category_post);
    }
    public function delete_cart($rowId)
    {
        Cart::remove($rowId);
        Toastr::info('Xoá thành công!!');
        return redirect(url()->previous() . '#subscribe');
    }

    public function update_quantity_cart(Request $request)
    {
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId, $qty);
        return redirect()->back();
    }
}
