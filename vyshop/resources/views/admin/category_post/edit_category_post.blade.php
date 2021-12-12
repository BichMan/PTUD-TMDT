@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật danh mục bài viết
                </header>
                <div class="panel-body">
                    @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    @foreach ($edit_category_post as $key => $edit_value)
                        <div class="position-center">
                            <form role="form" action="{{ URL::to('/update-category-post/' . $edit_value->cate_post_id) }}"
                                method="post">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên danh mục</label>
                                    <input type="text" value="{{ $edit_value->cate_post_name }}" name="cate_post_name"
                                        class="form-control" onkeyup="ChangeToSlug();" id="slug" placeholder="Enter email"
                                        >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Slug</label>
                                    <input type="text" value="{{ $edit_value->cate_post_slug }}" class="form-control"
                                        name="cate_post_slug" id="convert_slug" id="ckeditor6">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Mô tả danh mục</label>
                                    <textarea style="resize: none" rows="5" class="form-control" name="cate_post_desc"
                                        >
                                {{ $edit_value->cate_post_desc }}
                                </textarea>
                                </div>
                                <button type="submit" name="update_category_post" class="btn btn-info">Cập nhật danh
                                    mục</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </section>
        </div>
    </div>
@endsection
