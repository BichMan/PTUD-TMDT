<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Models\BrandProductModels;
session_start();

class BrandProductController extends Controller
{
    public function Auth_Login(){
        $admin_id = Session::get('admin_id');
        if($admin_id){
            return Redirect::to('dashboard');
        }else{
            return Redirect::to('admin')->send();
        }

    }
    public function add_brand_product(){
        $this->Auth_Login();
        return view ('admin.add_brand_product');
    }

    public function all_brand_product(){
        $this->Auth_Login();
        // $all_brand_product = DB::table('tbl_brand')->get();
        //static hướng đối tượng
        // $all_brand_product = BrandProductModels::all(); take(1)///lấy 1 thương hiệu
        $all_brand_product = BrandProductModels::orderby('brand_id','desc')->get();
        $manager_brand_product = view('admin.all_brand_product')->with('all_brand_product',$all_brand_product);
        return view('admin_layout')->with('admin.all_brand_product',$manager_brand_product);
    }

    public function save_brand_product(Request $request){
        $this->Auth_Login();
        // $data = array();
        // $data['brand_name'] = $request->brand_product_name; //brand_name tên cột
        // $data['brand_desc'] = $request->brand_product_desc;
        // $data['brand_status'] = $request->brand_product_status;
        // $data['meta_keywords'] = $request->brand_product_keywords;
        // DB::table('tbl_brand')->insert($data);
        $data = $request->all();
        $brand = new BrandProductModels();
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->brand_status = $data['brand_product_status'];
        $brand->meta_keywords = $data['brand_product_keywords'];
        $brand->save();

        Session::put('message','Thêm thương hiệu sản phẩm thành công');
        return Redirect::to('add-brand-product'); //Trở về trang all-brand-product
    }

    public function active_brand_product($brand_product_id){
        $this->Auth_Login();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id) ->update(['brand_status'=>0]);
        Session::put('message','Kích hoạt hiển thị thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

    public function unactive_brand_product($brand_product_id){
        DB::table('tbl_brand')->where('brand_id',$brand_product_id) ->update(['brand_status'=>1]);
        Session::put('message','Kích hoạt ẩn thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

    public function delete_brand_product($brand_product_id){
        $this->Auth_Login();
        DB::table('tbl_brand')->where('brand_id',$brand_product_id) ->delete();
        Session::put('message','Xóa thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

    public function edit_brand_product($brand_product_id){
        $this->Auth_Login();
        // $edit_brand_product = DB::table('tbl_brand')->where('brand_id',$brand_product_id)->get();
        $edit_brand_product = BrandProductModels::where('brand_id',$brand_product_id)->get();
        $manager_brand_product = view('admin.edit_brand_product')->with('edit_brand_product',$edit_brand_product);
        return view('admin_layout')->with('admin.edit_brand_product',$manager_brand_product);
    }
    public function update_brand_product(Request $request, $brand_product_id){
        $this->Auth_Login();
        // $data = array();
        // $data['brand_name'] = $request->brand_product_name;
        // $data['brand_desc'] = $request->brand_product_desc;
        // $data['meta_keywords'] = $request->brand_product_keywords;

        $data = $request->all();
        $brand = BrandProductModels::find($brand_product_id);
        $brand->brand_name = $data['brand_product_name'];
        $brand->brand_desc = $data['brand_product_desc'];
        $brand->meta_keywords = $data['brand_product_keywords'];
        $brand->save();

        // DB::table('tbl_brand')->where('brand_id',$brand_product_id) ->update($data);
        Session::put('message','Cập nhật thương hiệu sản phẩm thành công');
        return Redirect::to('all-brand-product');
    }

//End Admin Brand
//Begin Brand Home
     public function Brand_Home($brand_id, Request $request){
        $cate_product = DB::table('tbl_category_product')->where('category_status','0')->orderby('category_id','desc')->get();

        $brand_product = DB::table('tbl_brand')->where('brand_status','0')->orderby('brand_id','desc')->get();

        $brand_by_id = DB::table('tbl_product')->join('tbl_brand','tbl_product.brand_id','=','tbl_brand.brand_id')->where('tbl_product.brand_id',$brand_id)->get();

        $brand_name= DB::table('tbl_brand')->where('tbl_brand.brand_id',$brand_id)->limit(1)->get();

        foreach($brand_product as $key => $val){
            $meta_desc = $val->brand_desc;
            $meta_keywords = $val->meta_keywords;
            $meta_title = "Thương hiệu - ".$val->brand_name;
            $url_canonical =$request->url();
        }

        return view('pages.brand.brand_home')->with('category',$cate_product)->with('brand',$brand_product)->with('brand_by_id',$brand_by_id)->with('brand_name',$brand_name)
        ->with('meta_desc',$meta_desc)->with('meta_keywords',$meta_keywords)->with('meta_title',$meta_title)->with('url_canonical',$url_canonical);
    }
}
