@extends('layouts.backend')


@section('judul1')
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2 row">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $title1 }}</h1>
        </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-outline card-primary">
                <!-- /.card-header -->

                @foreach ($bumdes as $item)
                <div class="card-header">
                    <h2 class="card-title">Detail Bumdes Number : {{$item->id}}</h2>
                    <div class="card-tools">
                        <a href="/bumdes" type="button" class="btn btn-secondary btn-sm btn-flat">
                            <i class="fa fa-undo"></i>Back
                        </a>
                    </div>
                <!-- /.card-tools -->
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <address>
                                Name        : {{$item->name}}<br>
                                Region      : {{$item->region->name}}<br>
                                Address     : {{$item->address}}<br>
                                Latitude    : {{$item->latitude}}<br>
                                Longitude   : {{$item->longitude}}<br>
                                Phone       : {{$item->phone}}<br>
                            </address>
                        </div>
                        <div class="col-sm-6">
                            <label>Avatar</label>
                            <div class="form-group">
                                <img src="{{ asset('avatar')}}/{{ $item->avatar}}" width="500px">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label>Background</label>
                            <div class="form-group">
                                <img src="{{ asset('background')}}/{{ $item->background}}" width="500px">
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <!-- /.card-body -->
            </div>
         <!-- /.card -->
        </div>
    </div>
</div>

        <script>
            $(function () {
              $("#example1").DataTable({
                "responsive": true,
                "autoWidth": false,
              });
              $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
              });
            });
        </script>

@endsection
