<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="{{ $meta_desc }}">
    <meta name="keywords" content="{{ $meta_keywords }}" />
    <meta name="robots" content="INDEX,FOLLOW" />
    <link rel="canonical" href="{{ $url_canonical }}" />
    <meta name="author" content="">
    <link rel="shortcut icon" type="image/png" href="{{ asset('public/frontend/images/icon.png') }}" />
    <title>{{ $meta_title }}</title>

    {{-- <meta property="og:image" content="{{$image_og}}" /> --}}
    <meta property="og:site_name" content="VYShop.com" />
    <meta property="og:description" content="{{ $meta_desc }}" />
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:url" content="{{ $url_canonical }}" />
    <meta property="og:type" content="website" />

    <link href="{{ asset('public/frontend/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/font-awesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/prettyPhoto.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/price-range.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('public/frontend/css/responsive.css') }}" rel="stylesheet">
    {{-- <link href="{{ asset('public/frontend/css/sweetalert.css') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">

    <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    <link rel="shortcut icon" href="{{ 'public/frontend/images/ico/favicon.ico' }}">
    <link rel="apple-touch-icon-precomposed" sizes="144x144"
        href="{{ 'images/apple-touch-icon-144-precomposed.pn' }}g">
    <link rel="apple-touch-icon-precomposed" sizes="114x114"
        href="{{ 'images/apple-touch-icon-114-precomposed.pn' }}g">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ 'images/apple-touch-icon-72-precomposed.png' }}">
    <link rel="apple-touch-icon-precomposed" href="{{ 'images/apple-touch-icon-57-precomposed.png' }}">
</head>
<!--/head-->

