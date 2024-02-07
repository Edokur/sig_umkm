@extends('layouts.app')
@section('content')
{{-- isi content  --}}

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Data Cluster</a></li>
        <li class="breadcrumb-item active" aria-current="page">update Data</li>
    </ol>
</nav>

<a class="btn btn-primary mb-3" href="/data_cluster"><i class="fas fa-arrow-left"></i>Kembali</a>

<div class="card">
    <div class="card-header bg-dark text-white">
        Form
    </div>
    <div class="card-body">
        @foreach ($clusters as $item)
            <form action="{{ route('data_cluster.update') }}" method="POST">
                @csrf
                <input type="hidden" name="id_cluster" value="{{ $item->id }}">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="form-group mt-3">
                            <label for="">Nama Cluster</label>
                            <input type="text" class="form-control mt-1" placeholder="Nama Cluster" name="nama_cluster" value="{{ $item->nama_cluster }}">
                            @error('nama_cluster')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <button class="btn btn-primary" type="submit">Simpan</button>
                </div>
            </form>
        @endforeach
    </div>
</div>



@endsection
@push('script')
    <script>
    </script> 
@endpush