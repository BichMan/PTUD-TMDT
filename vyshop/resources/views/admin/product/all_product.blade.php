@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê sản phẩm
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <form role="form" action="{{ URL::to('/filter-admin-product/') }}" method="post">
                        @csrf
                        <select name="keywords_filter" class="input-sm form-control w-sm inline v-middle">
                            <option selected disabled>Lọc sản phẩm</option>
                            <option value="0">Quần</option>
                            <option value="1">Áo</option>
                            <option value="2">Giày</option>
                            <option value="3">Hiển thị</option>
                            <option value="4">Ẩn</option>
                        </select>
                        <button class="btn btn-sm btn-default">Lọc</button>
                    </form>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <form role="form" action="{{ URL::to('/search-admin-product/') }}" method="post">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" name="keywords_search" placeholder="Search">
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-default">Tìm kiếm</button>
                            </span>
                        </div>
                    </form>
                </div>
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
                                                class=" fa-thumbs-styling fa fa-eye"></span></a>
                                        <?php
								}else{
							?>
                                        <a href="{{ URL::to('/active-product/' . $product->product_id) }}"><span
                                                class="fa-thumbs-styling fa fa-eye-slash"></span></a>
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
                            {!! $all_product->links('paginate') !!}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
