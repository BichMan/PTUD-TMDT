@extends('layout_cart')
@section('cart_content')
    @foreach ($post as $key => $p)
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{ URL::to('/') }}">Trang chủ</a></li>
                <li><a
                        href="{{ URL::to('/danh-muc-bai-viet/' . $p->cate_post->cate_post_slug) }}">{{ $p->cate_post->cate_post_name }}</a>
                </li>
            </ol>
        </div>
        <div class="features_items">
            <h1 class="text-left">{{ $meta_title }}</h1>

            <div class="single-products">
                {!! $p->post_content !!}
            </div>
            <div class="text-right">
                <ul class="nav nav-pills">
                    <li>
                        <div class="fb-share-button" data-href="http://localhost/vyshop/" data-layout="button_count"
                            data-size="small"><a target="_blank"
                                href="https://www.facebook.com/sharer/sharer.php?u={{ $url_canonical }};src=sdkpreparse"
                                class="fb-xfbml-parse-ignore">Chia sẻ</a></div>
                    </li>
                    <li>
                        <div class="fb-like" data-href="{{ $url_canonical }}" data-width=""
                            data-layout="button_count" data-action="like" data-size="small" data-share="false">
                        </div>
                    </li>
                </ul>
            </div>
            <div class="clearfix"></div>
        </div>
    @endforeach
@endsection
