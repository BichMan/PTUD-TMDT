@extends('layout_cart')
@section('cart_content')
    <section id="cart_items">
        <div class="container">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                    <li class="active">Thanh toán giỏ hàng</li>
                </ol>
            </div>
            <!--/breadcrums-->
            <div class="review-payment">
                <h2>Xem lại giỏ hàng</h2>
            </div>
            <div class="table-responsive cart_info">
                <?php
                $content = Cart::content();
                ?>
                <table class="table table-condensed">
                    <thead>
                        <tr class="cart_menu">
                            <td class="image">Ảnh</td>
                            <td class="description">Sản phẩm</td>
                            <td class="price">Giá</td>
                            <td class="quantity">Số lượng</td>
                            <td class="total">Tổng tiền</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($content as $v_content)
                            <tr>
                                <td class="cart_product">
                                    <a href=""><img
                                            src="{{ URL::to('public/uploads/product/' . $v_content->options->image) }}"
                                            width="50" alt=""></a>
                                </td>
                                <td class="cart_description">
                                    <h4><a href="">{{ $v_content->name }}</a></h4>
                                    {{-- <p>Web ID: 1089772</p> --}}
                                </td>
                                <td class="cart_price">
                                    <p>{{ number_format($v_content->price) . ' ' . 'vnđ' }}</p>
                                </td>
                                <td class="cart_quantity">
                                    <div class="cart_quantity_button">
                                        <form action="{{ URL::to('/update-quantity-cart') }}" method="POST">
                                            {{ csrf_field() }}
                                            <input class="cart_quantity_input" type="text" name="cart_quantity"
                                                value="{{ $v_content->qty }}" size="2">
                                            <input type="hidden" value="{{ $v_content->rowId }}" name="rowId_cart"
                                                class="form-control">
                                            <input type="submit" value="Cập nhật" name="update_qty"
                                                class="btn btn-default btn-sm">
                                        </form>
                                    </div>
                                </td>
                                <td class="cart_total">
                                    <p class="cart_total_price">
                                        <?php
                                        $subtotal = $v_content->price * $v_content->qty;
                                        echo number_format($subtotal) . ' ' . 'vnđ';
                                        ?>
                                    </p>
                                </td>
                                <td class="cart_delete">
                                    <a class="cart_quantity_delete"
                                        href="{{ URL::to('/delete-cart/' . $v_content->rowId) }}"><i
                                            class="fa fa-times"></i></a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                    <tbody>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="cart_price">
                            <p>Thành tiền: {{ Cart::total(0, ',', '.') . ' ' . 'vnđ' }}</p>
                        </td>
                    </tbody>
                </table>
            </div>

            <h4 style="margin: 50px 0;font-size: 20px;">Chọn hình thức thanh toán</h4>
            <form action="{{ URL::to('/order-place') }}" method="POST">
                {{ csrf_field() }}
                <div class="payment-options">
                    <span>
                        <label><input type="radio" name="payment_option" value="2"> Thanh toán khi nhận hàng</label>
                    </span>
                    <input type="submit" value="Đặt hàng" class="btn btn-primary btn-sm" name="send_oder_place"
                        style="margin-top:0">
                    <?php
                    $message_dathang = Session::get('message_dathang'); //get lấy message đã put
                    if ($message_dathang) {
                        echo '<a>', $message_dathang . '</a>';
                        Session::put('message_dathang', null);
                    }
                    ?>
                    <?php
                    $message_giohang = Session::get('message_giohang'); //get lấy message đã put
                    if ($message_giohang) {
                        echo '<a>', $message_giohang . '</a>';
                        Session::put('message_giohang', null);
                    }
                    ?>
                    <span>
                        @php
                            $change = Cart::total(0, ',', '');
                            $vnd_to_usd = $change / 23030;
                        @endphp
                        @if (Cart::content() == '[]')
                            <?php
                            $message_giohang = Session::get('message_giohang'); //get lấy message đã put
                            if ($message_giohang) {
                                echo '<a>', $message_giohang . '</a>';
                                Session::put('message_giohang', null);
                            }
                            ?>
                        @else
                            <div id="paypal-button"></div>
                            <input type="hidden" id="vnd_to_usd" value="{{ round($vnd_to_usd, 2) }}">
                        @endif
                    </span>
                </div>
            </form>


            {{-- @if (session()->has('route'))
                <a href="{{ URL::to('/order-place') }}">Xác nhận đã thanh toán đơn hàng</a>
            @endif --}}
        </div>
    </section>
    <!--/#cart_items-->
@endsection
