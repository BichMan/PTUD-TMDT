<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\CategoryProductModels;
use App\Models\SliderModels;

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
        return view('admin.add_category_product');
    }

    public function all_category_product()
    {
        $this->Auth_Login();
        $all_category_product = DB::table('tbl_category_product')->get();
        $manager_category_product = view('admin.all_category_product')->with('all_category_product', $all_category_product);
        return view('admin_layout')->with('admin.all_category_product', $manager_category_product);
    }

    public function save_category_product(Request $request)
    {
        $this->Auth_Login();
        // $data = array();
        // $data['category_name'] = $request->category_product_name; //category_name tên cột
        // $data['category_desc'] = $request->category_product_desc;
        // $data['category_status'] = $request->category_product_status;
        // $data['meta_keywords'] = $request->category_product_keywords;
        // DB::table('tbl_category_product')->insert($data);

        $data = $request->all();
        $category = new CategoryProductModels();
        $category->category_name = $data['category_product_name'];
        $category->category_desc = $data['category_product_desc'];
        $category->category_status = $data['category_product_status'];
        $category->meta_keywords = $data['category_product_keywords'];
        $category->save();

        // Session::put('message','Thêm danh mục sản phẩm thành công');
        Toastr::success('Thêm sản danh mục thành công', 'Successful!!');
        return Redirect::to('add-category-product'); //Trở về trang all-category-product
    }

    public function active_category_product($category_product_id)
    {
        $this->Auth_Login();
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->update(['category_status' => 0]);
        // Session::put('message', 'Kích hoạt hiển thị danh mục sản phẩm thành công');
        Toastr::success('Hiển thị danh mục thành công', 'Successful!!');
        return Redirect::to('all-category-product');
    }

    public function unactive_category_product($category_product_id)
    {
        $this->Auth_Login();
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->update(['category_status' => 1]);
        // Session::put('message', 'Kích hoạt ẩn danh mục sản phẩm thành công');
        Toastr::success('Ẩn danh mục thành công', 'Successful!!');
        return Redirect::to('all-category-product');
    }

    public function delete_category_product($category_product_id)
    {
        $this->Auth_Login();
        DB::table('tbl_category_product')->where('category_id', $category_product_id)->delete();
        // Session::put('message', 'Xóa danh mục sản phẩm thành công');
        Toastr::success('Thêm sản phẩm thành công', 'Successful!!');
        return Redirect::to('all-category-product');
    }

    public function edit_category_product($category_product_id)
    {
        $this->Auth_Login();
        $edit_category_product = DB::table('tbl_category_product')->where('category_id', $category_product_id)->get();
        $manager_category_product = view('admin.edit_category_product')->with('edit_category_product', $edit_category_product);
        return view('admin_layout')->with('admin.edit_category_product', $manager_category_product);
    }
    public function update_category_product(Request $request, $category_product_id)
    {
        $this->Auth_Login();
        // $data = array();
        // $data['category_name'] = $request->category_product_name;
        // $data['category_desc'] = $request->category_product_desc;
        // $data['meta_keywords'] = $request->category_product_keywords;
        // DB::table('tbl_category_product')->where('category_id',$category_product_id) ->update($data);

        $data = $request->all();
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
    public function Category_Home($category_id, Request $request)
    {
		$slider = SliderModels::orderBy('slider_id','DESC')->where('slider_status','0')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        $category_by_id = DB::table('tbl_product')->join('tbl_category_product', 'tbl_product.category_id', '=', 'tbl_category_product.category_id')->where('tbl_product.category_id', $category_id)->get();

        $category_name = DB::table('tbl_category_product')->where('tbl_category_product.category_id', $category_id)->limit(1)->get();

        foreach ($category_by_id as $key => $val) {
            $meta_desc = $val->category_desc;
            $meta_keywords = $val->meta_keywords;
            $meta_title = "Danh mục - " . $val->category_name;
            $url_canonical = $request->url();
        }

        return view('pages.category.category_home')->with('slider',$slider)
            ->with('category', $cate_product)->with('brand', $brand_product)
            ->with('category_by_id', $category_by_id)->with('category_name', $category_name)
            ->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)->with('url_canonical', $url_canonical);
    }
}
