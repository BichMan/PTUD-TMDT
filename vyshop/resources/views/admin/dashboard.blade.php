@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <header class="panel-heading">
            Thống kê doanh thu
        </header>
        <form autocomplete="off">
            @csrf
            <div class="col-md-2"><input type="text" class="form-control" id="datepicker" value="Từ ngày" name="datepicker"></div>
            <div class="col-md-2"><input type="text" class="form-control" id="datepicker2" value="Đến ngày" name="datepicker2"></div>
            <div class="col-md-2"><input type="button" class="btn btn-primary btn-sm" id="btn-dashboard-filter" value="Lọc kết quả"></div>
        </form>
        <div class="col-md-12">
            <div id="myfirstchart" style="height:250px;"></div>
        </div>
    </div>
    <div class="row">
        <header class="panel-heading">
            Thống kê số lượng khách hàng, đơn hàng và sản phẩm
        </header>
        <div class="col-sm-4">
            <div id="donutchart1" style="height:200px;"></div>
        </div>
        <div class="col-sm-4">
            <div id="donutchart2" style="height:200px;"></div>
        </div>
        <div class="col-sm-4">
            <div id="donutchart3" style="height:200px;"></div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-md-6">
            <div id="donutchart" style="height:250px;"></div>
        </div>
    </div> --}}

@endsection
