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
<meta name="csrf-token" content="{{ csrf_token() }}">

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="{{asset('select2/dist/css/select2.min.css')}}">

<!-- Script -->
<script src="{{asset('select2/jquery-3.4.1.js')}}" type="text/javascript"></script>
<script src="{{asset('select2/dist/js/select2.min.js')}}" type="text/javascript"></script>
<div class="col-md-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
        </div>
        <form action="/product/update/{{$product->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>UMKM</label>
                                <select id="umkms" name="umkm_id" class="form-control">
                                    <option value="{{ $product->umkm->name}}">--Name Umkm--</option>
                                </select>
                                <div class="text-danger">
                                    @error('umkm_id')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Name</label>
                                <input name="name" class="form-control" value="{{ $product->name}}">
                                <div class="text-danger">
                                    @error('name')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Description</label>
                                <input name="description" class="form-control" value="{{ $product->description}}">
                                <div class="text-danger">
                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Price</label>
                                <input name="price" class="form-control" value="{{$product->price}}">
                                <div class="text-danger">
                                    @error('price')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Stok</label>
                                <input name="stok" class="form-control" value="{{ $product->stok}}">
                                <div class="text-danger">
                                    @error('stok')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Image</label>
                                <input type="file" name="img" class="form-control" accept="image/png/jpg">
                            <div class="text-danger">
                                @error('img')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div><br>
                    <div class="col-sm-6">
                        <label>Image</label>
                        <div class="form-group">
                                <img src="{{ asset('img')}}/{{ $product->img}}" width="300px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info"><i class="fas fa-save"></i> Simpan</button>
                <a href="/product" class="float-right btn btn-warning">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

      $( "#umkms" ).select2({
        ajax: {
          url: "{{route('product.getProduct')}}",
          type: "post",
          dataType: 'json',
          delay: 250,
          data: function (params) {
            return {
              _token: CSRF_TOKEN,
              search: params.term // search term
            };
          },
          processResults: function (response) {
            return {
              results: response
            };
          },
          cache: true
        }

      });

    });
</script>

@endsection
