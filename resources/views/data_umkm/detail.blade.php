@extends('layouts.app')
@section('content')
{{-- isi content  --}}

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Data UMKM</a></li>
        <li class="breadcrumb-item active" aria-current="page">Detail Data UMKM</li>
    </ol>
</nav>

<a class="btn btn-primary mb-3" href="/data_umkm"><i class="fas fa-arrow-left"></i>Kembali</a>

<div class="card">
    <div class="card-body">
        <div id='map' style='width: 100%; height: 80vh;'></div>
    </div>
    <div class="card-footer">
        @foreach ($umkms as $item)
        <form action="#" id="detailUMKM" name="detailUMKMForm" class="form-horizontal">
            <div class="form-group row mt-2">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Pemilik</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $item->pemilik }}" disabled>
                </div>
            </div>
            <div class="form-group row mt-2">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Nama UMKM</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="{{ $item->nama_umkm }}" disabled>
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
                    <input type="text" class="form-control" value="<?= $item->klasifikasi_usaha == null ? 'Perhitungan Belum dilakukan' : $item->klasifikasi_usaha ?>" disabled>
                </div>
            </div>
            <div class="form-group row mt-2">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Omset Per Tahun</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="@currency($item->omset)" disabled>
                </div>
            </div>
            <div class="form-group row mt-2">
                <label for="inputEmail3" class="col-sm-2 col-form-label">Asset Perusahaan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" value="@currency($item->asset)" disabled>
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


<div class="row">

    <div class="col-md-6">
    </div>
</div>


@endsection
@push('script')
    <script>
        const defaultLocation = [{!! $umkms[0]->longtitude !!}, {!! $umkms[0]->lattitude !!}];

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
                const {iconSize, locationId, nama_umkm, jenis_produk, klasifikasi_usaha} = properties

                let markerElement = document.createElement('div')
                markerElement.className = 'marker' + locationId
                markerElement.id = locationId
                if (klasifikasi_usaha == 'Usaha Mikro') {
                    markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location_merah.png') !!})'
                } else if(klasifikasi_usaha == 'Usaha Kecil'){
                    markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location_kuning.png') !!})'
                }else if(klasifikasi_usaha == 'Usaha Menengah'){
                    markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location_hijau.png') !!})'
                }else{
                    markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location_merah.png') !!})'
                }
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