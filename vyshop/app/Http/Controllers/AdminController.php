<?php

namespace App\Http\Controllers;

use App\Models\AdminModels;
use App\Models\SocialModels;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Rules\CaptchaRule;
use Validator;
use Laravel\Socialite\Facades\Socialite;
use Brian2694\Toastr\Facades\Toastr;
use App\Models\StatisticModels;

session_start();

class AdminController extends Controller
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
	public function index()
	{
		$admin_id = Session::get('admin_id');
		if ($admin_id) {
			return Redirect::to('dashboard');
		} else {
			return view('admin_login');
		}
	}
	public function show_dashboard()
	{
		$this->Auth_Login();
		return view('admin.dashboard');
	}
	public function dashboard(Request $request)
	{

		// $data = $request->all();
		$data = $request->validate([
            'admin_email' => 'required',
            'admin_password' => 'required',
            // 'admin_password' => 'required|password|min8',
           'g-recaptcha-response' => new CaptchaRule(), 		//dòng kiểm tra Captcha
        ]);

		$admin_email = $data['admin_email'];
		$admin_password = md5($data['admin_password']);

		$login = AdminModels::where('admin_email', $admin_email)->where('admin_password', $admin_password)->first();
		// $login_count = $login->count();
		if ($login) {
			Session::put('admin_name', $login->admin_name);
			Session::put('admin_id', $login->admin_id);
			return Redirect::to('/dashboard');
		} else{
			// Toastr::error('Mật khẩu hoặc tài khoản sai. Vui lòng nhập lại', 'Cảnh báo!!');
			Session::put('message', 'Mật khẩu hoặc tài khoản sai. Vui lòng nhập lại');
			return Redirect::to('/admin');
		}

	}
	public function logout()
	{
		$this->Auth_Login();
		Session::put('admin_name', null);
		Session::put('admin_id', null);
		return Redirect::to('/admin');
	}

	//Login facebook
	public function login_facebook()
	{
		return Socialite::driver('facebook')->redirect();
	}

	public function callback_facebook()
	{
		$provider = Socialite::driver('facebook')->user();
		$account = SocialModels::where('provider', 'facebook')->where('provider_user_id', $provider->getId())->first();
		if ($account) {
			//login in vao trang quan tri
			$account_name = AdminModels::where('admin_id', $account->user)->first();
			Session::put('admin_name', $account_name->admin_name);
			Session::put('admin_id', $account_name->admin_id);
			return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
		} else {

			$admin_login = new SocialModels([
				'provider_user_id' => $provider->getId(),
				'provider' => 'facebook',
			]);

			$orang = AdminModels::where('admin_email', $provider->getEmail())->first();

			if (!$orang) {
				$orang = AdminModels::create([
					'admin_name' => $provider->getName(),
					'admin_email' => $provider->getEmail(),
					'admin_password' => '',
					'admin_phone' => '',

				]);
			}
			//thêm account mới và lấy account đó ktra
			$admin_login->login()->associate($orang);
			$admin_login->save();

			$account_name = AdminModels::where('admin_id', $admin_login->user)->first();

			Session::put('admin_name', $admin_login->admin_name);
			Session::put('admin_id', $admin_login->admin_id);
			return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
		}
	}

	//Login Google
	public function login_google()
	{
		return Socialite::driver('google')->redirect();
	}
	public function callback_google()
	{
		$users = Socialite::driver('google')->user();
		// return $users->id;
		$authUser = $this->findOrCreateUser($users, 'google'); //lấy $user các trường từ google lấy về id, name và email, google là provider
		if ($authUser) {
			$account_name = AdminModels::where('admin_id', $authUser->user)->first();
			Session::put('admin_name', $account_name->admin_name);
			Session::put('admin_id', $account_name->admin_id);
			return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');
		} elseif (!$authUser) {
			$account_name = AdminModels::where('admin_id', $authUser->user)->first();
			Session::put('admin_name', $account_name->admin_name);
			Session::put('admin_id', $account_name->admin_id);
			return redirect('/dashboard')->with('message', 'Đăng nhập Admin thành công');

		}
	}
	public function findOrCreateUser($users, $provider)
	{
		$authUser = SocialModels::where('provider_user_id', $users->id)->first();
		//nếu đã tồn tại ng dùng có id provider_user_id thì trả về $authUser -> đã đăng nhập
		if ($authUser) {

			return $authUser;
		} else {
			//nếu chưa đăng nhập thêm dữ liệu
			$customer_new = new SocialModels([
				'provider_user_id' => $users->id,
				'provider' => strtoupper($provider) //strtoupper() chuyển upcase in hoa
			]);

			$orang = AdminModels::where('admin_email', $users->email)->first();

			//nếu chưa có khai báo và thêm vào
			if (!$orang) {
				$orang = AdminModels::create([
					'admin_name' => $users->name,
					'admin_email' => $users->email,
					'admin_password' => '',
					'admin_phone' => '',
				]);
			}
			$customer_new->login()->associate($orang); //lấy khóa chính từ admin_id thêm vào user

			$customer_new->save();
			return $customer_new;
		}
	}
	public function filter_by_date(Request $request)
	{
		$data = $request->all();
		$from_date = $data['from_date'];
		$to_date = $data['to_date'];
		$get = StatisticModels::whereBetween('order_date',[$from_date, $to_date])->orderBy('order_date','ASC')->get();

		foreach ($get as $key =>$val){
			$chart_data[] = array(
				'period' => $val->order_date,
				'order' => $val->total_order,
				'sales' => $val->sales,
				'profit' => $val->profit,
				'quantity' => $val->quantity

			);
		}
		echo $data = json_encode($chart_data);
	}
}
