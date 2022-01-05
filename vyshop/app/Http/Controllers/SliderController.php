<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SliderModels;
use Illuminate\Support\Facades\Redirect;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class SliderController extends Controller
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
    public function manage_slider()
    {
        $all_slider = SliderModels::orderBy('slider_id', 'DESC')->paginate(4);
        return view('admin.slider.list_slider')->with(compact('all_slider'));
    }
    public function filter_admin_banner(Request $request)
    {
        $this->Auth_Login();
        $keywords = $request->keywords_filter;
        if ($keywords == '0') {
            $all_slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_status',0)->paginate(20);
            return view('admin.slider.list_slider')->with(compact('all_slider'));
        }
        if ($keywords == '1') {
            $all_slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_status',1)->paginate(20);
            return view('admin.slider.list_slider')->with(compact('all_slider'));
        } else {
            Toastr::warning('Hãy chọn thông tin cần lọc!!');
            return redirect()->back();
        }
    }
    public function search_admin_banner(Request $request)
    {
        $this->Auth_Login();
        $keywords = $request->keywords_search;
        if ($keywords != '') {
            $all_slider = SliderModels::orderBy('slider_id', 'DESC')->where('slider_name', 'like', '%' . $keywords . '%')->paginate(20);
            return view('admin.slider.list_slider')->with(compact('all_slider'));
        } else {
            Toastr::warning('Hãy nhập từ khóa tìm kiếm!!');
            return redirect()->back();
        }
    }

    public function add_slider()
    {
        return view('admin.slider.add_slider');
    }
    public function insert_slider(Request $request)
    {
        $data = $request->all();
        $this->Auth_Login();

        $get_image = $request->file('slider_image');

        if ($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.', $get_name_image)); //lấy tên trước dấu chấm
            $new_image = $name_image . rand(0, 99) . '.' . $get_image->getClientOriginalExtension(); //đuôi . mở rộng của ảnh
            //rand tránh trùng tên ảnh khi upload
            $get_image->move('public/uploads/slider', $new_image); //di chuyển upload

            $slider = new SliderModels();
            $slider->slider_name = $data['slider_name'];
            $slider->slider_image = $new_image;
            $slider->slider_desc = $data['slider_desc'];
            $slider->slider_status = $data['slider_status'];
            $slider->save();
            // Session::put('message', 'Thêm sản phẩm thành công');
            Toastr::success('Thêm slider thành công', 'Successful!!');
            return Redirect::to('manage-slider'); //Trở về trang all-product
        } else {
            // Session::put('message', 'Thêm sản phẩm thành công');
            Toastr::warning('Vui lòng thêm ảnh', 'Cảnh báo!!');
            return Redirect::to('manage-slider'); //Trở về trang all-product
        }
    }

    public function unactive_slider($slider_id)
    {
        $this->Auth_Login();
        DB::table('tbl_slider')->where('slider_id', $slider_id)->update(['slider_status' => 1]);
        // Session::put('message', 'Kích hoạt ẩn sản phẩm thành công');
        Toastr::success('Ẩn slider thành công', 'Successful!!');
        return Redirect::to('manage-slider');
    }
    public function active_slider($slider_id)
    {
        $this->Auth_Login();
        DB::table('tbl_slider')->where('slider_id', $slider_id)->update(['slider_status' => 0]);
        // Session::put('message', 'Kích hoạt hiển thị sản phẩm thành công');
        Toastr::success('Hiển thị slider thành công', 'Successful!!');
        return Redirect::to('manage-slider');
    }

    public function delete_slider($slider_id)
    {
        $this->Auth_Login();
        DB::table('tbl_slider')->where('slider_id', $slider_id)->delete();
        // Session::put('message', 'Xóa sản phẩm thành công');
        Toastr::success('Xóa slider thành công', 'Successful!!');
        return Redirect::to('manage-slider');
    }
}
