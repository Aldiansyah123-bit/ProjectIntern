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
        <form action="/transaction/create" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">
                <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>User</label>
                                    <select id="users" name="user_id" class="form-control">
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
                                <label>Bumdes</label>
                                    <select id="bumdes" name="bumdes_id" class="form-control">
                                        <option value="">--Name Bumdes--</option>
                                    </select>
                                    <div class="text-danger">
                                        @error('bumdes_id')
                                            {{ $message }}
                                        @enderror
                                    </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Invoice Number</label>
                                    <input name="invoice_number" class="form-control" placeholder="Invoice Number">
                                    <div class="text-danger">
                                        @error('invoice_number')
                                            {{ $message }}
                                        @enderror
                                    </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Address</label>
                                    <input name="address" class="form-control" placeholder="Address">
                                    <div class="text-danger">
                                        @error('address')
                                            {{ $message }}
                                        @enderror
                                    </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Total Price</label>
                                    <input name="total_price" class="form-control" placeholder="Total Price">
                                    <div class="text-danger">
                                        @error('total_price')
                                            {{ $message }}
                                        @enderror
                                    </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Discount</label>
                                    <input name="discount" class="form-control" placeholder="Discount">
                                    <div class="text-danger">
                                        @error('discount')
                                            {{ $message }}
                                        @enderror
                                    </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Voucher</label>
                                    <input name="voucher" class="form-control" placeholder="Voucher">
                                    <div class="text-danger">
                                        @error('voucher')
                                            {{ $message }}
                                        @enderror
                                    </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Noted</label>
                                    <input name="noted" class="form-control" placeholder="Noted">
                                    <div class="text-danger">
                                        @error('noted')
                                            {{ $message }}
                                        @enderror
                                    </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Status</label>
                                    <input name="status" class="form-control" placeholder="Status">
                                    <div class="text-danger">
                                        @error('status')
                                            {{ $message }}
                                        @enderror
                                    </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-info"><i class="fas fa-save"></i> Simpan</button>
                <a href="/transaction" class="float-right btn btn-warning">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">

    // CSRF User
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

      $( "#users" ).select2({
        ajax: {
          url: "{{route('cart.getAddUser')}}",
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

      $( "#umkms" ).select2({
        ajax: {
          url: "{{route('cart.getAddUmkm')}}",
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

    // CSRF Bumdes
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $(document).ready(function(){

      $( "#bumdes" ).select2({
        ajax: {
          url: "{{route('cart.getAddBumdes')}}",
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
