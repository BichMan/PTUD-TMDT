@extends('layout_cart')
@section('cart_content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                    <li class="active">Thông tin thanh toán</li>
                </ol>
            </div>
            <!--/breadcrums-->

            <div class="register-req">
                <p>Vui lòng đăng nhập hoặc đăng ký để thanh toán giỏ hàng và xem lại giỏ hàng của bạn</p>
            </div>
            <!--/register-req-->
            <div class="shopper-informations">
                <div class="row">
                    <div class="col-sm-12 col-xs-offset-3">
                        <div class="bill-to">
                            <p>Thông tin người nhận</p>
                            <div class="form-one">
                                <form action="{{ URL::to('/save-customer') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="email" name="shipping_email" placeholder="Email" required>
                                    <input type="text" name="shipping_name" placeholder="Họ và tên" required>
                                    <input type="text" name="shipping_address" placeholder="Địa chỉ nhận hàng" required>
                                    <input type="number" name="shipping_phone" placeholder="Số điện thoại" required>
                                    <textarea name="shipping_note" placeholder="Ghi chú cho người gửi hàng" rows="4"
                                        required></textarea>
                                    <input type="submit" value="Xác nhận" name="send_oder" class="btn btn-primary btn-sm">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
    <!--/#cart_items-->
@endsection
