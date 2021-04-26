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
        <form action="/product/create" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>UMKM</label>
                                <select id="umkms" name="umkm_id" class="form-control">
                                    <option value="">--Name Umkm--</option>
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
                                <input name="name" class="form-control" placeholder="name">
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
                                <input name="description" class="form-control" placeholder="Description">
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
                                <input name="price" class="form-control" placeholder="Price">
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
                                <input name="stok" class="form-control" placeholder="Stok">
                                <div class="text-danger">
                                    @error('stok')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Img</label>
                                <input type="file" name="img" class="form-control" accept="image/png">
                            <div class="text-danger">
                                @error('img')
                                    {{ $message }}
                                @enderror
                            </div>
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
