@extends('layout_cart')
@section('cart_content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                    <li class="active">Thông tin đặt hàng</li>
                </ol>
            </div>
            <div class="review-payment">
                <h2>Bạn đã đặt hàng thành công và đơn hàng của bạn đang được xử lý!</h2>
                <h2>Cảm ơn đã chọn chúng tôi!</h2>
            </div>

        </div>
    </section>
@endsection
