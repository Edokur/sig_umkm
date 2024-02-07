@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Laporan Hasil</li>
    </ol>
</nav>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Laporan Hasil</h6>
    </div>
    <div class="card-body">

        <!-- tabal untuk Hasil Perhitungan cluster Mikro-->
        <h4 class="font-weight-boldr">Usaha Mikro</h4>
        <table  class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Data</th>
                    <th>Omset Per Tahun</th>
                    <th>Nilai Asset Perusahaan</th>
                    <th>Cluster</th>
                </tr>
            </thead>
            <tbody class="text-small">
                <?php $no_mikro = 1; ?>
                @foreach ($mikros as $item)
                    <tr>
                        <td class="text-center">{{ $no_mikro++; }}</td>
                        <td>{{ $item->nama_umkm }}</td>
                        <td>@currency($item->omset )</td>
                        <td>@currency($item->asset)</td>
                        <td>{{ $item->klasifikasi_usaha }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr>
        <!-- tabal untuk Hasil Perhitungan cluster Kecil-->
        <h4>Usaha Kecil</h4>
        <table  class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Data</th>
                    <th>Omset Per Tahun</th>
                    <th>Nilai Asset Perusahaan</th>
                    <th>Cluster</th>
                </tr>
            </thead>
            <tbody class="text-small">
                <?php $no_kecil = 1; ?>
                @foreach ($kecils as $item)
                    <tr>
                        <td class="text-center">{{ $no_kecil++ }}</td>
                        <td>{{ $item->nama_umkm }}</td>
                        <td>@currency($item->omset )</td>
                        <td>@currency($item->asset)</td>
                        <td>{{ $item->klasifikasi_usaha }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <hr>
        <!-- tabal untuk Hasil Perhitungan cluster Menengah-->
        <h4>Usaha Menengah</h4>
        <table  class="table table-bordered" id="dataTable" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Data</th>
                    <th>Omset Per Tahun</th>
                    <th>Nilai Asset Perusahaan</th>
                    <th>Cluster</th>
                </tr>
            </thead>
            <tbody class="text-small">
                <?php $no_menengah = 1; ?>
                @foreach ($menengahs as $item)
                    <tr>
                        <td class="text-center">{{ $no_menengah++ }}</td>
                        <td>{{ $item->nama_umkm }}</td>
                        <td>@currency($item->omset )</td>
                        <td>@currency($item->asset)</td>
                        <td>{{ $item->klasifikasi_usaha }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection
@push('script')
    <script>
        // $(document).ready(function() {
        //     $('#dataTable').DataTable();
        // });
    </script>   
@endpush