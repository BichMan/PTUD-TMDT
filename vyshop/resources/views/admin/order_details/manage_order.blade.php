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
                            <th>Thay đổi trạng thái đơn hàng</th>
                            {{-- <th>Thời gian đặt hàng</th> --}}
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- get dữ liệu --}}
                        @foreach ($all_order as $key => $order)

                            <tr>
                                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"></label></td>
                                <td>{{ $order->shipping_name }}</td>
                                <td>{{ $order->order_total }}</td>
                                <td>
                                    @if ($order->order_status == 0)
                                        <p>Chờ xử lý</p>
                                    @elseif ($order->order_status == 1)
                                        <p>Đang đóng gói</p>
                                    @elseif ($order->order_status == 2)
                                        <p>Đã chuyển giao đến đơn vị vẫn chuyển</p>
                                    @elseif ($order->order_status == 3)
                                        <p>Đã giao hàng thành công</p>
                                    @else
                                        <p>Đơn hàng đã hủy</p>
                                    @endif
                                </td>
                                <td>
                                    <form role="form" action="{{ URL::to('/update-order-status/' . $order->order_id) }}"
                                        method="post">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <select name="order_status" style="width:200px; float:left"
                                                class="form-control input-sm m-bot15">
                                                <option selected disabled></option>
                                                <option value="0">Chờ xử lý</option>
                                                <option value="1">Đang đóng gói</option>
                                                <option value="2">Đã chuyển giao đến đơn vị vẫn chuyển</option>
                                                <option value="3">Đã giao hàng thành công</option>
                                                <option value="4">Hủy đơn hàng</option>
                                            </select>
                                        </div>
                                        <button type="submit" name="update_order_status" class="btn btn-info"
                                            style="float: right">Cập nhật</button>
                                    </form>
                                </td>
                                <td>
                                    <a href="{{ URL::to('/view-order/' . $order->order_id) }}"
                                        class="active styling-edit">
                                        <i class="fa fa-eye" aria-hidden="true"></i>
                                    </a>

                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-5 text-left">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {!! $all_order->links('paginate') !!}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    {{-- <script>
        var curDate = new Date();

        // Ngày hiện tại
        var curDay = curDate.getDate();

        // Tháng hiện tại
        var curMonth = curDate.getMonth() + 1;

        // Năm hiện tại
        var curYear = curDate.getFullYear();

       // var time = curDate.getHours() + ":" + curDate.getMinutes() + ":" + curDate.getSeconds();
        // Gán vào thẻ HTML
        document.getElementById('current-time').innerHTML = curDay + "/" + curMonth + "/" + curYear;
    </script> --}}
@endsection
