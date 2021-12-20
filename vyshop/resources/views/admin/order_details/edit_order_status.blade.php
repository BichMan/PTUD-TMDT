@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật tình trạng giao hàng
                </header>
                <div class="panel-body">
                    {{-- @foreach ($edit_brand_product as $key => $edit_value) --}}
                        <div class="position-center">
                            @foreach ($edit_order_status as $key => $ed)
                            <form role="form" action="{{ URL::to('/update-order-status/' . $ed->order_id) }}"
                                method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tình trạng đơn hàng</label>
                                    <select name="order_status" class="form-control input-sm m-bot15">
                                        <option value="0">Chờ xử lý</option>
                                        <option value="1">Đang đóng gói</option>
                                        <option value="2">Đã chuyển giao đến đơn vị vẫn chuyển</option>
                                        <option value="3">Đã giao hàng thành công</option>
                                        <option value="4">Hủy đơn hàng</option>
                                    </select>
                                </div>
                                <button type="submit" name="update_order_status" class="btn btn-info">Cập nhật</button>
                            </form>
                            @endforeach
                        </div>
                    {{-- @endforeach --}}
                </div>
            </section>
        </div>
    </div>
@endsection
