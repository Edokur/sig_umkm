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
                        <div class="h5 mb-0 font-weight-bold text-gray-800">14</div>
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

<div class="min-h-screen bg-gray-100 rounded">
    <div id='map' style='width: 100%; height: 90vh;'></div>
</div>

@endsection
@push('script')
    <script>
        const defaultLocation = [110.3652040575596, -7.801623569777348];

        mapboxgl.accessToken = '{{ env('MAP_KEY') }}';
        var map = new mapboxgl.Map({
            container: 'map',
            center: defaultLocation,
            zoom: 12,
            style: 'mapbox://styles/mapbox/streets-v12'
        });

        const loadLocations = (geoJson) => {
            geoJson.features.forEach((location) => {
                const {geometry, properties} = location
                const {iconSize, locationId, nama_umkm, jenis_produk, kegiatan_usaha, no_hp, klasifikasi_usaha} = properties

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
                    markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location_orange.png') !!})'
                }
                markerElement.style.backgroundSize = 'cover'
                markerElement.style.width = '50px'
                markerElement.style.height = '50px'

                const content = `
                    <div style="overflow-y, auto;mac-height:400px,width:100%" class="rounded">
                        <table class="table table-sm mt-2 table-borderless">
                            <tbody>
                                <tr>
                                    <td>Nama Toko</td>
                                    <td>:</td>
                                    <td>${nama_umkm}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Produk :</td>
                                    <td>:</td>
                                    <td>${jenis_produk}</td>
                                </tr>
                                <tr>
                                    <td>Kegiatan Usaha:</td>
                                    <td>:</td>
                                    <td>${kegiatan_usaha}</td>
                                </tr>
                                <tr>
                                    <td>Klasifikasi Usaha:</td>
                                    <td>: </td>
                                    <td>${klasifikasi_usaha}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                `

                const popUp = new mapboxgl.Popup({
                    offset:25
                }).setHTML(content).setMaxWidth("50%")

                new mapboxgl.Marker(markerElement)
                .setLngLat(geometry.coordinates)
                .setPopup(popUp)
                .addTo(map)
            })
        }

        loadLocations({!! $geoJson !!})


        map.addControl(new mapboxgl.NavigationControl())

        //Untuk mengambil Data Lokasi Diri sendiri
        map.addControl(
            new mapboxgl.GeolocateControl({
                positionOptions: {
                enableHighAccuracy: true
                },
                trackUserLocation: true,
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