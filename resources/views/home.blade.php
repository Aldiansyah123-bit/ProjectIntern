@extends('layouts.backend')

@section('judul1')
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2 row">
        <div class="col-sm-6">
            <h1 class="m-0">{{ $title }}</h1>
        </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
@endsection
@section('content')
<link rel="stylesheet" href="{{ asset('css/backend.css') }}">
    <!-- BAR CHART -->
<div class="card card-success">
    <div class="card-body">
        <div class="chart">
            <div id="transactions"></div>
        </div>
    </div>
</div>
<div class="content-header">
    <div class="container-fluid">
        <div class="mb-2 row">
            <div class="col-sm-6">
                <h1 class="m-0">Statistik</h1>
            </div>
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
<div class="content">
    <div class="container-fluid">
       <div class="row">
            <div class="col-lg-3 col-6">
                <div class="backgroundproduct">
                    <div class="inner">
                        <br>
                        <p class="staticheader">Penjualan hari Ini</p>
                        <h3 class="staticnumber">150</h3>
                        <p class="staticparap">Product</p>
                        <p class="staticpening">Mengalami Peningkanan 10% Dari Kemarin</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="backgroundnewpesan">
                    <div class="inner">
                        <br>
                        <p class="staticheader">Anda Mulai</p>
                        <h3 class="staticnumber">150</h3>
                        <p class="staticparap">Pesanan Baru</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="backgroundumkm">
                    <div class="inner">
                        <br>
                        <p class="staticheader">Sebanyak</p>
                        <h3 class="staticnumber">150</h3>
                        <p class="staticparap">UMKM</p>
                        <p class="staticpening"><b>Telah Terdaftar</b></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-6">
                <div class="backgroundpesan1">
                    <div class="inner">
                        <br>
                        <p class="staticheader">Anda Mulai</p>
                        <h3 class="staticnumber">150</h3>
                        <p class="staticparap">Pesanan Baru</p>
                    </div>
                </div>
            </div>
       </div>
    </div><!-- /.container-fluid -->
</div>
<br>
<br>

<script>
    Highcharts.chart('transactions', {
    chart: {
        type: 'spline'
    },
    title: {
        text: 'Grafik Penjualan BlanjaUMKM'
    },
    subtitle: {
        text: ''
    },
    xAxis: {
        categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
    },
    yAxis: {
        title: {
            text: ''
        },
        labels: {
            formatter: function () {
                return this.value + '%';
            }
        }
    },
    tooltip: {
        crosshairs: true,
        shared: true
    },
    plotOptions: {
        spline: {
            marker: {
                radius: 4,
                lineColor: '#666666',
                lineWidth: 1
            }
        }
    },
    series: [{
        name: 'Pertahun',
        marker: {
            symbol: ''
        },
        data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, {
            y: 26.5,
        }, 23.3, 18.3, 13.9, 9.6]

    }]
});
  </script>

@endsection

