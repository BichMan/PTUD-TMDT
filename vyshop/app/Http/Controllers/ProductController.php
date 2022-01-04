<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\SliderModels;
use App\Models\PostCategoryModels;
use App\Models\ProductModels;
use Illuminate\Validation\Rule;

session_start();

class ProductController extends Controller
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
	public function add_product()
	{
		$this->Auth_Login();
		$cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
		$brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();

		return view('admin.product.add_product')->with('cate_product', $cate_product)->with('brand_product', $brand_product);
	}

	public function all_product()
	{
		$this->Auth_Login();
		$all_product = DB::table('tbl_product')
			->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
			->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
			->orderby('product_id', 'desc')->paginate(5);
		$manager_product = view('admin.product.all_product')->with('all_product', $all_product);
		return view('admin_layout')->with('admin.product.all_product', $manager_product);
	}
	public function filter_admin_product(Request $request)
	{
		$this->Auth_Login();
		$keywords = $request->keywords_filter;
		if ($keywords == '0') {
			$all_product = DB::table('tbl_product')->where('product_name', 'like', '%' . 'quan' . '%')
				->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
				->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
				->orderby('product_id', 'desc')->paginate(20);
			$manager_product = view('admin.product.all_product')->with('all_product', $all_product);
			return view('admin_layout')->with('admin.product.all_product', $manager_product);
		}
		else if ($keywords == '1') {
			$all_product = DB::table('tbl_product')->where('product_name', 'like', '%' . 'ao' . '%')
				->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
				->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
				->orderby('product_id', 'desc')->paginate(20);
			$manager_product = view('admin.product.all_product')->with('all_product', $all_product);
			return view('admin_layout')->with('admin.product.all_product', $manager_product);
		}
		else if ($keywords == '2') {
			$all_product = DB::table('tbl_product')->where('product_name', 'like', '%' . 'giay' . '%')
				->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
				->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
				->orderby('product_id', 'desc')->paginate(20);
			$manager_product = view('admin.product.all_product')->with('all_product', $all_product);
			return view('admin_layout')->with('admin.product.all_product', $manager_product);
		}
		else if ($keywords == '3') {
			$all_product = DB::table('tbl_product')->where('product_status',0)
				->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
				->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
				->orderby('product_id', 'desc')->paginate(20);
			$manager_product = view('admin.product.all_product')->with('all_product', $all_product);
			return view('admin_layout')->with('admin.product.all_product', $manager_product);
		}
		else if ($keywords == '4') {
			$all_product = DB::table('tbl_product')->where('product_status',1)
				->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
				->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
				->orderby('product_id', 'desc')->paginate(20);
			$manager_product = view('admin.product.all_product')->with('all_product', $all_product);
			return view('admin_layout')->with('admin.product.all_product', $manager_product);
		}
		else {
			Toastr::warning('Hãy chọn thông tin cần lọc!!');
			return redirect()->back();
		}
	}
	public function search_admin_product(Request $request)
	{
		$this->Auth_Login();
		$keywords = $request->keywords_search;
		if ($keywords != '') {
			$all_product = DB::table('tbl_product')->where('product_name', 'like', '%' . $keywords . '%')
				->join('tbl_category_product', 'tbl_category_product.category_id', '=', 'tbl_product.category_id')
				->join('tbl_brand', 'tbl_brand.brand_id', '=', 'tbl_product.brand_id')
				->orderby('product_id', 'desc')->paginate(5);
			$manager_product = view('admin.product.all_product')->with('all_product', $all_product);
			return view('admin_layout')->with('admin.product.all_product', $manager_product);
		} else {
			Toastr::warning('Hãy nhập từ khóa tìm kiếm!!');
			return redirect()->back();
		}
	}
	public function save_product(Request $request)
	{
		$this->Auth_Login();
		$data = $request->validate([
			'product_name' => 'required|unique:tbl_product',
			'product_keywords' => 'required',
			'product_price' => 'required',
			'product_desc' => 'required',
			'product_cate' => 'required',
			'product_brand' => 'required',
			'product_status' => 'required',
			'product_image' => 'required',
		], [
			// 'product_name.unique' => 'Tên sản phẩm đã tồn tại.',
			'product_name.required' => ' Thêm tên sản phẩm.',
			'product_price.required' => ' Thêm giá sản phẩm.',
			'product_desc.required' => ' Thêm mô tả sản phẩm.',
			'product_keywords.required' => ' Thêm slug sản phẩm.',
			'product_image.required' => ' Thêm hình ảnh sản phẩm.',
		]);
		$product = new ProductModels();
		$product->product_name = $data['product_name'];
		$product->product_price = $data['product_price'];
		$product->product_desc = $data['product_desc'];
		$product->category_id = $data['product_cate'];
		$product->brand_id = $data['product_brand'];
		$product->product_status = $data['product_status'];
		$product->meta_keywords = $data['product_keywords'];

		$get_image = $request->file('product_image');

		if ($get_image) {
			$get_name_image = $get_image->getClientOriginalName();
			$name_image = current(explode('.', $get_name_image)); //lấy tên trước dấu chấm
			$new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); //đuôi . mở rộng của ảnh
			//rand tránh trùng ảnh khi upload
			$get_image->move('public/uploads/product', $new_image); //di chuyển upload

			$data['product_image'] = $new_image;
			$product->product_image = $data['product_image'];
			$product->save();
			// Session::put('message', 'Thêm sản phẩm thành công');
			Toastr::success('Thêm sản phẩm thành công', 'Successful!!');
			return Redirect::to('add-product'); //Trở về trang all-product
		} else {
			Toastr::warning('Vui lòng thêm ảnh', 'Cảnh báo!!');
			return Redirect::to('add-product'); //Trở về trang all-product
		}
	}

	public function active_product($product_id)
	{
		$this->Auth_Login();
		DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 0]);
		// Session::put('message', 'Kích hoạt hiển thị sản phẩm thành công');
		Toastr::success('Hiển thị sản phẩm thành công', 'Successful!!');
		return Redirect::to('all-product');
	}

	public function unactive_product($product_id)
	{
		$this->Auth_Login();
		DB::table('tbl_product')->where('product_id', $product_id)->update(['product_status' => 1]);
		// Session::put('message', 'Kích hoạt ẩn sản phẩm thành công');
		Toastr::success('Ẩn sản phẩm thành công', 'Successful!!');
		return Redirect::to('all-product');
	}

	public function delete_product($product_id)
	{
		$this->Auth_Login();
		DB::table('tbl_product')->where('product_id', $product_id)->delete();
		// Session::put('message', 'Xóa sản phẩm thành công');
		Toastr::success('Xóa sản phẩm thành công', 'Successful!!');
		return redirect()->back();
	}

	public function edit_product($product_id)
	{
		$this->Auth_Login();
		$cate_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->get();
		$brand_product = DB::table('tbl_brand')->orderby('brand_id', 'desc')->get();

		$edit_product = DB::table('tbl_product')->where('product_id', $product_id)->get();

		$manager_product = view('admin.product.edit_product')->with('edit_product', $edit_product)
			->with('cate_product', $cate_product)->with('brand_product', $brand_product);

		return view('admin_layout')->with('admin.product.edit_product', $manager_product);
	}
	public function update_product(Request $request, $product_id)
	{
		$this->Auth_Login();
		$data = $request->validate([
			'product_keywords' => 'required',
			'product_name' => 'required',
			'product_price' => 'required',
			'product_desc' => 'required',
			'product_cate' => 'required',
			'product_brand' => 'required',
			'product_image' => 'required',
		], [
			'product_name.required' => ' Thêm tên sản phẩm.',
			'product_keywords.required' => ' Thêm slug sản phẩm.',
			'product_price.required' => ' Thêm giá sản phẩm.',
			'product_desc.required' => ' Thêm mô tả sản phẩm.',
			'product_image.required' => ' Thêm hình ảnh sản phẩm.',
		]);
		$product = ProductModels::find($product_id);

		$product->product_name = $data['product_name'];
		$product->product_price = $data['product_price'];
		$product->product_desc = $data['product_desc'];
		$product->category_id = $data['product_cate'];
		$product->brand_id = $data['product_brand'];
		$product->meta_keywords = $data['product_keywords'];
		$get_image = $request->file('product_image');

		if ($get_image) {
			$get_name_image = $get_image->getClientOriginalName();
			$name_image = current(explode('.', $get_name_image)); //lấy tên trước dấu chấm
			$new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); //đuôi . mở rộng của ảnh
			//rand tránh trùng ảnh khi upload
			$get_image->move('public/uploads/product', $new_image); //di chuyển upload

			$data['product_image'] = $new_image;
			$product->product_image = $data['product_image'];
			$product->save();
			// Session::put('message', 'Thêm sản phẩm thành công');
			Toastr::success('Cập nhật sản phẩm thành công', 'Successful!!');
			return Redirect::to('add-product'); //Trở về trang all-product
		} else {
			Toastr::warning('Vui lòng thêm ảnh', 'Cảnh báo!!');
			return Redirect::to('add-product'); //Trở về trang add-product
		}
	}
	//End admin pages
	//Details product home
	public function details_product($meta_keywords, Request $request)
	{
		$category_post = DB::table('tbl_category_post')->where('cate_post_status', '0')->get();

		$slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_status', '0')->take(4)->get();
		$cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();

		$brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

		$pro = ProductModels::where('meta_keywords', $meta_keywords)->take(1)->get();

		foreach ($pro as $key => $val) {
			$id = $val->product_id;
			$category_id = $val->category_id;
			$brand_id = $val->brand_id;
			$meta_desc = $val->category_desc;
			$meta_keywords = $val->meta_keywords;
			$meta_title = $val->product_name;
			$url_canonical = $request->url();
		}
		$details_product = ProductModels::with('category_product')->with('brand_product')->where('product_status', 0)->where('product_id', $id)->where('brand_id', $brand_id)->where('category_id', $category_id)->get();

		//san pham lien quan
		$related_product = ProductModels::with('category_product')->with('brand_product')->where('product_status', 0)->where('category_id', $category_id)->whereNotIn('product_id', [$id])->limit(3)->get();
		return view('pages.product.details_product')->with('category', $cate_product)->with('brand', $brand_product)->with('product_details', $details_product)->with('relate', $related_product)
			->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)
			->with('slider', $slider)->with('category_post', $category_post);
	}
}
