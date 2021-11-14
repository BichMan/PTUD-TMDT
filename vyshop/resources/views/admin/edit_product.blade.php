@extends('admin_layout')
@section('admin_content')
<div class="row">
    <div class="col-lg-12">
        <section class="panel">
            <header class="panel-heading">
                Thêm sản phẩm
            </header>
            <div class="panel-body">
                <div class="position-center">
                    @foreach($edit_product as $key =>$product)
                    <form role="form" action="{{URL::to("/update-product/".$product->product_id)}}" method="post" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tên sản phẩm</label>
                            <input type="text" name="product_name" class="form-control" id="exampleInputEmail1" value="{{$product->product_name}}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Từ khóa</label>
                            <input type="text" style="resize: none" class="form-control" name="product_keywords" value="{{$product->meta_keywords}}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Giá sản phẩm</label>
                            <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" value="{{$product->product_price}}" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Hình ảnh sản phẩm</label>
                            <input type="file" name="product_image" class="form-control" id="exampleInputEmail1" placeholder="Hình ảnh sản phẩm">
                            <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" height="100" width="100">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Mô tả sản phẩm</label>
                            <textarea style="resize: none" rows="5" class="form-control" name="product_desc" id="ckeditor3" placeholder="Mô tả sản phẩm">{{$product->product_desc}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Nội dung sản phẩm</label>
                            <textarea style="resize: none" rows="5" class="form-control" name="product_content" id="ckeditor4" placeholder="Nội dung sản phẩm">{{$product->product_content}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Danh mục sản phẩm</label>
                            <select name="product_cate" class="form-control input-sm m-bot15">
                                @foreach($cate_product as $key => $cate)
                                @if($cate ->category_id==$product->category_id)
                                <option selected value="{{($cate ->category_id)}}">{{($cate ->category_name)}}</option>

                                @else
                                <option value="{{($cate ->category_id)}}">{{($cate ->category_name)}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Thương hiệu sản phẩm</label>
                            <select name="product_brand" class="form-control input-sm m-bot15">
                                @foreach($brand_product as $key => $brand)
                                @if($brand ->brand_id==$product->brand_id)
                                <option selected value="{{($brand ->brand_id)}}">{{($brand ->brand_name)}}</option>
                                @else
                                <option value="{{($brand ->brand_id)}}">{{($brand ->brand_name)}}</option>
                                @endif
                                @endforeach
                            </select>
                        </div>
                        {{-- <div class="form-group">
                            <label for="exampleInputEmail1">Hiển thị</label>
                            <select name="product_status" class="form-control input-sm m-bot15">
                                <option value="1">Hiển thị</option>
                            </select>
                        </div> --}}
                        <button type="submit" name="add_product" class="btn btn-info">Cập nhật sản phẩm</button>
                        <?php
                        $message = Session::get('message'); //get lấy message đã put
                        if($message){
                        echo '<span class="text-alter">',$message.'</span>';
                        Session::put('message',null);
                        }
                        ?>
                    </form>

                    @endforeach
                </div>
            </div>
        </section>
    </div>
</div>
@endsection