@extends('layout')
@section('content')
    <section id="form">
        <!--form-->
        <div class="container">
            <div class="row">
                <div class="col-sm-5">
                    <div class="login-form">
                        <!--login form-->
                        <h2>Nhập Email lấy lại mật khẩu</h2>
                        <form action="{{ URL::to('/recover-pass') }}" method="POST">
                            @csrf
                            <input type="email" name="email_account" placeholder="E-MAIL" required />
                            <button type="submit" class="btn btn-default">Gửi</button>
                        </form>
                    </div>
                    <!--/login form-->
                </div>
            </div>
        </div>
    </section>
    <!--/form-->

@endsection
