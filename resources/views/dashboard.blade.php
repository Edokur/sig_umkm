@extends('layouts.app')
@section('content')

<div class="row">
    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <i class="fas fa-user fa-4x"></i>
                    </div>
                    <div class="col-auto">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Jumlah Admin</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_user }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <i class="fas fa-map-marked-alt fa-4x"></i>
                    </div>
                    <div class="col-auto">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Jumlah Kecamatan</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">20</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-4 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col">
                        <i class="fas fa-store-alt fa-4x"></i>
                    </div>
                    <div class="col-auto">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Jumlah UMKM</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $total_umkm }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
@push('script')
    <script>
        
    </script>   
@endpush