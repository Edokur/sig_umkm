@extends('layouts.app')
@section('content')
{{-- isi content  --}}

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Data UMKM</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Data</li>
    </ol>
</nav>

<a class="btn btn-primary mb-3" href="/data_umkm"><i class="fas fa-arrow-left"></i>Kembali</a>

<div class="row mb-5">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-dark text-white">
                MapBox
            </div>
            <div class="card-body">
                <div id='map' style='width: 100%; height: 80vh;'></div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-dark text-white">
                Form Edit
            </div>
            <div class="card-body">
                @foreach ($locations as $item)
                    <form action="{{ route('data_umkm.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id_location" value="{{ $item->id }}">
                        <div class="row">
                            <div class="col">
                                <label for="Longtitude">Longtitude</label>
                                <input type="text" class="form-control mt-1" placeholder="Longtitude" id="Longtitude" name="longtitude" value="{{ $item->longtitude }}">
                                @error('Longtitude')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="Lattitude">Lattitude</label>
                                <input type="text" class="form-control mt-1" placeholder="Lattitude" id="Lattitude" name="lattitude" value="{{ $item->lattitude }}">
                                @error('Lattitude')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="">Nama Pemilik</label>
                            <input type="text" class="form-control mt-1" placeholder="Nama Pemilik" name="nama_pemilik" value="{{ $item->nama_pemilik }}">
                            @error('nama_pemilik')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="">Nama Toko</label>
                            <input type="text" class="form-control mt-1" placeholder="Nama Toko" name="nama_usaha" value="{{ $item->nama_usaha }}">
                            @error('nama_usaha')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="">Jenis Produk</label>
                            <select class="custom-select custom-select-sm" name="jenis_produk">
                                <option value="{{ $item->jenis_produk }}" selected>{{ $item->jenis_produk }}</option>
                                <option value="Makanan Siap Saji dan Minuman Segar">Makanan Siap Saji dan Minuman Segar</option>
                                <option value="Makanan Kemasan dan Frozen">Makanan Kemasan dan Frozen</option>
                                <option value="Kue Desert dan Camilan">Kue Desert dan Camilan</option>
                                <option value="Fashion dan Aksesoris">Fashion dan Aksesoris</option>
                                <option value="Sambal Bumbu dan Kebutuhan Rumah Tangga">Sambal Bumbu dan Kebutuhan Rumah Tangga</option>
                                <option value="Jasa dan Lain-lain">Jasa dan Lain-lain</option>
                            </select>
                            @error('jenis_produk')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="">No HP</label>
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">+62</div>
                                </div>
                                <input type="text" class="form-control" id="inlineFormInputGroup" placeholder="No HP" name="no_hp" value="{{ $item->no_hp }}">
                            </div>
                            @error('no_hp')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="">Kegiatan Usaha</label>
                            <input type="text" class="form-control mt-1" placeholder="Kegiatan Usaha" name="kegiatan_usaha" value="{{ $item->kegiatan_usaha }}">
                            @error('kegiatan_usaha')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="row mt-3">
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Klasifikasi Usaha</label>
                                    <select class="custom-select custom-select-sm" name="klasifikasi_usaha">
                                        <option value="{{ $item->klasifikasi_usaha }}" selected>{{ $item->klasifikasi_usaha }}</option>
                                        <option value="MIKRO">MIKRO</option>
                                        <option value="KECIL">KECIL</option>
                                        <option value="MENENGAH">MENENGAH</option>
                                    </select>
                                    @error('klasifikasi_usaha')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col">
                                <div class="form-group">
                                    <label for="">Kecamatan</label>
                                    <select class="custom-select custom-select-sm" name="kecamatan">
                                        <option value="{{ $item->kecamatan }}" selected>{{ $item->kecamatan }}</option>
                                        <option value="GONDOKUSUMAN">GONDOKUSUMAN</option>
                                        <option value="WIROBRAJAN">WIROBRAJAN</option>
                                        <option value="TEGALREJO">TEGALREJO</option>
                                    </select>
                                    @error('kecamatan')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <label for="">Alamat</label>
                            <textarea class="form-control mt-1" rows="3" name="alamat">{{ $item->alamat }}</textarea>
                            @error('alamat')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                @endforeach
            </div>
        </div>
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

        map.on('click', (e) => {
            const longtitude = e.lngLat.lng
            const lattitude = e.lngLat.lat

            console.log({longtitude,lattitude});
            $("#Longtitude").val(longtitude);
            $("#Lattitude").val(lattitude);
        })
        
    </script> 
@endpush