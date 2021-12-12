@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Cập nhật bài viết
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
                        @foreach ($post as $key => $value_post)
                            <form role="form" action="{{ URL::to('/update-post/' . $value_post->post_id) }}" method="post"
                                enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Tên bài viết</label>
                                    <input type="text" name="post_title" value="{{ $value_post->post_title }}"
                                        class="form-control" onkeyup="ChangeToSlug();" id="slug" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Slug</label>
                                    <input type="text" name="post_slug" value="{{ $value_post->post_slug }}"
                                        class="form-control" id="convert_slug" >
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Hình ảnh bài viết</label>
                                    <input type="file" name="post_image" class="form-control" >
                                    <img src="{{ URL::to('public/uploads/post/' . $value_post->post_image) }}"
                                        height="100" width="100">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Tóm tắt bài viết</label>
                                    <textarea style="resize: none" rows="5" value="" class="form-control" name="post_desc"
                                        >{{ $value_post->post_desc }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Nội dung bài viết</label>
                                    <textarea style="resize: none" rows="5" class="form-control" value=""
                                        name="post_content" id="ckeditor10"
                                        >{{ $value_post->post_content }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Meta từ khóa </label>
                                    <textarea style="resize: none" rows="5" class="form-control" value=""
                                        name="post_meta_keywords"
                                        >{{ $value_post->post_meta_keywords }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Meta nội dung </label>
                                    <textarea style="resize: none" rows="5" class="form-control" value=""
                                        name="post_meta_desc" >{{ $value_post->post_meta_desc }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Danh mục bài viết</label>
                                    <select name="cate_post_id" class="form-control input-sm m-bot15">
                                        @foreach ($cate_post as $key => $cate)
                                            <option
                                                {{ $cate->cate_post_id == $value_post->cate_post_id ? 'selected' : '' }}
                                                value="{{ $cate->cate_post_id }}">{{ $cate->cate_post_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <button type="submit" name="update_post" class="btn btn-info">Cập nhật bài viết</button>
                            </form>
                        @endforeach
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
