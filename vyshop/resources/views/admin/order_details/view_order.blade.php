@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Thông tin đơn hàng và quá trình vận chuyển
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th>Tên người nhận</th>
                            <th>Số điện thoại</th>
                            <th>Địa chỉ</th>
                            <th>Ghi chú</th>
                            <th>Tên sản phẩm</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng tiền</th>
                            <th>Tình trạng</th>
                            <th>Thanh toán</th>
                            <th style="width:30px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- get dữ liệu --}}
                        <tr>
                            <td>{{ $order_by_id->shipping_name }}</td>
                            <td>{{ $order_by_id->shipping_phone }}</td>
                            <td>{{ $order_by_id->shipping_address }}</td>
                            <td>{{ $order_by_id->shipping_note }}</td>
                            <td>
                                @foreach ($order_pro as $key => $pro)
                                    <li style="list-style-type: none;">{{ $pro->product_name }}</li>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($order_pro as $key => $pro)
                                    <li style="list-style-type: none;">{{ $pro->product_sales_quatity }}</li>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($order_pro as $key => $pro)
                                    <li style="list-style-type: none;">{{ $pro->product_price }}</li>
                                @endforeach
                            </td>
                            <td>{{ $order_by_id->order_total }}</td>
                            <td>
                                @if ($order_by_id->order_status == 0)
                                    <p>Chờ xử lý</p>
                                @elseif ($order_by_id->order_status == 1)
                                    <p>Đang đóng gói</p>
                                @elseif ($order_by_id->order_status == 2)
                                    <p>Đã chuyển giao đến đơn vị vẫn chuyển</p>
                                @elseif ($order_by_id->order_status == 3)
                                    <p>Đã giao hàng thành công</p>
                                @else
                                    <p>Đơn hàng đã hủy</p>
                                @endif
                            </td>
                            <td>{{ $order_by_id->payment_status }}</td>
                            <td>
                                <a href="{{ URL::to('/edit-order-status/' . $order_by_id->order_id) }}"
                                    class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-pencil-square-o text-success text-active"></i>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
