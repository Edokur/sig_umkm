@extends('layouts.app')
@section('content')
{{-- isi content  --}}

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="#">Data UMKM</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Data</li>
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
                Form
            </div>
            <div class="card-body">
                <form action="{{ route('data_umkm.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col">
                            <label for="Longtitude">Longtitude</label>
                            <input type="text" class="form-control mt-1" placeholder="Longtitude" id="Longtitude" name="longtitude">
                            @error('Longtitude')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="Lattitude">Lattitude</label>
                            <input type="text" class="form-control mt-1" placeholder="Lattitude" id="Lattitude" name="lattitude">
                            @error('Lattitude')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Nama Pemilik</label>
                        <input type="text" class="form-control mt-1" placeholder="Nama Pemilik" name="nama_pemilik">
                        @error('nama_pemilik')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Nama Toko</label>
                        <input type="text" class="form-control mt-1" placeholder="Nama Toko" name="nama_usaha">
                        @error('nama_usaha')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Jenis Produk</label>
                        <select class="custom-select custom-select-sm" name="jenis_produk">
                            <option selected>Open this select menu</option>
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
                            <input type="number" class="form-control" id="inlineFormInputGroup" placeholder="No HP" name="no_hp">
                        </div>
                        @error('no_hp')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label for="">Kegiatan Usaha</label>
                        <input type="text" class="form-control mt-1" placeholder="Kegiatan Usaha" name="kegiatan_usaha">
                        @error('kegiatan_usaha')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="row mt-3">
                        <div class="col">
                            <div class="form-group">
                                <label for="">Klasifikasi Usaha</label>
                                <select class="custom-select custom-select-sm" name="klasifikasi_usaha">
                                    <option selected>Open this select menu</option>
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
                                    <option selected>Open this select menu</option>
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
                        <textarea class="form-control mt-1" rows="3" name="alamat"></textarea>
                        @error('alamat')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="d-grid gap-2 mt-4">
                        <button class="btn btn-primary" type="submit">Submit</button>
                    </div>
                </form>
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

        const defaultLocation = [110.3652040575596, -7.801623569777348];

        mapboxgl.accessToken = '{{ env('MAP_KEY') }}';
        var map = new mapboxgl.Map({
            container: 'map',
            center: defaultLocation,
            zoom: 13,
            style: 'mapbox://styles/mapbox/streets-v12'
        });

        map.addControl(new mapboxgl.NavigationControl())
        map.addControl(new mapboxgl.FullscreenControl())

        map.addControl(
            new mapboxgl.GeolocateControl({
                positionOptions: {
                enableHighAccuracy: true
                },
                // When active the map will receive updates to the device's location as it changes.
                trackUserLocation: true,
                // Draw an arrow next to the location dot to indicate which direction the device is heading.
                showUserHeading: true
            })
        );

        map.on('click', (e) => {
            const longtitude = e.lngLat.lng
            const lattitude = e.lngLat.lat

            console.log({longtitude,lattitude});
            $("#Longtitude").val(longtitude);
            $("#Lattitude").val(lattitude);
        })
        
    </script> 
@endpush