@extends('layout_cart')
@section('cart_content')
    <div class="features_items">
        <h2 class="title text-center">{{ $meta_title }}</h2>
        @foreach ($post as $key => $p)
            <a href="{{ URL::to('/bai-viet/' . $p->post_slug) }}">
                <div class="product-image-wrapper">
                    <div class="single-products">
                        <div class="productinfo" style="margin:10px">
                            <img style="width:25%;height:160px;float: left; padding:5px"
                                src="{{ URL::to('public/uploads/post/' . $p->post_image) }}"
                                alt="{{ $p->post_slug }}" />
                            <h4>{{ $p->post_title }}</h4>
                            <p>{{ $p->post_desc }}</p>
                            <div class="productinfo text-right">
                                <a href="{{ URL::to('/bai-viet/' . $p->post_slug) }}" value="Xem bài viết">Xem bài
                                    viết</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
            </a>
        @endforeach
    </div>
@endsection
