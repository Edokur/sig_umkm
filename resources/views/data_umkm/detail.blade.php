@extends('layouts.app')
@section('content')
{{-- isi content  --}}

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Data UMKM</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Data</li>
    </ol>
</nav>

<a class="btn btn-primary mb-3" href="/data_umkm"><i class="fas fa-arrow-left"></i>Kembali</a>

<div class="row">
    <div class="col-md-6">
        <div id='map' style='width: 100%; height: 80vh;'></div>
    </div>

    <div class="col-md-6">
        @foreach ($locations as $item)
        <form action="#" id="detailUMKM" name="detailUMKMForm" class="form-horizontal">
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Pemilik</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $item->nama_pemilik }}" disabled>
                </div>
            </div>
            <div class="form-group row mt-2">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Nama Toko</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $item->nama_usaha }}" disabled>
                </div>
            </div>
            <div class="form-group row mt-2">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Jenis Produk</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $item->jenis_produk }}" disabled>
                </div>
            </div>
            <div class="form-group row mt-2">
                <label for="inputEmail3" class="col-sm-2 col-form-label">No HP</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $item->no_hp }}" disabled>
                </div>
            </div>
            <div class="form-group row mt-2">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Kegiatan Usaha</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $item->kegiatan_usaha }}" disabled>
                </div>
            </div>
            <div class="form-group row mt-2">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Klasifikasi Usaha</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $item->klasifikasi_usaha }}" disabled>
                </div>
            </div>
            <div class="form-group row mt-2">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Kecamatan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $item->kecamatan }}" disabled>
                </div>
            </div>
            <div class="form-group row mt-2">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $item->alamat }}" disabled>
                </div>
            </div>
        </form>
        @endforeach
    </div>
</div>


@endsection
@push('script')
    <script>
        var loadFile = function(event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function() {
                URL.revokeObjectURL(output.src) // free memory
            }
        };

        const defaultLocation = [{!! $locations[0]->longtitude !!}, {!! $locations[0]->lattitude !!}];

        mapboxgl.accessToken = '{{ env('MAP_KEY') }}';
        var map = new mapboxgl.Map({
            container: 'map',
            center: defaultLocation,
            zoom: 13,
            style: 'mapbox://styles/mapbox/streets-v12'
        });

        const loadLocations = (geoJson) => {
            geoJson.features.forEach((location) => {
                const {geometry, properties} = location
                const {iconSize, locationId, nama_usaha, jenis_produk,} = properties

                let markerElement = document.createElement('div')
                markerElement.className = 'marker' + locationId
                markerElement.id = locationId
                markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location.png') !!})'
                markerElement.style.backgroundSize = 'cover'
                markerElement.style.width = '50px'
                markerElement.style.height = '50px'

                new mapboxgl.Marker(markerElement)
                .setLngLat(geometry.coordinates)
                .addTo(map)
            })
        }

        loadLocations({!! $geoJson !!})

        map.addControl(new mapboxgl.NavigationControl())
        map.addControl(new mapboxgl.FullscreenControl())
        
    </script> 
@endpush