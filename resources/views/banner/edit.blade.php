@extends('layouts.backend')


@section('judul1')
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2 row">
        <div class="col-sm-6">
            <h1 class="m-0"> {{$title1 }}</h1>
        </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@section('content')
<div class="col-md-6">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
        </div>
        <form action="/banner/update/{{$banner->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Name</label>
                                <input name="name" class="form-control" value="{{ $banner->name}}">
                                <div class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Description</label>
                                <input name="description" class="form-control" value="{{ $banner->description}}">
                                <div class="text-danger">
                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Image</label>
                                <input type="file" name="img" class="form-control" accept="image/png/jpg">
                            <div class="text-danger">
                                @error('img')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                                <img src="{{ asset('img')}}/{{ $banner->img}}" width="500px">
                        </div>
                    </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info"><i class="fas fa-save"></i> Simpan</button>
                <a href="/banner" class="float-right btn btn-warning">Cancel</a>
            </div>
        </form>
    </div>
</div>

@endsection
