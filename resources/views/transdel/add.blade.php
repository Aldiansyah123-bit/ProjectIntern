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
        <form action="/transdel/create" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Number Transaction</label>
                                    <select id="transactions" name="transaction_id" class="form-control">
                                        <option value="">--Name User--</option>
                                    </select>
                                    <div class="text-danger">
                                        @error('user_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Name Product</label>
                                    <select id="products" name="product_id" class="form-control">
                                        <option value="">--Name Product--</option>
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
                                <label>Amount</label>
                                    <input name="amount" class="form-control" placeholder="Amount">
                                    <div class="text-danger">
                                        @error('amount')
                                            {{ $message }}
                                        @enderror
                                    </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Flag</label>
                                    <input name="flag" class="form-control" placeholder="Flag">
                                    <div class="text-danger">
                                        @error('flag')
                                            {{ $message }}
                                        @enderror
                                    </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info"><i class="fas fa-save"></i> Simpan</button>
                <a href="/transdel" class="float-right btn btn-warning">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    // CSRF User
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

      $( "#transactions" ).select2({
        ajax: {
          url: "{{route('transdel.getTransaction')}}",
          type: "get",
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

    // CSRF Umkm
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

      $( "#products" ).select2({
        ajax: {
          url: "{{route('transdel.getProduct')}}",
          type: "get",
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
