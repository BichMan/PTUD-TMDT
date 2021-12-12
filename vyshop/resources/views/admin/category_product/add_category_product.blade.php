@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm danh mục sản phẩm
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <form role="form" action="{{ URL::to('/save-category-product') }}" method="post">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên danh mục</label>
                                <input type="text" name="category_product_name" class="form-control"
                                    onkeyup="ChangeToSlug();" id="slug" placeholder="Enter email" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Slug</label>
                                <input type="text" class="form-control" name="category_product_keywords" id="convert_slug"
                                    placeholder="Mô tả danh mục" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả danh mục</label>
                                <textarea style="resize: none" rows="5" class="form-control" name="category_product_desc"
                                    placeholder="Mô tả danh mục" ></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">Hiển thị</label>
                                <select name="category_product_status" class="form-control input-sm m-bot15">
                                    <option value="0">Hiển thị</option>
                                    <option value="1">Ẩn</option>
                                </select>
                            </div>
                            <button type="submit" name="add_category_product" class="btn btn-info">Thêm danh mục</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
