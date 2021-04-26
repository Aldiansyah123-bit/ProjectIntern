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
        <form action="/umkm/update/{{$umkm->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Name</label>
                                <input name="name" class="form-control" value="{{ $umkm->name}}">
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
                                <input name="description" class="form-control" value="{{ $umkm->description}}">
                                <div class="text-danger">
                                    @error('description')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label>Region</label>
                                <select id="regions" name="region_id" class="form-control">
                                    <option value="">--Name Region--</option>
                                </select>
                                <div class="text-danger">
                                    @error('region_id')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Address</label>
                                <input name="address" class="form-control" value="{{ $umkm->address}}">
                                <div class="text-danger">
                                    @error('address')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Latitude</label>
                                <input name="latitude" class="form-control" value="{{ $umkm->latitude}}">
                                <div class="text-danger">
                                    @error('latitude')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Longitude</label>
                                <input name="longitude" class="form-control" value="{{ $umkm->longitude}}">
                                <div class="text-danger">
                                    @error('longitude')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Phone Number</label>
                                <input name="phone" class="form-control" value="{{ $umkm->phone}}">
                                <div class="text-danger">
                                    @error('phone')
                                        {{ $message }}
                                    @enderror
                                </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Avatar</label>
                                <input type="file" name="avatar" class="form-control" accept="image/png">
                            <div class="text-danger">
                                @error('avatar')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label>Background</label>
                                <input type="file" name="background" class="form-control" accept="image/png">
                            <div class="text-danger">
                                @error('background')
                                    {{ $message }}
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                                <img src="{{ asset('avatar')}}/{{ $umkm->avatar}}" width="300px">
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="form-group">
                                <img src="{{ asset('background')}}/{{ $umkm->background}}" width="300px">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info"><i class="fas fa-save"></i> Simpan</button>
                <a href="/bumdes" class="float-right btn btn-warning">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    // CSRF Token
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

      $( "#regions" ).select2({
        ajax: {
          url: "{{route('region.getRegion')}}",
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
