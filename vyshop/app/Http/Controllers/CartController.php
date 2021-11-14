<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use  Gloudemans\Shoppingcart\Facades\Cart;

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
        return Redirect::to('/show-cart');
    }
    public function show_cart(Request $request)
    {
        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $meta_desc = "Giỏ hàng";
        $meta_keywords = "Giỏ hàng";
        $meta_title = "Giỏ hàng";
        $url_canonical = $request->url();
        return view('pages.cart.show_cart')->with('category', $cate_product)->with('brand', $brand_product)
            ->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical);
    }
    public function delete_cart($rowId)
    {
        Cart::remove($rowId);
        return Redirect::to('/show-cart');
    }

    public function update_quantity_cart(Request $request)
    {
        $rowId = $request->rowId_cart;
        $qty = $request->cart_quantity;
        Cart::update($rowId, $qty);
        return Redirect::to('/show-cart');
    }

    // public function add_cart_ajax(Request $request)
    // {
    //     $data  = $request->all();
    //     $session_id = substr(md5(microtime()),rand(0,26),5);//mỗi sản phẩm được thêm đều có một session id dựa vào cái này để xóa, update
    //     $cart = Session::get('cart');
    //     if($cart==true){
    //         $is_avaiable = 0;
    //         foreach($cart as $key => $val){
    //             if($val['product_id']==$data['cart_product_id']){
    //                 $is_avaiable++;
    //             }
    //         }
    //         if($is_avaiable == 0){
    //             $cart[] = array(
    //             'session_id' => $session_id,
    //             'product_name' => $data['cart_product_name'],
    //             'product_id' => $data['cart_product_id'],
    //             'product_image' => $data['cart_product_image'],
    //             'product_qty' => $data['cart_product_qty'],
    //             'product_price' => $data['cart_product_price'],
    //             );
    //             Session::put('cart',$cart);
    //         }
    //     }else{
    //         $cart[] = array(
    //             'session_id' => $session_id,
    //             'product_name' => $data['cart_product_name'],
    //             'product_id' => $data['cart_product_id'],
    //             'product_image' => $data['cart_product_image'],
    //             'product_qty' => $data['cart_product_qty'],
    //             'product_price' => $data['cart_product_price'],
    //         );
    //         Session::put('cart',$cart);
    //     }
    //     Session::save();
    // }

    // public function show_cart_ajax(Request $request){
    //     $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();

    //     $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

    //     $meta_desc = "Giỏ hàng ajax";
    //     $meta_keywords = "Giỏ hàng ajax";
    //     $meta_title = "Giỏ hàng";
    //     $url_canonical = $request->url();
    //     return view('pages.cart.cart_ajax')->with('category', $cate_product)->with('brand', $brand_product)
    //         ->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical);
    // }
}
