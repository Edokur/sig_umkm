@extends('layouts.app')
@section('content')
{{-- isi content  --}}
<div class="min-h-screen bg-gray-100 rounded">
    <div id='map' style='width: 100%; height: 90vh;'></div>
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
            zoom: 12,
            style: 'mapbox://styles/mapbox/streets-v12'
        });

        // const style = "dark-v10";
        // map.setStyle(`mapbox://styles/mapbox/${style}`)

        const loadLocations = (geoJson) => {
            geoJson.features.forEach((location) => {
                const {geometry, properties} = location
                const {iconSize, locationId, nama_usaha, jenis_produk, kegiatan_usaha, no_hp, klasifikasi_usaha} = properties

                let markerElement = document.createElement('div')
                markerElement.className = 'marker' + locationId
                markerElement.id = locationId
                markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location.png') !!})'
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
                                    <td>${nama_usaha}</td>
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

                const card = `
                <div style="overflow-y, auto;mac-height:400px,width:100%">
                    <div class="card-body">
                        <h5 class="card-title">${nama_usaha}</h5>
                        <p class="card-text">${jenis_produk}</p>
                        <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebaradmin_${locationId}" aria-controls="offcanvasExample">Detail
                        </button>
                    </div>
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