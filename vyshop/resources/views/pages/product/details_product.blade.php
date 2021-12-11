@extends('layout')
@section('content')
    <a name="subscribe"></a>
    <div id="fb-root"></div>
    @foreach ($product_details as $key => $productr_details)
        <div class="product-details">
            <!--product-details-->
            <div class="col-sm-5">
                <div class="view-product">
                    <img src="{{ URL::to('/public/uploads/product/' . $productr_details->product_image) }}" alt="" />
                </div>
            </div>
            <div class="col-sm-7">
                <div class="product-information">
                    <!--/product-information-->
                    <img src="images/product-details/new.jpg" class="newarrival" alt="" />
                    <h2 style="size:18sp">{{ $productr_details->product_name }}</h2>
                    <p>ID sản phẩm: {{ $productr_details->product_id }}</p>
                    <img src="{{ URL::to('/public/frontend/images/rating.png') }}" alt="" />
                    <form action="{{ URL::to('/save-cart') }}" method="POST">
                        {{ csrf_field() }}
                        <span>
                            <span>{{ number_format($productr_details->product_price) . ' ' . 'VND' }}</span>
                            <br>
                            <label>Số lượng:</label>
                            <input style="width:50px;height:50px" name="qty" type="number" min="1" value="1" />
                            <input name="productid_hidden" type="hidden" value="{{ $productr_details->product_id }}" />
                            <button type="submit" class="btn btn-fefault cart">
                                <i class="fa fa-shopping-cart"></i>
                                + Giỏ hàng
                            </button>
                        </span>
                    </form>
                    <p><b>Tình trạng:</b> Còn hàng</p>
                    {{-- <p><b>Điều kiện:</b> New</p> --}}
                    <p><b>Thương hiệu:</b> {{ $productr_details->brand_product->brand_name }}</p>
                    <p><b>Danh mục:</b> {{ $productr_details->category_product->category_name }}</p>
                    <div class="contactinfo" style="padding-left: 18px">
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
                </div>
                <!--/product-information-->
            </div>
        </div>
        <!--/product-details-->
        <div class="category-tab shop-details-tab">
            <!--category-tab-->
            <div class="col-sm-12">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#details" data-toggle="tab">Chi tiết sản phẩm</a></li>
                    <li><a href="#comment" data-toggle="tab">Bình luận</a></li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade active in" id="details">
                    <p>{!! $productr_details->product_desc !!}</p>
                    {{-- Vì nội dụng có ký tự đặc biệt nên sẽ in lý tự đó --}}
                </div>
                <div class="tab-pane fade" id="comment">
                    <div class="fb-comments" data-href="{{ $url_canonical }}" data-width="" data-numposts="5"></div>
                </div>
            </div>
        </div>
        <!--/category-tab-->
    @endforeach
    <div class="recommended_items">
        <!--recommended_items-->
        <h2 class="title text-center">Sản phẩm liên quan<h2>
                @foreach ($relate as $key => $related)
                    <a href="{{ URL::to('/chi-tiet-san-pham/' . $related->meta_keywords) }}">
                        <div class="col-sm-4">
                            <div class="product-image-wrapper">
                                <div class="single-products">
                                    <div class="productinfo text-center">
                                        <form action="{{ URL::to('/save-cart') }}" method="post">
                                            {{ csrf_field() }}
                                            <img src="{{ URL::to('public/uploads/product/' . $related->product_image) }}"
                                                alt="" />
                                            <input name="productid_hidden" type="hidden"
                                                value="{{ $related->product_id }}" />
                                            <input name="qty" type="hidden" value="1" />
                                            <h2>{{ number_format($related->product_price) . ' ' . 'vnđ' }}</h2>
                                            <p>{{ $related->product_name }}</p>
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
