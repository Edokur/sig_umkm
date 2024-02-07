@extends('layouts.app')
@section('content')

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data UMKM</li>
    </ol>
</nav>

{{-- <h1 class="h3 mb-2 text-gray-800">Data UMKM</h1> --}}

<!-- DataTales Example -->
<a class="btn btn-primary mb-3" href="/data_umkm/create">Tambah Data</a>

<button type="button" class="btn btn-success mb-3" data-toggle="modal" data-target="#importExcel">
    IMPORT EXCEL
</button>

<!-- Import Excel -->
<div class="modal fade" id="importExcel" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <form method="post" action="/data_umkm/import_excel" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">IMPORT EXCEL</h5>
                    
                </div>
                <div class="modal-body">
                    <h6>Silahkan Download Template File Excel dibawah ini</h6>
                    <a href="{{ asset('admin_assets/file/Template_UMKM.xlsx') }}" download>
                        <p>Template_Excel</p>
                    </a>
                    @csrf
                    <label>Pilih File Excel</label>
                    <div class="form-group">
                        <input type="file" name="file" required="required">
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Import</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Data UMKM</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Toko</th>
                        <th>Pemilik</th>
                        <th>Jenis Produk</th>
                        <th>Omset Per Tahun</th>
                        <th>Nilai Asset Perusahaan</th>
                        <th>Kecamatan</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-small">
                    @foreach ($data as $item)
                        <tr>
                            <td class="text-center">{{ ++$i }}</td>
                            <td>{{ $item->nama_umkm }}</td>
                            <td>{{ $item->pemilik }}</td>
                            <td>{{ $item->jenis_produk }}</td>
                            <td>@currency($item->omset )</td>
                            <td>@currency($item->asset)</td>
                            <td>{{ $item->kecamatan }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <form action="/data_umkm/detail/{{ $item->id }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_umkm" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-info mr-1"><i class="fas fa-info-circle"></i></button>
                                    </form>
                                    <a href="/data_umkm/edit/{{ $item->id }}" type="submit" class="btn btn-success mr-1 rounded"><i class="fas fa-edit"></i></a>
                                    <form action="/data_umkm/delete/{{ $item->id }}" method="post">
                                        @csrf
                                        <input type="hidden" name="id_umkm" value="{{ $item->id }}">
                                        <button type="submit" class="btn btn-danger"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
@push('script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable();
        });
    </script>   
@endpush