@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê sản phẩm
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
                            <th>Tên sản phẩm</th>
                            <th>Giá </th>
                            <th>Hình ảnh</th>
                            <th>Danh mục</th>
                            <th>Thương hiệu</th>
                            <th>Hiển thị</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- get dữ liệu --}}
                        @foreach ($all_product as $key => $product)
                            <tr>
                                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                                </td>
                                <td>{{ $product->product_name }}</td>
                                <td>{{ $product->product_price }}</td>
                                <td><img src="public/uploads/product/{{ $product->product_image }}" height="100"
                                        width="100"></td>
                                <td>{{ $product->category_name }}</td>
                                <td>{{ $product->brand_name }}</td>
                                <td><span class="text-ellipsis">
                                        <?php
								if($product->product_status ==0){
							?>
                                        <a href="{{ URL::to('/unactive-product/' . $product->product_id) }}"><span
                                                class=" fa-thumbs-styling fa fa-thumbs-up"></span></a>
                                        <?php
								}else{
							?>
                                        <a href="{{ URL::to('/active-product/' . $product->product_id) }}"><span
                                                class="fa-thumbs-styling fa fa-thumbs-down"></span></a>
                                        <?php
							}
							?>
                                    </span></td>
                                <td>
                                    <a href="{{ URL::to('/edit-product/' . $product->product_id) }}"
                                        class="active styling-edit" ui-toggle-class="">
                                        <i class="fa fa-pencil-square-o text-success text-active"></i></a>
                                    <a onclick="return confirm('Bạn có chắc rằng muốn xóa mục này?')"
                                        href="{{ URL::to('/delete-product/' . $product->product_id) }}"
                                        class="active styling-edit" ui-toggle-class="">
                                        <i class="fa fa-times text-danger text"></i></a>
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
                            {!! $all_product->render() !!}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
