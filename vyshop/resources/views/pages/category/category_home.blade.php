@extends('layout')
@section('content')
    <div class="features_items">
        @foreach ($category_name as $key => $category_name)
            <h2 class="title text-center">{{ $category_name->category_name }}</h2>
        @endforeach

        @foreach ($category_by_id as $key => $product)
            <a name="subscribe"></a>
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
                                    <button type="submit" class="btn btn-default add-to-cart">
                                        <a><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @endforeach
    </div>
@endsection
