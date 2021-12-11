@extends('layout')
@section('content')
    <div class="features_items">
        <h2 class="title text-center">Sản phẩm bạn đang tìm</h2>
        @foreach ($search_product as $key => $product)
            <a href="{{ URL::to('/chi-tiet-san-pham/' . $product->meta_keywords) }}">
                <div class="col-sm-4">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <form action="{{ URL::to('/save-cart') }}" method="post">
                                    {{ csrf_field() }}
                                    <img src="{{ URL::to('public/uploads/product/' . $product->product_image) }}" alt="" />
                                    <input name="productid_hidden" type="hidden" value="{{ $product->product_id }}" />
                                    <input name="qty" type="hidden" value="1" />
                                    <h2>{{ number_format($product->product_price) . ' ' . 'vnđ' }}</h2>
                                    <p>{{ $product->product_name }}</p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
