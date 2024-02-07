@extends('layouts.app')
@section('content')
{{-- isi content  --}}

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Data Variabel</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
    </ol>
</nav>

<a class="btn btn-primary mb-3" href="/data_variabel"><i class="fas fa-arrow-left"></i>Kembali</a>

<div class="card">
    <div class="card-header bg-dark text-white">
        Form
    </div>
    <div class="card-body">
        <form action="{{ route('data_variabel.store') }}" method="POST">
            @csrf
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="form-group mt-3">
                        <label for="">Nama Variabel</label>
                        <input type="text" class="form-control mt-1" placeholder="Nama Variabel" name="nama_variabel">
                        @error('nama_variabel')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
            </div>
            
            <div class="d-grid gap-2 mt-4">
                <button class="btn btn-primary" type="submit">Simpan</button>
            </div>
        </form>
    </div>
</div>



@endsection
@push('script')
    <script>
    </script> 
@endpush