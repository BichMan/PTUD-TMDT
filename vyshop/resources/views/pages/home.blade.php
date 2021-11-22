@extends('layout')
@section('content')
<div class="features_items">
    <h2 class="title text-center">Sản phẩm mới nhất</h2>
    @foreach($all_product as $key =>$product)
    <a href="{{URL::to('/chi-tiet-san-pham/'.$product->product_id)}}">
        <div class="col-sm-4">
            <div class="product-image-wrapper">
                <div class="single-products">
                    <div class="productinfo text-center">
                        <form action="{{ URL::to('/save-cart') }}" method="post">
                            {{ csrf_field() }}
                        <img src="{{URL::to('public/uploads/product/'.$product->product_image)}}" alt="" />
                        <input name="productid_hidden" type="hidden" value="{{ $product->product_id }}" />
                        <input name="qty" type="hidden" value= "1" />
                        <h2>{{number_format($product->product_price).' '.'vnđ'}}</h2>
                        <p>{{($product->product_name)}}</p>
                        <button type="submit" class="btn btn-default add-to-cart">
                            <a><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                        </button>
                        </form>
                    </div>
                </div>

                <div class="choose">
                    <ul class="nav nav-pills nav-justified">
                        <li><a href="#"><i class="fa fa-plus-square"></i>Yêu thích</a></li>
                        <li><a href="#"><i class="fa fa-plus-square"></i>So sánh</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </a>
    @endforeach
</div>
@endsection