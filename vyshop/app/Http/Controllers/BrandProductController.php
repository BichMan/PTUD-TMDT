<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\BrandProductModels;
use App\Models\SliderModels;
use App\Models\PostCategoryModels;
use App\Models\PostModels;
use App\Models\ProductModels;
use Brian2694\Toastr\Facades\Toastr;
use Validate;

session_start();

class BrandProductController extends Controller
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
    public function add_brand_product()
    {
        $this->Auth_Login();
        return view('admin.brand_product.add_brand_product');
    }

    public function all_brand_product()
    {
        $this->Auth_Login();
        $all_brand_product = BrandProductModels::orderby('brand_id', 'desc')->paginate(4);
        $manager_brand_product = view('admin.brand_product.all_brand_product')->with('all_brand_product', $all_brand_product);
        return view('admin_layout')->with('admin.brand_product.all_brand_product', $manager_brand_product);
    }

    public function save_brand_product(Request $request)
    {
        $this->Auth_Login();

        // $data = $request->all();
        $data = $request->validate([
			'brand_name' => 'required|unique:tbl_brand',
			'brand_keywords' => 'required',
            'brand_desc' => 'required',
			'brand_status' => 'required',
		], [
			'brand_name.unique' => 'Tên thương hiệu sản phẩm đã tồn tại.',
			'brand_name.required' => ' Thêm tên thương hiệu.',
			'brand_desc.required' => ' Thêm mô tả thương hiệu.',
			'brand_keywords.required' => ' Thêm slug thương hiệu.',
		]);
        $brand = new BrandProductModels();
        $brand->brand_name = $data['brand_name'];
        $brand->brand_desc = $data['brand_desc'];
        $brand->brand_status = $data['brand_status'];
        $brand->meta_keywords = $data['brand_keywords'];
        $brand->save();

        // Session::put('message','Thêm thương hiệu sản phẩm thành công');
        Toastr::success('Thêm thương hiệu thành công', 'Successful!!');
        return redirect()->back();
    }

    public function active_brand_product($brand_product_id)
    {
        $this->Auth_Login();
        DB::table('tbl_brand')->where('brand_id', $brand_product_id)->update(['brand_status' => 0]);
        // Session::put('message', 'Kích hoạt hiển thị thương hiệu sản phẩm thành công');
        Toastr::success('Hiển thị thương hiệu thành công', 'Successful!!');
        return redirect()->back();
    }

    public function unactive_brand_product($brand_product_id)
    {
        DB::table('tbl_brand')->where('brand_id', $brand_product_id)->update(['brand_status' => 1]);
        // Session::put('message', 'Kích hoạt ẩn thương hiệu sản phẩm thành công');
        Toastr::success('Ẩn thương hiệu thành công', 'Successful!!');
        return redirect()->back();
    }

    public function delete_brand_product($brand_product_id)
    {
        $this->Auth_Login();
        DB::table('tbl_brand')->where('brand_id', $brand_product_id)->delete();
        // Session::put('message', 'Xóa thương hiệu sản phẩm thành công');
        Toastr::success('Xóa thương hiệu thành công', 'Successful!!');
        return redirect()->back();
    }

    public function edit_brand_product($brand_product_id)
    {
        $this->Auth_Login();
        // $edit_brand_product = DB::table('tbl_brand')->where('brand_id',$brand_product_id)->get();
        $edit_brand_product = BrandProductModels::where('brand_id', $brand_product_id)->get();
        $manager_brand_product = view('admin.brand_product.edit_brand_product')->with('edit_brand_product', $edit_brand_product);
        return view('admin_layout')->with('admin.brand_product.edit_brand_product', $manager_brand_product);
    }
    public function update_brand_product(Request $request, $brand_product_id)
    {
        $this->Auth_Login();
        $data = $request->validate([
			'brand_name' => 'required',
			'brand_desc' => 'required',
			'brand_keywords' => 'required',
		], [
			// 'brand_name.unique' => 'Tên thương hiệu sản phẩm đã tồn tại.',
			'brand_name.required' => ' Thêm tên thương hiệu.',
			'brand_desc.required' => ' Thêm mô tả thương hiệu.',
			'brand_keywords.required' => ' Thêm slug thương hiệu.'
		]);
        $brand = BrandProductModels::find($brand_product_id);
        $brand->brand_name = $data['brand_name'];
        $brand->brand_desc = $data['brand_desc'];
        $brand->meta_keywords = $data['brand_keywords'];
        $brand->save();

        Toastr::success('Cập nhật thương hiệu thành công', 'Successful!!');
        return Redirect::to('all-brand-product');
    }

    //End Admin Brand
    //Begin Brand Home
    public function Brand_Home($meta_keywords, Request $request)
    {
        $category_post = PostCategoryModels::orderBy('cate_post_id', 'DESC')->where('cate_post_status', '0')->get();

        $slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_status', '0')->take(4)->get();

        $cate_product = DB::table('tbl_category_product')->where('category_status', '0')->orderby('category_id', 'desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status', '0')->orderby('brand_id', 'desc')->get();

        // $brand_by_id = DB::table('tbl_product')->join('tbl_brand', 'tbl_product.brand_id', '=', 'tbl_brand.brand_id')->where('tbl_product.meta_keywords', $meta_keywords)->get();

        $brand_pro_meta = BrandProductModels::where('meta_keywords', $meta_keywords)->take(1)->get();

        foreach ($brand_pro_meta as $key => $val) {
            $meta_desc = $val->brand_desc;
            $meta_keywords = $val->meta_keywords;
            $brand_pro_id = $val->brand_id;
            $meta_title = "Thương hiệu - " . $val->brand_name;
            $url_canonical = $request->url();
        }
        $brand_by_id = ProductModels::with('brand_product')->where('product_status', 0)->where('brand_id', $brand_pro_id)->get();

        $brand_name = DB::table('tbl_brand')->where('tbl_brand.meta_keywords', $meta_keywords)->limit(1)->get();
        return view('pages.brand.brand_home')->with('category', $cate_product)->with('brand', $brand_product)->with('brand_by_id', $brand_by_id)->with('brand_name', $brand_name)
            ->with('slider', $slider)->with('category_post', $category_post)
            ->with('meta_desc', $meta_desc)->with('meta_keywords', $meta_keywords)
            ->with('meta_title', $meta_title)->with('url_canonical', $url_canonical);
    }
}
