@extends('admin_layout')
@section('admin_content')
    <div class="table-agile-info">
        <div class="panel panel-default">
            <div class="panel-heading">
                Liệt kê Slider
            </div>
            {{-- <div class="row w3-res-tb">
			<div class="col-sm-5 m-b-xs">
				<select class="input-sm form-control w-sm inline v-middle">
					<option value="0">Bulk action</option>
					<option value="1">Delete selected</option>
					<option value="2">Bulk edit</option>
					<option value="3">Export</option>
				</select>
				<button class="btn btn-sm btn-default">Apply</button>
			</div>
			<div class="col-sm-4">
			</div>
			<div class="col-sm-3">
				<div class="input-group">
					<input type="text" class="input-sm form-control" placeholder="Search">
					<span class="input-group-btn">
						<button class="btn btn-sm btn-default" type="button">Go!</button>
					</span>
				</div>
			</div>
		</div> --}}
            <div class="table-responsive">
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox"><i></i>
                                </label>
                            </th>
                            <th>Tên Slide</th>
                            <th>Hình ảnh</th>
                            <th>Mô tả</th>
                            <th>Trạng thái</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- get dữ liệu --}}
                        @foreach ($all_slider as $key => $slider)
                            <tr>
                                <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]"><i></i></label>
                                </td>
                                <td>{{ $slider->slider_name }}</td>
                                <td><img src="public/uploads/slider/{{ $slider->slider_image }}" height="100" width="350">
                                </td>
                                <td>{{ $slider->slider_desc }}</td>
                                <td><span class="text-ellipsis">
                                        <?php
								if($slider->slider_status ==0){
							?>
                                        <a href="{{ URL::to('/unactive-slider/' . $slider->slider_id) }}"><span
                                                class=" fa-thumbs-styling fa fa-thumbs-up"></span></a>
                                        <?php
								}else{
							?>
                                        <a href="{{ URL::to('/active-slider/' . $slider->slider_id) }}"><span
                                                class="fa-thumbs-styling fa fa-thumbs-down"></span></a>
                                        <?php
							}
							?>
                                    </span></td>
                                <td>
                                    <a onclick="return confirm('Bạn có chắc rằng muốn xóa mục này?')"
                                        href="{{ URL::to('/delete-slider/' . $slider->slider_id) }}"
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
                            {!! $all_slider->links() !!}
                        </ul>
                    </div>
                </div>
            </footer>
        </div>
    </div>
@endsection
