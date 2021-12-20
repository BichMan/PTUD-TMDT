<?php

namespace App\Http\Controllers;

use App\Models\BrandProductModels;
use App\Models\CategoryProductModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\SliderModels;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\PostCategoryModels;
use App\Models\ProductModels;

session_start();

class HomeController extends Controller
{
	public function index(Request $request)
	{

		$meta_desc = "Cửa hàng thời trang unisex dành cho giới trẻ. Shop chuyên sỉ Unisex · Unisex store · Heroic.sg Clothing · SX Invastion shop · Lider Closet · Chuột trắng Unisex · Shop bán quần áo Unisex";
		$meta_keywords = "unisex, shop quan ao, quần áo giày unisex";
		$meta_title = "VY Shop - Thời trang Unisex";
		$url_canonical = $request->url();

		//category post
		$category_post = PostCategoryModels::orderBy('cate_post_id', 'DESC')->where('cate_post_status', '0')->get();
		//slider
		$slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_status', '0')->take(4)->get();
		$cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
		$brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

		$all_product = DB::table('tbl_product')->where('product_status', '0')->orderby('brand_id', 'desc')->paginate(6);
		return view('pages.home')->with('category', $cate_product)->with('brand', $brand_product)->with('all_product', $all_product)
			->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)
			->with('slider', $slider)->with('category_post', $category_post); //1
		//lấy thẳng tên biến
		//return view('pages.home')->with(compact('cate_product','brand_product', 'all_product'));//2

	}
	public function search(Request $request)
	{

		$keywords = $request->keywords_search;

		if ($keywords != '') {
			$category_post = PostCategoryModels::orderBy('cate_post_id', 'DESC')->where('cate_post_status', '0')->get();

			$slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_status', '0')->take(4)->get();

			$cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
			$brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

			$search_product = DB::table('tbl_product')
				->where('product_name', 'like', '%' . $keywords . '%')
				->get();
			$meta_desc = "Tìm kiếm sản phẩm";
			$meta_keywords = "Tìm kiếm sản phẩm";
			$meta_title = "Tìm kiếm sản phẩm";
			$url_canonical = $request->url();
			return view('pages.product.search')->with('category', $cate_product)->with('brand', $brand_product)->with('search_product', $search_product)
				->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)
				->with('slider', $slider)->with('category_post', $category_post);
		} else {
			Toastr::info('Hãy nhập từ khóa tìm kiếm!!');
			return redirect()->back();
		}
	}

	//send mail
	public function send_mail()
	{
		// $to_name = "thienchauminhnguyet2000@gmail.com";
		$to_email = "thienchauminhnguyet2000@gmail.com"; //email nhan

		$data = array("name" => "Mail từ shop gửi đến khách hàng", "body" => "Mail liên quan đến sản phẩm");
		Mail::send('pages.send_mail', $data, function ($message) use ($to_email) {
			$message->to($to_email)->subject('TEST Gửi mail google');
			// $message->from($to_email,$to_name);
		});
		return redirect('/')->with('message', '');
	}
}
