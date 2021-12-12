<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\CategoryProductModels;
use App\Models\SliderModels;
use App\Models\ProductModels;
use App\Models\PostCategoryModels;


session_start();

class CategoryProductController extends Controller
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
    public function add_category_product()
    {
        $this->Auth_Login();
        return view('admin.category_product.add_category_product');
    }

    public function all_category_product()
    {
        $this->Auth_Login();
        $all_category_product = DB::table('tbl_category_product')->orderby('category_id', 'desc')->paginate(4);
        $manager_category_product = view('admin.category_product.all_category_product')->with('all_category_product', $all_category_product);
        return view('admin_layout')->with('admin.category_product.all_category_product', $manager_category_product);
    }

    public function save_category_product(Request $request)
    {
        $this->Auth_Login();
        // $data = $request->all();
        $data = $request->validate([
			'category_product_name' => 'required|unique:tbl_category_product,category_name',
			'category_product_keywords' => 'required',
            'category_product_desc' => 'required',
			'category_product_status' => 'required',
		], [
			'category_product_name.unique' => 'Tên danh mục sản phẩm đã tồn tại.',
			'category_product_name.required' => ' Thêm tên danh mục.',
			'category_product_desc.required' => ' Thêm mô tả danh mục.',
			'category_product_keywords.required' => ' Thêm slug danh mục.'
		]);
        $category = new CategoryProductModels();
        $category->category_name = $data['category_product_name'];
        $category->category_desc = $data['category_product_desc'];
        $category->category_status = $data['category_product_status'];
        $category->meta_keywords = $data['category_product_keywords'];
        $category->save();

        // Session::put('message','Thêm danh mục sản phẩm thành công');
        Toastr::success('Thêm sản danh mục thành công', 'Successful!!');
        return redirect()->back();
    }

    public function active_category_product($category_product_id)
    {
        $this->Auth_Login();
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->update(['category_status' => 0]);
        // Session::put('message', 'Kích hoạt hiển thị danh mục sản phẩm thành công');
        Toastr::success('Hiển thị danh mục thành công', 'Successful!!');
        return redirect()->back();
    }

    public function unactive_category_product($category_product_id)
    {
        $this->Auth_Login();
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->update(['category_status' => 1]);
        // Session::put('message', 'Kích hoạt ẩn danh mục sản phẩm thành công');
        Toastr::success('Ẩn danh mục thành công', 'Successful!!');
        return redirect()->back();
    }

    public function delete_category_product($category_product_id)
    {
        $this->Auth_Login();
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->delete();
        // Session::put('message', 'Xóa danh mục sản phẩm thành công');
        Toastr::success('Thêm sản phẩm thành công', 'Successful!!');
        return redirect()->back();
    }

    public function edit_category_product($category_product_id)
    {
        $this->Auth_Login();
        $edit_category_product = DB::table('tbl_category_product')->where('category_id', $category_product_id)->get();
        $manager_category_product = view('admin.category_product.edit_category_product')->with('edit_category_product', $edit_category_product);
        return view('admin_layout')->with('admin.category_product.edit_category_product', $manager_category_product);
    }
    public function update_category_product(Request $request, $category_product_id)
    {
        $this->Auth_Login();
        $data = $request->validate([
			'category_product_name' => 'required',
			'category_product_desc' => 'required',
			'category_product_keywords' => 'required',
		], [
			// 'category_product_name.unique' => 'Tên danh mục sản phẩm đã tồn tại.',
			'category_product_name.required' => ' Thêm tên danh mục.',
			'category_product_desc.required' => ' Thêm mô tả danh mục.',
			'category_product_keywords.required' => ' Thêm slug danh mục.'
		]);
        $category = CategoryProductModels::find($category_product_id);
        $category->category_name = $data['category_product_name'];
        $category->category_desc = $data['category_product_desc'];
        $category->meta_keywords = $data['category_product_keywords'];
        $category->save();

        // Session::put('message', 'Cập nhật danh mục sản phẩm thành công');
        Toastr::success('Cập nhật danh mục thành công', 'Successful!!');

        return Redirect::to('all-category-product');
    }

    //End Admin Pages
    //Begin Category Home pages
    public function Category_Home($meta_keywords, Request $request)
    {
        $category_post = DB::table('tbl_category_post')->where('cate_post_status','0')->get();
		$slider = SliderModels::orderBy('slider_id','DESC')->where('slider_status','0')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        // $category_by_id = DB::table('tbl_product')->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')->where('tbl_product.category_id', $category_id)->get();

        $cate_pro_meta = CategoryProductModels::where('meta_keywords', $meta_keywords)->take(1)->get();

        foreach ($cate_pro_meta as $key => $val) {
            $meta_desc = $val->category_desc;
            $meta_keywords = $val->meta_keywords;
            $cate_pro_id = $val->category_id;
            $meta_title = "Danh mục - " . $val->category_name;
            $url_canonical = $request->url();
        }

        $category_by_id = ProductModels::with('category_product')->where('product_status', 0)->where('category_id', $cate_pro_id)->get();
        $category_name = DB::table('tbl_category_product')->where('tbl_category_product.category_id', $cate_pro_id)->limit(1)->get();

        return view('pages.category.category_home')->with('slider',$slider)->with('category_post',$category_post)
            ->with('category', $cate_product)->with('brand', $brand_product)
            ->with('category_by_id', $category_by_id)->with('category_name', $category_name)
            ->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)->with('url_canonical', $url_canonical);
    }
}
