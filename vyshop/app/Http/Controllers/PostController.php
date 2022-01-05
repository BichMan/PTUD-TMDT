<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\PostModels;
use App\Models\PostCategoryModels;
use App\Models\SliderModels;

class PostController extends Controller
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
	public function add_post()
	{
		$this->Auth_Login();
		$cate_post = PostCategoryModels::orderBy('cate_post_id', 'DESC')->get();

		return view('admin.post.add_post')->with(compact('cate_post'));
	}

	public function filter_admin_post(Request $request)
	{
		$this->Auth_Login();
		$keywords = $request->keywords_filter;
		if ($keywords == '0') {
			$all_post = PostModels::with('cate_post')->where('post_status', 0)->orderBy('post_id')->paginate(20);
			$cate_post = PostCategoryModels::orderBy('cate_post_id', 'DESC')->get();

			return view('admin.post.all_post')->with(compact('all_post', 'cate_post'));
		}
		if ($keywords == '1') {
			$all_post = PostModels::with('cate_post')->where('post_status', 1)->orderBy('post_id')->paginate(20);
			$cate_post = PostCategoryModels::orderBy('cate_post_id', 'DESC')->get();

			return view('admin.post.all_post')->with(compact('all_post', 'cate_post'));
		} else {
			Toastr::warning('Hãy chọn thông tin cần lọc!!');
			return redirect()->back();
		}
	}
	public function search_admin_post(Request $request)
	{
		$this->Auth_Login();
		$keywords = $request->keywords_search;
		if ($keywords != '') {
			$all_post = PostModels::with('cate_post')->where('post_title', 'like', '%' . $keywords . '%')->orderBy('post_id')->paginate(20);
			$cate_post = PostCategoryModels::orderBy('cate_post_id', 'DESC')->get();

			return view('admin.post.all_post')->with(compact('all_post', 'cate_post'));
		} else {
			Toastr::warning('Hãy nhập từ khóa tìm kiếm!!');
			return redirect()->back();
		}
	}
	public function all_post()
	{
		$this->Auth_Login();
		$all_post = PostModels::with('cate_post')->orderBy('post_id')->paginate(4);
		$cate_post = PostCategoryModels::orderBy('cate_post_id', 'DESC')->get();

		return view('admin.post.all_post')->with(compact('all_post', 'cate_post'));
	}
	public function save_post(Request $request)
	{
		$this->Auth_Login();
		$data = $request->validate([
			'post_title' => 'required',
			'post_slug' => 'required|unique:tbl_posts',
			'post_image' => 'required',
			'post_desc' => 'required',
			'post_content' => 'required',
			'post_meta_desc' => 'required',
			'post_meta_keywords' => 'required',
			'cate_post_id' => 'required',
			'post_status' => 'required',
		], [
			'post_slug.unique' => 'Tên bài viết đã tồn tại.',
			'post_slug.required' => 'Thêm slug bài viết.',
			'post_title.required' => ' Thêm tên bài viết.',
			'post_desc.required' => ' Thêm mô tả bài viết.',
			'post_content.required' => ' Thêm nội dung bài viết.',
			'post_meta_desc.required' => ' Thêm meta nội dung bài viết.',
			'post_meta_keywords.required' => ' Thêm meta từ khóa bài viết.',
			'post_image.required' => ' Thêm hình ảnh bài viết.',
			// 'post_slug.required' => 'Tên bài viết đã tồn tại'
		]);
		$post = new PostModels();
		$post->post_title = $data['post_title'];
		$post->post_desc = $data['post_desc'];
		$post->post_content = $data['post_content'];
		$post->post_status = $data['post_status'];
		$post->post_meta_desc = $data['post_meta_desc'];
		$post->post_meta_keywords = $data['post_meta_keywords'];
		$post->cate_post_id = $data['cate_post_id'];
		$post->post_slug = $data['post_slug'];

		$get_image = $request->file('post_image');

		if ($get_image) {
			$get_name_image = $get_image->getClientOriginalName();
			$name_image = current(explode('.', $get_name_image)); //lấy tên trước dấu chấm
			$new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); //đuôi . mở rộng của ảnh
			//rand tránh trùng ảnh khi upload
			$get_image->move('public/uploads/post', $new_image); //di chuyển upload
			$data['post_image'] = $new_image;
			$post->post_image = $data['post_image'];
			$post->save();

			Toastr::success('Thêm bài viết thành công', 'Successful!!');
			return redirect()->back(); //Trở về trang all-product
		} else {
			Toastr::warning('Vui lòng thêm ảnh', 'Cảnh báo!!');
			return Redirect::to('all-post'); //Trở về trang all-product
		}
	}

	public function active_post($post_id)
	{
		$this->Auth_Login();
		DB::table('tbl_posts')->where('post_id', $post_id)->update(['post_status' => 0]);
		Toastr::success('Hiển thị bài viết thành công', 'Successful!!');
		return Redirect::to('all-post');
	}

	public function unactive_post($post_id)
	{
		$this->Auth_Login();
		DB::table('tbl_posts')->where('post_id', $post_id)->update(['post_status' => 1]);
		// Session::put('message', 'Kích hoạt ẩn sản phẩm thành công');
		Toastr::success('Ẩn bài viết thành công', 'Successful!!');
		return Redirect::to('all-post');
	}

	public function delete_post($post_id)
	{
		$this->Auth_Login();
		$post = PostModels::find($post_id);
		// $post_image = $post->post_image;

		// if ($post_image) {
		// 	$path = 'public/uploads/post/' . $post_image;
		// 	unlink($path);
		// }
		$post->delete();
		Toastr::success('Xóa bài viết thành công', 'Successful!!');
		return Redirect::to('all-post');
	}

	public function edit_post($post_id)
	{
		$this->Auth_Login();

		$post = PostModels::where('post_id', $post_id)->get();
		$cate_post = PostCategoryModels::orderBy('cate_post_id', 'DESC')->get();

		return view('admin.post.edit_post')->with(compact('post', 'cate_post'));
	}
	public function update_post(Request $request, $post_id)
	{
		$this->Auth_Login();
		$data = $request->validate([
			'post_slug' => 'required',
			'post_title' => 'required',
			'post_desc' => 'required',
			'post_content' => 'required',
			'post_meta_desc' => 'required',
			'post_meta_keywords' => 'required',
			'cate_post_id' => 'required',
			'post_image' => 'required',
		], [
			// 'post_slug.unique' => 'Tên bài viết đã tồn tại.',
			'post_title.required' => ' Thêm tên bài viết.',
			'post_slug.required' => ' Thêm slug bài viết.',
			'post_desc.required' => ' Thêm mô tả bài viết.',
			'post_content.required' => ' Thêm nội dung bài viết.',
			'post_meta_desc.required' => ' Thêm meta desc bài viết.',
			'post_meta_keywords.required' => ' Thêm meta keyword bài viết.',
			'post_image.required' => ' Thêm hình ảnh bài viết.',
			// 'post_slug.required' => 'Tên bài viết đã tồn tại'
		]);
		$post = PostModels::find($post_id);
		$post->post_title = $data['post_title'];
		$post->post_desc = $data['post_desc'];
		$post->post_content = $data['post_content'];
		$post->post_meta_desc = $data['post_meta_desc'];
		$post->post_meta_keywords = $data['post_meta_keywords'];
		$post->cate_post_id = $data['cate_post_id'];
		$post->post_slug = $data['post_slug'];

		$get_image = $request->file('post_image');

		if ($get_image) {
			//them anh moi
			$get_name_image = $get_image->getClientOriginalName();
			$name_image = current(explode('.', $get_name_image)); //lấy tên trước dấu chấm
			$new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); //đuôi . mở rộng của ảnh
			//rand tránh trùng ảnh khi upload
			$get_image->move('public/uploads/post', $new_image); //di chuyển upload
			$post->post_image = $new_image;
			$post->save();
			Toastr::success('Cập nhật bài viết thành công', 'Successful!!');
			return redirect::to('all-post');
		} else {
			Toastr::warning('Lỗi khi cập nhật bài viết', 'Cảnh báo!!');
			return redirect()->back(); //Trở về trang all-product
		}
	}
	//End admin pages
	//Bai viet Home
	public function bai_viet(Request $request, $post_slug)
	{
		$category_post = PostCategoryModels::orderBy('cate_post_id', 'DESC')->where('cate_post_status', '0')->get();

		$slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_status', '0')->take(4)->get();

		$cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
		$brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();
		// $catepost_post = PostCategoryModels::where('cate_post_id', $post_slug)->take(1)->get();

		$post = PostModels::with('cate_post')->where('post_status', 0)->where('post_slug', $post_slug)->take(1)->get();
		foreach ($post as $key => $po) {
			$meta_desc = $po->post_meta_desc;
			$meta_keywords = $po->post_meta_keywords;
			$meta_title = "Bài viết - " . $po->post_title;
			$url_canonical = $request->url();
		}
		return View('pages.post.post')->with('category', $cate_product)->with('brand', $brand_product)
			->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)->with('meta_title', $meta_title)->with('url_canonical', $url_canonical)
			->with('slider', $slider)->with('category_post', $category_post)->with('post', $post);
	}
}
