@extends('layout')
@section('content')
@foreach($product_details as $key => $product_details)
<div class="product-details"><!--product-details-->
<div class="col-sm-5">
	<div class="view-product">
		<img src="{{URL::to('/public/uploads/product/'.$product_details->product_image)}}" alt="" />
		<h3>ZOOM</h3>
	</div>
	<div id="similar-product" class="carousel slide" data-ride="carousel">
		
		<!-- Wrapper for slides -->
		<div class="carousel-inner">
			<div class="item active">
				<a href=""><img style="width:90px;height:100px;" src="{{URL::to('/public/frontend/images/similar.jpg')}}" alt=""></a>
				<a href=""><img style="width:90px;height:100px;" src="{{URL::to('/public/frontend/images/similar.jpg')}}" alt=""></a>
				<a href=""><img style="width:90px;height:100px;" src="{{URL::to('/public/frontend/images/similar.jpg')}}" alt=""></a>
			</div>
		</div>
		<!-- Controls -->
		<a class="left item-control" href="#similar-product" data-slide="prev">
			<i class="fa fa-angle-left"></i>
		</a>
		<a class="right item-control" href="#similar-product" data-slide="next">
			<i class="fa fa-angle-right"></i>
		</a>
	</div>
</div>
<div class="col-sm-7">
	<div class="product-information"><!--/product-information-->
	<img src="images/product-details/new.jpg" class="newarrival" alt="" />
	<h2>{{$product_details->product_name}}</h2>
	<p>ID sản phẩm: {{$product_details->product_id}}</p>
	<img src="{{URL::to('/public/frontend/images/rating.png')}}" alt="" />
	<form action="{{URL::to('/save-cart')}}" method="POST">
		{{ csrf_field() }}
		<span>
			<span>{{number_format($product_details->product_price).' '.'VND'}}</span>
			<label>Số lượng:</label>
			<input name="qty" type="number" min="1" value="1" />
			<input name="productid_hidden" type="hidden" value="{{$product_details->product_id}}" />
			<button type="submit" class="btn btn-fefault cart">
			<i class="fa fa-shopping-cart"></i>
			+ Giỏ hàng
			</button>
		</span>
	</form>
	<p><b>Tình trạng:</b> Còn hàng</p>
	<p><b>Điều kiện:</b> New</p>
	<p><b>Thương hiệu:</b> {{$product_details->brand_name}}</p>
	<p><b>Danh mục:</b> {{$product_details->category_name}}</p>
	<a href=""><img src="{{URL::to('/public/frontend/images/share.png')}}" class="share img-responsive"  alt="" /></a>
	</div><!--/product-information-->
</div>
</div><!--/product-details-->
<div class="category-tab shop-details-tab"><!--category-tab-->
<div class="col-sm-12">
	<ul class="nav nav-tabs">
		<li class="active"><a href="#details" data-toggle="tab">Chi tiết sản phẩm</a></li>
		<li><a href="#reviews" data-toggle="tab">Đánh giá(5)</a></li>
	</ul>
</div>
<div class="tab-content">
	<div class="tab-pane fade active in" id="details" >
		<p>{!!$product_details->product_desc!!}</p>
		<p>{!!$product_details->product_content!!}</p> {{-- Vì nội dụng có ký tự đặc biệt nên sẽ in lý tự đó--}}
	</div>
	
	<div class="tab-pane fade" id="reviews" >
		<div class="col-sm-12">
			<ul>
				<li><a href=""><i class="fa fa-user"></i>EUGEN</a></li>
				<li><a href=""><i class="fa fa-clock-o"></i>12:41</a></li>
				<li><a href=""><i class="fa fa-calendar-o"></i>2021</a></li>
			</ul>
			<p><b>Write Your Review</b></p>
			
			<form action="#">
				<span>
					<input type="text" placeholder="Your Name"/>
					<input type="email" placeholder="Email Address"/>
				</span>
				<textarea name="" ></textarea>
				<b>Rating: </b> <img src="{{URL::to('/public/frontend/images/rating.png')}}" alt="" />
				<button type="button" class="btn btn-default pull-right">
				Submit
				</button>
			</form>
		</div>
	</div>
	
</div>
</div><!--/category-tab-->
@endforeach
<div class="recommended_items"><!--recommended_items-->
<h2 class="title text-center">Sản phẩm liên quan<h2>
{{-- <div id="recommended-item-carousel" class="carousel slide" data-ride="carousel"> --}}
	{{-- <div class="carousel-inner"> --}}
{{-- 		<div class="item active"> --}}
			@foreach($relate as $key =>$related)
			<a href="{{URL::to('/chi-tiet-san-pham/'.$related->product_id)}}">
				<div class="col-sm-4">
					<div class="product-image-wrapper">
						<div class="single-products">
							<div class="productinfo text-center">
								<img src="{{URL::to('public/uploads/product/'.$related->product_image)}}" alt="" />
								<h2>{{number_format($related->product_price).' '.'vnđ'}}</h2>
								<p>{{($related->product_name)}}</p>
								<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
							</div>
						</div>
					</div>
				</div>
			</a>
			@endforeach
		{{-- </div> --}}
		{{-- <div class="item">
			@foreach($relate as $key =>$related)
			<a href="{{URL::to('/chi-tiet-san-pham/'.$related->product_id)}}">
				<div class="col-sm-4">
					<div class="product-image-wrapper">
						<div class="single-products">
							<div class="productinfo text-center">
								<img src="{{URL::to('public/uploads/product/'.$related->product_image)}}" alt="" />
								<h2>{{number_format($related->product_price).' '.'vnđ'}}</h2>
								<p>{{($related->product_name)}}</p>
								<a href="#" class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Thêm giỏ hàng</a>
							</div>
						</div>
					</div>
				</div>
			</a>
			@endforeach
		</div> --}}
{{-- 	</div>
	<a class="left recommended-item-control" href="#recommended-item-carousel" data-slide="prev">
		<i class="fa fa-angle-left"></i>
	</a>
	<a class="right recommended-item-control" href="#recommended-item-carousel" data-slide="next">
		<i class="fa fa-angle-right"></i>
	</a>
</div> --}}
</div><!--/recommended_items-->
@endsection