<body>
    <header id="header">
        <!--header-->
        <div class="header_top">
            <!--header_top-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="contactinfo">
                            <ul class="nav nav-pills">
                                <li><a><i class="fa fa-phone"></i>0385870243</a></li>
                                <li><a><i class="fa fa-envelope"></i> tranbichman2000@gmail.com</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="social-icons pull-right">
                            <ul class="nav navbar-nav">
                                <li><a href="https://www.facebook.com/shopenvy/"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="https://www.google.com.vn/"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/header_top-->
        <div class="header-bottom">
            <!--header-bottom-->
            <div class="container">
                <div class="row">
                    <div class="col-sm-8">
                        <div class="navbar-header">
                            <button type="button" class="navbar-toggle" data-toggle="collapse"
                                data-target=".navbar-collapse">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        <div class="mainmenu pull-left">
                            <ul class="nav navbar-nav collapse navbar-collapse">
                                <li><a href="{{ URL::to('/trang-chu') }}" class="active">Trang chủ</a>
                                </li>
                                <li class="dropdown"><a href="#">Sản phẩm<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach ($category as $key => $danhmuc)
                                            <li><a
                                                    href="{{ URL::to('/danh-muc-san-pham/' . $danhmuc->meta_keywords) }}">{{ $danhmuc->category_name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                                <li class="dropdown"><a href="#">Tin tức<i class="fa fa-angle-down"></i></a>
                                    <ul role="menu" class="sub-menu">
                                        @foreach ($category_post as $key => $cate_post)
                                            <li><a
                                                    href="{{ URL::to('/danh-muc-bai-viet/' . $cate_post->cate_post_slug) }}">{{ $cate_post->cate_post_name }}</a>
                                            </li>
                                        @endforeach

                                    </ul>
                                </li>
                                {{-- <li><a href="#">Liên hệ</a></li> --}}
                                <?php
                                    $customer_id =Session::get('customer_id');
                                    $shipping_id =Session::get('shipping_id');
                                    if($customer_id!=NULL && $shipping_id ==NULL)
                                    {
                                ?>
                                <li><a href="{{ URL::to('/checkout') }}"> Thanh
                                        toán</a></li>
                                {{-- điền thông tin vận chuyển --}}
                                <?php
                                    }
                                    elseif($customer_id!=NULL && $shipping_id!=NULL)
                                    {
                                ?>
                                <li><a href="{{ URL::to('/payment') }}">Thanh toán</a>
                                </li>
                                <?php
                                    }
                                    else
                                    {
                                ?>
                                <li><a href="{{ URL::to('/login-checkout') }}">Thanh toán</a></li>
                                <?php
                                    }
                                ?>

                                <li><a href="{{ URL::to('/show-cart') }}">Giỏ hàng</a></li>
                                <?php
                                    $customer_id =Session::get('customer_id');
                                    if($customer_id!=NULL){
                                ?>
                                <li><a href="{{ URL::to('/logout-checkout') }}">
                                        Đăng
                                        xuất</a></li>

                                <?php
                                    } else{
                                ?>
                                <li><a href="{{ URL::to('/login-checkout') }}">Đăng nhập</a></li>
                                <?php
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <form action="{{ URL::to('/tim-kiem') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="search_box pull-right">
                                <input type="text" name="keywords_search" placeholder="Nhập từ khóa..." />
                                <input type="submit" style="margin-top: 0; width: 80px;" name=""
                                    class="btn btn-primary btn-sm" value="Tìm kiếm">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!--/header-bottom-->
    </header>
    <!--/header-->

    <section id="slider">
        <!--slider-->
        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <div id="slider-carousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#slider-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#slider-carousel" data-slide-to="1"></li>
                            <li data-target="#slider-carousel" data-slide-to="2"></li>
                        </ol>

                        <div class="carousel-inner">
                            @php
                                $i = 0;
                            @endphp
                            @foreach ($slider as $key => $slide)
                                @php
                                    $i++;
                                @endphp
                                <div class="item {{ $i == 1 ? 'active' : '' }}">
                                    <div class="col-sm-12">
                                        <img src={{ asset('public/uploads/slider/' . $slide->slider_image) }}
                                            class="girl img-responsive" alt="{{ $slide->slider_desc }}" />
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <a href="#slider-carousel" class="left control-carousel hidden-xs" data-slide="prev">
                            <i class="fa fa-angle-left"></i>
                        </a>
                        <a href="#slider-carousel" class="right control-carousel hidden-xs" data-slide="next">
                            <i class="fa fa-angle-right"></i>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </section>
    <!--/slider-->

    <section>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <h2>Danh mục sản phẩm</h2>
                        <div class="panel-group category-products" id="accordian">
                            <!--category-productsr-->

                            @foreach ($category as $key => $cate)
                                <div class="panel panel-default">
                                    <div class="panel-heading">
                                        <h4 class="panel-title"><a
                                                href="{{ URL::to('/danh-muc-san-pham/' . $cate->meta_keywords) }}">{{ $cate->category_name }}</a>
                                        </h4>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <!--/category-products-->

                        <div class="brands_products">
                            <!--brands_products-->
                            <h2>Thương hiệu sản phẩm</h2>
                            <div class="brands-name">

                                <ul class="nav nav-pills nav-stacked">
                                    @foreach ($brand as $key => $brand)
                                        <li><a
                                                href="{{ URL::to('/thuong-hieu-san-pham/' . $brand->meta_keywords) }}">
                                                <span class="pull-right"></span>{{ $brand->brand_name }}</a>
                                        </li>
                                    @endforeach
                                </ul>

                            </div>
                        </div>
                        <!--/brands_products-->


                    </div>
                </div>
                <div class="col-sm-9 padding-right">
                    @yield('content')
                </div>
            </div>
        </div>
    </section>
    <footer id="footer">
        <!--Footer-->
        <div class="footer-widget">
            <div class="container">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="single-widget">
                            <h2>DỊCH VỤ</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a>Liên hệ chúng tôi</a></li>
                                <li><a>SĐT: 0385870244</a></li>
                                <li><a>Hoặc qua Email</a></li>
                                <li><a>tranbichman@gmail.com</a></li>
                                <li><a href="https://www.facebook.com/shopenvy">Facebook tại đây</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="single-widget">
                            <h2>GIỚI THIỆU</h2>
                            <ul class="nav nav-pills nav-stacked">
                                <li><a>Thông tin công ty</a></li>
                                <li><a>CÔNG TY THIẾT KẾ THỜI TRANG VY</a></li>
                                <li><a>HỆ THỐNG CỬA HÀNG</a></li>
                                <li><a>CN1: 218-220 Quang Trung, P.10, Q.Gò Vấp</a></li>
                                <li><a>CN2: 535 Nguyễn Tri Phương P.8 Q.10</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-4 pull-right">
                        <div class="fb-page" data-href="https://www.facebook.com/shopenvy" data-tabs="timeline"
                            data-width="500" data-height="250" data-small-header="true"
                            data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="true">
                            <blockquote cite="https://www.facebook.com/shopenvy" class="fb-xfbml-parse-ignore"><a
                                    href="https://www.facebook.com/shopenvy">ENVY</a></blockquote>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <p style="text-align: center;">Copyright © 2021 VY-SHOPPER Inc. All rights reserved.</p>
                </div>
            </div>
        </div>

    </footer>
    <!--/Footer-->
    <script src="{{ asset('public/frontend/js/jquery.js') }}"></script>
    <script src="{{ asset('public/frontend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/jquery.scrollUp.min.js') }}"></script>
    <script src="{{ asset('public/frontend/js/price-range.js') }}"></script>
    <script src="{{ asset('public/frontend/js/jquery.prettyPhoto.js') }}"></script>
    <script src="{{ asset('public/frontend/js/main.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v12.0&appId=300995878694592&autoLogAppEvents=1"
        nonce="UciBqcPi"></script>
    {{-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> --}}
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
    {{-- <script>
        $(document).ready(function(){
            $('.add-to-cart').click(function(){
                swal("Hello world!");
            });
        });
    </script> --}}
</body>

</html>
