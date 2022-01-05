@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê danh mục Bài viết
            </div>
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox"><i></i>
                                </label>
                            </th>
                            <th>Tên danh mục bài viết</th>
                            <th>Hiển thị</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- get dữ liệu --}}
                        @foreach ($all_category_post as $key => $all_cate_post)
                            <tr>
                                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                                </td>
                                <td>{{ $all_cate_post->cate_post_name }}</td>
                                <td><span class="text-ellipsis">
                                        <?php
								if($all_cate_post->cate_post_status ==0){
							?>
                                        <a href="{{ URL::to('/unactive-category-post/' . $all_cate_post->cate_post_id) }}"><span
                                                class=" fa-thumbs-styling fa fa-eye"></span></a>
                                        <?php
								}else{
							?>
                                        <a href="{{ URL::to('/active-category-post/' . $all_cate_post->cate_post_id) }}"><span
                                                class="fa-thumbs-styling fa fa-eye-slash"></span></a>
                                        <?php
							}
							?>
                                    </span></td>
                                <td>
                                    <a href="{{ URL::to('/edit-category-post/' . $all_cate_post->cate_post_id) }}"
                                        class="active styling-edit" ui-toggle-class="">
                                        <i class="fa fa-pencil-square-o text-success text-active"></i></a>
                                    <a onclick="return confirm('Bạn có chắc rằng muốn xóa mục này?')"
                                        href="{{ URL::to('/delete-category-post/' . $all_cate_post->cate_post_id) }}"
                                        class="active styling-edit" ui-toggle-class="">
                                        <i class="fa fa-times text-danger text"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <footer class="panel-footer">
                <div class="row">
                    <div class="col-sm-5 text-left">
                        <ul class="pagination pagination-sm m-t-none m-b-none">
                            {!! $all_category_post->links('paginate') !!}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
