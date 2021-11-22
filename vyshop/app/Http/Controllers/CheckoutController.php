<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use  Gloudemans\Shoppingcart\Facades\Cart;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\SliderModels;

session_start();

class CheckoutController extends Controller
{
	public function Auth_Login()
	{
		$admin_id = Session::get('admin_id');
		if ($admin_id) {
			return Redirect::to('dashboard');
		} else {
			return Redirect::to('admin')->send();
		}
	}
	public function login_checkout(Request $request)
	{
		$slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_status', '0')->take(4)->get();

		$cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();

		$brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

		$meta_desc = "Đăng nhập/Đăng ký";
		$meta_keywords = "Đăng nhập/Đăng ký";
		$meta_title = "Đăng nhập/Đăng ký";
		$url_canonical = $request->url();

		return view('pages.Checkout_Account.login_checkout')->with('category', $cate_product)->with('brand', $brand_product)
			->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)
			->with('slider', $slider);
	}

	public function add_customer(Request $request)
	{
		$data = array();
		$data['customer_name'] = $request->customer_name;
		$data['customer_email'] = $request->customer_email;
		$data['customer_password'] = md5($request->customer_password);
		$data['customer_phone'] = $request->customer_phone;

		$customer_id = DB::table('tbl_customer')->insertGetId($data);

		Session::put('customer_id', $customer_id);
		Session::put('customer_name', $request->customer_name);

		return Redirect::to('/checkout');
	}

	public function checkout(Request $request)
	{
		$slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_status', '0')->take(4)->get();

		$cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();

		$brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

		$meta_desc = "Thông tin người nhận";
		$meta_keywords = "Thông tin người nhận";
		$meta_title = "Thông tin người nhận";
		$url_canonical = $request->url();
		return view('pages.Checkout_Account.checkout')->with('category', $cate_product)->with('brand', $brand_product)
			->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)
			->with('slider', $slider);
	}

	public function save_customer(Request $request)
	{
		$data = array();
		$data['shipping_name'] = $request->shipping_name;
		$data['shipping_email'] = $request->shipping_email;
		$data['shipping_note'] = $request->shipping_note;
		$data['shipping_phone'] = $request->shipping_phone;
		$data['shipping_address'] = $request->shipping_address;

		$shipping_id = DB::table('tbl_shipping')->insertGetId($data);

		Session::put('shipping_id', $shipping_id);

		return Redirect::to('/payment');
	}

	public function payment(Request $request)
	{
		$slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_status', '0')->take(4)->get();

		$cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();

		$brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

		$meta_desc = "Xem lại đơn hàng";
		$meta_keywords = "Xem lại đơn hàng";
		$meta_title = "Xem lại đơn hàng";
		$url_canonical = $request->url();
		return view('pages.Checkout_Account.payment')->with('category', $cate_product)->with('brand', $brand_product)
			->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)
			->with('slider', $slider);
	}

	public function logout_checkout()
	{
		Session::flush();
		return Redirect::to('/login-checkout');
	}

	public function login_customer(Request $request)
	{
		$email = $request->email_account;
		$password = md5($request->password_account);
		$result = DB::table('tbl_customer')->where('customer_email', $email)->where('customer_password', $password)->first();

		if ($result) {
			Session::put('customer_id', $result->customer_id);
			return Redirect::to('/checkout');
		} else {
			Session::put('message', 'Mật khẩu hoặc tài khoản sai. Vui lòng nhập lại');
			// Toastr::warning('Mật khẩu hoặc tài khoản sai. Vui lòng nhập lại');
			return Redirect::to('/login-checkout');
		}
	}

	public function order_place(Request $request)
	{
		//insert phương thức thanh toán
		$data = array();
		$data['payment_method'] = $request->payment_option;
		$data['payment_status'] = 'Đang chờ xử lý';
		$payment_id = DB::table('tbl_payment')->insertGetId($data);

		//insetr order
		$data_order = array();
		$data_order['customer_id'] = Session::get('customer_id');
		$data_order['shipping_id'] = Session::get('shipping_id');
		$data_order['payment_id'] = $payment_id;
		$data_order['order_total'] = Cart::total();
		$data_order['order_status'] = 'Đang chờ xử lý';
		$order_id = DB::table('tbl_order')->insertGetId($data_order);

		//insetr details order
		$content = Cart::content();
		foreach ($content as $v_content) {
			$data_details_order = array();
			$data_details_order['order_id'] = $order_id;
			$data_details_order['product_id'] = $v_content->id;
			$data_details_order['product_name'] = $v_content->name;
			$data_details_order['product_price'] = $v_content->price;
			$data_details_order['product_sales_quatity'] = $v_content->qty;
			DB::table('tbl_order_details')->insertGetId($data_details_order);
		}

		if ($data['payment_method'] == 1) {
			$meta_desc = "Thanh toán thành công";
			$meta_keywords = "Thanh toán Thành Công";
			$meta_title = "Thanh toán Thành Công";
			$url_canonical = $request->url();
			echo 'Thanh toán bằng ATM';
		} elseif ($data['payment_method'] == 2) {
			Cart::destroy();
			$slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_status', '0')->take(4)->get();

			$cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();

			$brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

			$meta_desc = "Thanh toán thành công";
			$meta_keywords = "Thanh toán Thành Công";
			$meta_title = "Thanh toán Thành Công";
			$url_canonical = $request->url();

			return view('pages.Checkout_Account.handcash')->with('category', $cate_product)->with('brand', $brand_product)
				->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)
				->with('slider', $slider);
		} else {
			$meta_desc = "Thanh toán thành công";
			$meta_keywords = "Thanh toán Thành Công";
			$meta_title = "Thanh toán Thành Công";
			$url_canonical = $request->url();
			echo "Thanh toán bằng momo";
		}
		// return Redirect::to('/payment');
	}

	public function manage_order()
	{
		$this->Auth_Login();
		$all_order = DB::table('tbl_order')
			->join('tbl_customer', 'tbl_order.customer_id', '=', 'tbl_customer.customer_id')
			->select('tbl_order.*', 'tbl_customer.customer_name')
			->orderby('tbl_order.order_id', 'desc')->get();
		$manager_order = view('admin.manage_order')->with('all_order', $all_order);
		return view('admin_layout')->with('admin.manage_order', $manager_order);
	}

	public function view_order($orderid)
	{
		$this->Auth_Login();
		$order_by_id = DB::table('tbl_order')
			->join('tbl_customer', 'tbl_order.customer_id', '=', 'tbl_customer.customer_id')
			->join('tbl_shipping', 'tbl_order.shipping_id', '=', 'tbl_shipping.shipping_id')
			->join('tbl_order_details', 'tbl_order.order_id', '=', 'tbl_order_details.order_id')
			->select('tbl_order.*', 'tbl_customer.*', 'tbl_shipping.*', 'tbl_order_details.*')->first();

		$manager_order_by_id = view('admin.view_order')->with('order_by_id', $order_by_id);
		return view('admin_layout')->with('admin.view_order', $manager_order_by_id);
	}

//Quên mật khẩu
	public function quen_mat_khau(Request $request){
		$meta_desc = "Quên mật khẩu";
		$meta_keywords = "Quên mật khẩu";
		$meta_title ="Quên mật khẩu";
		$url_canonical =$request->url();

		$slider = SliderModels::orderBy('slider_id','DESC')->where('slider_status','0')->take(4)->get();
		$cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
		$brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

		$all_product = DB::table('tbl_product')->where('product_status', '0')->orderby('product_id', 'desc')->limit(12)->get();
		return view('pages.Checkout_Account.forget_pass')->with('category', $cate_product)->with('brand', $brand_product)->with('all_product', $all_product)
		->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)
		->with('slider',$slider);
	}

	public function recover_pass(Request $request){
		return Redirect::to('/quen-mat-khau');
	}
}
