@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê bài viết
            </div>
            <div class="row w3-res-tb">
                <div class="col-sm-5 m-b-xs">
                    <form role="form" action="{{ URL::to('/filter-admin-post/') }}" method="post">
                        @csrf
                        <select name="keywords_filter" class="input-sm form-control w-sm inline v-middle">
                            <option selected disabled>Lọc bài viết</option>
                            <option value="0">Hiển thị</option>
                            <option value="1">Ẩn</option>
                        </select>
                        <button class="btn btn-sm btn-default">Lọc</button>
                    </form>
                </div>
                <div class="col-sm-4">
                </div>
                <div class="col-sm-3">
                    <form role="form" action="{{ URL::to('/search-admin-post/') }}" method="post">
                        @csrf
                        <div class="input-group">
                            <input type="text" class="input-sm form-control" name="keywords_search" placeholder="Search">
                            <span class="input-group-btn">
                                <button class="btn btn-sm btn-default">Tìm kiếm</button>
                            </span>
                        </div>
                    </form>
                </div>
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
                            <th>Tên bài viết</th>
                            <th>Hình ảnh</th>
                            <th>Mô tả </th>
                            <th>Danh mục</th>
                            <th>Hiển thị</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- get dữ liệu --}}
                        @foreach ($all_post as $key => $post)
                            <tr>
                                <td><label class="i-checks m-b-none"><input type="checkbox" name="post"><i></i></label>
                                </td>
                                <td style="width:300px">{{ $post->post_title }}</td>
                                <td style="width:400px">{{ $post->post_desc }}</td>
                                <td><img src="public/uploads/post/{{ $post->post_image }}" height="100" width="200"></td>
                                <td>@foreach ($cate_post as $key => $cate)
                                    @if($cate->cate_post_id == $post->cate_post_id)
                                        {{ $cate->cate_post_name }}
                                    @endif
                                @endforeach</td>
                                <td><span class="text-ellipsis">
                                        <?php
								if($post->post_status ==0){
							?>
                                        <a href="{{ URL::to('/unactive-post/' . $post->post_id) }}"><span
                                                class=" fa-thumbs-styling fa fa-eye"></span></a>
                                        <?php
								}else{
							?>
                                        <a href="{{ URL::to('/active-post/' . $post->post_id) }}"><span
                                                class="fa-thumbs-styling fa fa-eye-slash"></span></a>
                                        <?php
							}
							?>
                                    </span></td>
                                <td>
                                    <a href="{{ URL::to('/edit-post/' . $post->post_id) }}" class="active styling-edit"
                                        ui-toggle-class="">
                                        <i class="fa fa-pencil-square-o text-success text-active"></i></a>
                                    <a onclick="return confirm('Bạn có chắc rằng muốn xóa mục này?')"
                                        href="{{ URL::to('/delete-post/' . $post->post_id) }}" class="active styling-edit"
                                        ui-toggle-class="">
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
                            {!! $all_post->links('paginate') !!}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
