@extends('layouts.backend')


@section('judul1')
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2 row">
        <div class="col-sm-6">
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

                @foreach ($cart as $item)
                <div class="card-header">
                    <h2 class="card-title">Detail Cart Number : {{$item->id}}</h2>
                    <div class="card-tools">
                        <a href="/cart" type="button" class="btn btn-secondary btn-sm btn-flat">
                            <i class="fa fa-undo"></i>Back
                        </a>
                    </div>
                <!-- /.card-tools -->
                </div>

                <div class="card-body">
                    <div class="detail-info">
                        <div class="mt-2">
                            <div class="table-responsive mailbox-messages">
                                <div class="col-sm-4 invoice-col">
                                    <b>Number : {{$item->id}}</b>
                                        <address>
                                            Name      : {{$item->user->name}}<br>
                                            UMKM      : {{$item->umkm->name}}<br>
                                            Bumdes    : {{$item->bumdes->name}}<br>
                                            Checkout  : {{$item->is_checkout}}<br>
                                        </address>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th class="text-center">Name</th>
                                <th class="text-center">Product Name</th>
                                <th class="text-center">Amount</th>
                                <th class="text-center">Flag</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($cartdetails as $data)
                                <tr>
                                    <td>{{ $data->cart->user->name }}</td>
                                    <td>{{ $data->product->name }}</td>
                                    <td>{{ $data->amount }}</td>
                                    <td>{{ $data->flag }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
