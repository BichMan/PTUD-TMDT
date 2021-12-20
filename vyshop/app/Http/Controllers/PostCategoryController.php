<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\PostCategoryModels;
use App\Models\SliderModels;
use App\Models\PostModels;

class PostCategoryController extends Controller
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

    public function add_category_post()
    {
        $this->Auth_Login();
        return view('admin.category_post.add_category_post');
    }
    public function all_category_post()
    {
        $this->Auth_Login();
        $all_category_post = PostCategoryModels::orderBy('cate_post_id', 'DESC')->paginate(4);
        $manager_category_post = view('admin.category_post.all_category_post')->with('all_category_post', $all_category_post);
        return view('admin_layout')->with('admin.category_post.all_category_post', $manager_category_post);
    }
    public function save_category_post(Request $request)
    {
        $this->Auth_Login();

        // $data = $request->all();
        $data = $request->validate([
            'cate_post_name' => 'required',
			'cate_post_slug' => 'required|unique:tbl_category_post',
			'cate_post_desc' => 'required',
			'cate_post_status' => 'required'
		], [
			'cate_post_slug.unique' => 'Tên danh mục bài viết đã tồn tại.',
			'cate_post_name.required' => ' Thêm tên danh mục.',
			'cate_post_desc.required' => ' Thêm mô tả danh mục.',
			'cate_post_slug.required' => ' Thêm slug danh mục.',
			// 'post_slug.required' => 'Tên bài viết đã tồn tại'
		]);
        $category_post = new PostCategoryModels();
        $category_post->cate_post_name = $data['cate_post_name'];
        $category_post->cate_post_desc = $data['cate_post_desc'];
        $category_post->cate_post_status = $data['cate_post_status'];
        $category_post->cate_post_slug = $data['cate_post_slug'];
        $category_post->save();

        Toastr::success('Thêm danh mục bài viết thành công', 'Successful!!');
        return redirect()->back();
    }
    public function delete_category_post($cate_post_id)
    {
        $this->Auth_Login();
        DB::table('tbl_category_post')->where('cate_post_id', $cate_post_id)->delete();
        Toastr::success('Xóa danh mục bài viết thành công', 'Successful!!');
        return redirect()->back();
    }

    public function active_category_post($cate_post_id)
    {
        $this->Auth_Login();
        DB::table('tbl_category_post')->where('cate_post_id', $cate_post_id)->update(['cate_post_status' => 0]);
        // Session::put('message', 'Kích hoạt hiển thị sản phẩm thành công');
        Toastr::success('Hiển thị danh mục bài viết thành công', 'Successful!!');
        return redirect()->back();
    }

    public function unactive_category_post($cate_post_id)
    {
        $this->Auth_Login();
        DB::table('tbl_category_post')->where('cate_post_id', $cate_post_id)->update(['cate_post_status' => 1]);
        // Session::put('message', 'Kích hoạt ẩn sản phẩm thành công');
        Toastr::success('Ẩn danh mục bài viết thành công', 'Successful!!');
        return redirect()->back();
    }
    public function edit_category_post($cate_post_id)
    {
        $this->Auth_Login();
        $edit_category_post = DB::table('tbl_category_post')->where('cate_post_id', $cate_post_id)->get();
        $manager_category_post = view('admin.category_post.edit_category_post')->with('edit_category_post', $edit_category_post);
        return view('admin_layout')->with('admin.category_post.edit_category_post', $manager_category_post);
    }
    public function update_category_post(Request $request, $cate_post_id)
    {
        $this->Auth_Login();
        $data = $request->validate([
			'cate_post_slug' => 'required',
			'cate_post_name' => 'required',
			'cate_post_desc' => 'required',
			// 'cate_post_status' => 'required'
		], [
			// 'cate_post_slug.unique' => 'Tên danh mục bài viết đã tồn tại.',
			'cate_post_name.required' => ' Thêm tên danh mục.',
			'cate_post_desc.required' => ' Thêm mô tả danh mục.',
			'cate_post_slug.required' => ' Thêm slug danh mục.'
			// 'post_slug.required' => 'Tên bài viết đã tồn tại'
		]);
        $category_post = PostCategoryModels::find($cate_post_id);
        $category_post->cate_post_name = $data['cate_post_name'];
        $category_post->cate_post_desc = $data['cate_post_desc'];
        $category_post->cate_post_slug = $data['cate_post_slug'];
        $category_post->save();

        Toastr::success('Cập nhật danh mục bài viết thành công', 'Successful!!');
        return Redirect::to('all-category-post');
    }
    //END ADMIN

    //BEGIN HOME
    public function danh_muc_bai_viet (Request $request, $cate_post_slug)
    {
        $category_post = PostCategoryModels::orderBy('cate_post_id', 'DESC')->where('cate_post_status', '0')->get();

        $slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_status', '0')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();
        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $cate_post_post = PostCategoryModels::where('cate_post_slug',$cate_post_slug)->take(1)->get();
        foreach ($cate_post_post as $key=>$cate){
            $meta_desc = $cate->cate_post_desc;
            $meta_keywords = $cate->cate_post_slug;
            $meta_title ="Danh mục bài viết - ".$cate->cate_post_name;
            $cate_post_id = $cate->cate_post_id;
            $url_canonical = $request->url();
        }
        $post = PostModels::with('cate_post')->where('post_status',0)->where('cate_post_id',$cate_post_id)->get();

        return View('pages.post.category_post')->with('category', $cate_product)->with('brand', $brand_product)
		->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical)
		->with('slider',$slider)->with('category_post',$category_post)->with('post',$post);
    }
}
