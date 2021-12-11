@extends('layout_cart')
@section('cart_content')
    <section id="form">
        <!--form-->
        <a name="subscribe"></a>
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <div class="login-form">
                        <!--login form-->
                        <h2>Đăng nhập tài khoản</h2>
                        <form action="{{ URL::to('/login-customer') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="email" name="email_account" placeholder="E-MAIL" required />
                            <input type="password" name="password_account" placeholder="Password" required />
                            <?php
                            $message = Session::get('message'); //get lấy message đã put
                            if ($message) {
                                echo '<a>', $message . '</a>';
                                Session::put('message', null); //nếu tồn tại mới in nếu không message null
                            }
                            ?>
                            <br>
                            {{-- <span>
								<a href="{{URL::to('/quen-mat-khau')}}">Quên mật khẩu?</a>
							</span> --}}
                            <button type="submit" class="btn btn-default">Đăng nhập</button>
                        </form>
                    </div>
                    <!--/login form-->
                </div>
                <div class="col-sm-1">
                    <h2 class="or">Hoặc</h2>
                </div>
                <div class="col-sm-6">
                    <div class="signup-form">
                        <!--sign up form-->
                        <h2>Đăng ký tài khoản</h2>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ URL::to('/add-customer') }}" method="POST">
                            {{ csrf_field() }}
                            <input type="text" name="customer_name" placeholder="Họ và tên" />
                            <input type="email" name="customer_email" placeholder="E-MAIL" />
                            <input type="password" name="customer_password" placeholder="Mật khẩu" />
                            <input type="number" name="customer_phone" placeholder="Phone" />
                            <?php
                            $message_signup = Session::get('message_signup'); //get lấy message đã put
                            if ($message_signup) {
                                echo '<a>', $message_signup . '</a>';
                                Session::put('message_signup', null); //nếu tồn tại mới in nếu không message null
                            }
                            ?>
                            <button type="submit" class="btn btn-default">Đăng ký</button>
                        </form>
                    </div>
                    <!--/sign up form-->
                </div>
            </div>
        </div>
    </section>
    <!--/form-->

@endsection
