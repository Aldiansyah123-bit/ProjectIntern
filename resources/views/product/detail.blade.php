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

<div class="card card-solid">
    <div class="card-body">
        <div class="row">
            @foreach ($product as $item)
            <div class="col-12 col-sm-6">
                <div class="col-12">
                <img src="{{ asset('img') }}/{{ $item->img }}" class="product-image" alt="Product Image">
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <h3 class="my-3">{{ $item->name }}</h3>
                    <p>{{ $item->description }}</p>
                <hr>
                    <h4>{{ $item->umkm->name }}</h4>
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <b class="text-red">
                        Stok : {{ $item->price }}
                    </b>
                </div>
                    <div class="bg-gray py-2 px-3 mt-4">
                        <h2 class="mb-0">
                            Rp. {{number_format($item->price)}}
                        </h2>
                    </div>

                    <div class="mt-4">
                        <a href="/product" type="button" class="btn btn-warning btn-lg btn-flat">
                            <i class="fas fa-undo fa-lg mr-2"></i>
                            Back
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
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
