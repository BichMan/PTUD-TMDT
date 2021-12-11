@extends('admin_layout')
@section('admin_content')
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Thêm Slider
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
                        <form role="form" action="{{ URL::to('/insert-slider') }}" method="post"
                            enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <label for="exampleInputEmail1">Tên Slider</label>
                                <input type="text" name="slider_name" class="form-control" id="exampleInputEmail1"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Hình ảnh</label>
                                <input type="file" name="slider_image" class="form-control" id="exampleInputEmail1"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Mô tả </label>
                                <textarea style="resize: none" rows="5" class="form-control" name="slider_desc"
                                    required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Trạng thái</label>
                                <select name="slider_status" class="form-control input-sm m-bot15">
                                    <option value="0">Hiển thị</option>
                                    <option value="1">Ẩn</option>
                                </select>
                            </div>
                            <button type="submit" name="add_slider" class="btn btn-info">Thêm Slider</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
