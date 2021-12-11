@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê đơn hàng
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox"><i></i>
                                </label>
                            </th>
                            <th>Tên người đặt hàng</th>
                            <th>Tổng tiền</th>
                            <th>Tình trạng đơn hàng</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- get dữ liệu --}}
                        @foreach ($all_order as $key => $order)

                            <tr>
                                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"></label></td>
                                <td>{{ $order->customer_name }}</td>
                                <td>{{ $order->order_total }}</td>
                                <td>
                                    @if ($order->order_status == 0)
                                    <p>Đang xử lý</p>
                                    @elseif ($order->order_status == 1)
                                    <p>Đã giao hàng</p>
                                    @else
                                    <p>Đơn hàng đã hủy</p>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ URL::to('/view-order/' . $order->order_id) }}" class="active styling-edit">
										<i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
