<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Redirect;
use Session;

session_start();

class ProductController extends Controller {
	public function Auth_Login() {
		$admin_id = Session::get('admin_id');
		if ($admin_id) {
			return Redirect::to('dashboard');
		} else {
			return Redirect::to('admin')->send();
		}

	}
	public function add_product() {
		$this->Auth_Login();
		$cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
		$brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();

		return view('admin.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
	}

	public function all_product() {
		$this->Auth_Login();
		$all_product = DB::table('tbl_product')
			->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
			->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
			->orderby('product_id', 'desc')->get();
		$manager_product = view('admin.all_product')->with('all_product', $all_product);
		return view('admin_layout')->with('admin.all_product', $manager_product);
	}

	public function save_product(Request $request) {
		$this->Auth_Login();
		$data = array();
		$data['product_name'] = $request->product_name; //name tên cột
		$data['product_price'] = $request->product_price;
		$data['product_desc'] = $request->product_desc;
		$data['product_content'] = $request->product_content;
		$data['category_id'] = $request->product_cate;
		$data['brand_id'] = $request->product_brand;
		$data['product_status'] = $request->product_status;
		$get_image = $request->file('product_image');

		if ($get_image) {
			$get_name_image = $get_image->getClientOriginalName();
			$name_image = current(explode('.', $get_name_image)); //lấy tên trước dấu chấm
			$new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); //đuôi . mở rộng của ảnh
			//rand tránh trùng ảnh khi upload
			$get_image->move('public/uploads/product', $new_image); //di chuyển upload
			$data['product_image'] = $new_image;

			DB::table('tbl_product')->insert($data);
			Session::put('message', 'Thêm sản phẩm thành công');
			return Redirect::to('add-product'); //Trở về trang all-product
		}
		$data['product_image'] = '';
		DB::table('tbl_product')->insert($data);
		Session::put('message', 'Thêm sản phẩm thành công');
		return Redirect::to('add-product'); //Trở về trang all-product
	}

	public function active_product($product_id) {
		$this->Auth_Login();
		DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 0]);
		Session::put('message', 'Kích hoạt hiển thị sản phẩm thành công');
		return Redirect::to('all-product');
	}

	public function unactive_product($product_id) {
		$this->Auth_Login();
		DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 1]);
		Session::put('message', 'Kích hoạt ẩn sản phẩm thành công');
		return Redirect::to('all-product');
	}

	public function delete_product($product_id) {
		$this->Auth_Login();
		DB::table('tbl_product')->where('product_id', $product_id)->delete();
		Session::put('message', 'Xóa sản phẩm thành công');
		return Redirect::to('all-product');
	}

	public function edit_product($product_id) {
		$this->Auth_Login();
		$cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
		$brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();

		$edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();
		$manager_product = view('admin.edit_product')->with('edit_product', $edit_product)
			->with('cate_product', $cate_product)->with('brand_product', $brand_product);

		return view('admin_layout')->with('admin.edit_product', $manager_product);
	}
	public function update_product(Request $request, $product_id) {
		$this->Auth_Login();
		$data = array();
		$data['product_name'] = $request->product_name; //name tên cột
		$data['product_price'] = $request->product_price;
		$data['product_desc'] = $request->product_desc;
		$data['product_content'] = $request->product_content;
		$data['category_id'] = $request->product_cate;
		$data['brand_id'] = $request->product_brand;
		// $data['product_status'] = $request->product_status;
		$get_image = $request->file('product_image');

		if ($get_image) {
			$get_name_image = $get_image->getClientOriginalName();
			$name_image = current(explode('.', $get_name_image)); //lấy tên trước dấu chấm
			$new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); //đuôi . mở rộng của ảnh
			//rand tránh trùng ảnh khi upload
			$get_image->move('public/uploads/product', $new_image); //di chuyển upload
			$data['product_image'] = $new_image;

			DB::table('tbl_product')->where('product_id', $product_id)->update($data);
			Session::put('message', 'Cập nhật sản phẩm thành công');
			return Redirect::to('all-product'); //Trở về trang all-product
		}
		DB::table('tbl_product')->where('product_id', $product_id)->update($data);
		Session::put('message', 'Cập nhật sản phẩm thành công');
		return Redirect::to('all-product'); //Trở về trang all-product

	}
//End admin pages
	//Details product home
	public function details_product($product_id) {
		$cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();

		$brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

		$details_product = DB::table('tbl_product')
			->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
			->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
			->where('tbl_product.product_id', $product_id)->get();

		foreach ($details_product as $key => $value) {
			$category_id = $value->category_id;
		}

		//san pham lien quan
		$related_product = DB::table('tbl_product')
			->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
			->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
			->where('tbl_category_product.category_id', $category_id)->whereNotIn('tbl_product.product_id', [$product_id])->get();
		//tru san pham da xem whereNotIn

		return view('pages.product.details_product')->with('category', $cate_product)->with('brand', $brand_product)->with('product_details', $details_product)->with('relate', $related_product);
	}
}
