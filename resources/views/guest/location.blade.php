<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
        <title>UMKM Location</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

        <!-- Scripts -->
        {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
        
        {{-- <link href='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.css' rel='stylesheet' /> --}}
        <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>
        {{-- <link href="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.css" rel="stylesheet">
        <script src="https://api.mapbox.com/mapbox-gl-js/v3.0.1/mapbox-gl.js"></script> --}}

        {{-- rute lokasi --}}
        <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.js"></script>
        <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.css" type="text/css">

        {{-- searching lokasi --}}
        <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
        <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
        
        
    
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <div id='map' style='width: 100%; height: 65vh;'></div>
            <div class="container-fluid mt-3">
                <div class="card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary float-end" onclick="Nearby()">Terdekat</button>
                        
                        <form action="" class="mt-5">
                                <div class="row">
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="exampleFormControlInput1" class="form-label">Pencarian UMKM :</label>
                                        <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleFormControlInput1" class="form-label">Kecamatan</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Open this select menu</option>
                                        <option value="GONDOKUSUMAN">GONDOKUSUMAN</option>
                                        <option value="WIROBRAJAN">WIROBRAJAN</option>
                                        <option value="TEGALREJO">TEGALREJO</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="exampleFormControlInput1" class="form-label">Kategori</label>
                                    <select class="form-select" aria-label="Default select example">
                                        <option selected>Open this select menu</option>
                                        <option value="Makanan Siap Saji dan Minuman Segar">Makanan Siap Saji dan Minuman Segar</option>
                                        <option value="Makanan Kemasan dan Frozen">Makanan Kemasan dan Frozen</option>
                                        <option value="Kue Desert dan Camilan">Kue Desert dan Camilan</option>
                                        <option value="Fashion dan Aksesoris">Fashion dan Aksesoris</option>
                                        <option value="Sambal Bumbu dan Kebutuhan Rumah Tangga">Sambal Bumbu dan Kebutuhan Rumah Tangga</option>
                                        <option value="Jasa dan Lain-lain">Jasa dan Lain-lain</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary float-start mt-4">Cari</button>
                        </form>
                    </div>
                </div>
            </div>

            @foreach ($geoArray as $item)
                {{-- <p>sidebar_{{ $item['locationId'] }}</p> --}}
                <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar_{{ $item['locationId'] }}" aria-labelledby="offcanvasExampleLabel">
                    <div class="offcanvas-header">
                        <h4 class="offcanvas-title fw-bold" id="offcanvasExampleLabel">Detail</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                    </div>
                    <div class="offcanvas-body">
                        <h5 class="fw-bold">{{ $item['nama_usaha'] }}</h5>
                        <div class="rounded">
                            <table class="table table-sm mt-2 table-borderless">
                                <tbody>
                                    <tr>
                                        <td>Pemilik Usaha</td>
                                        <td>:</td>
                                        <td>{{ $item['nama_pemilik'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Merk Dagang</td>
                                        <td>:</td>
                                        <td>{{ $item['nama_usaha'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kegiatan Usaha</td>
                                        <td>:</td>
                                        <td>{{ $item['kegiatan_usaha'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor HP</td>
                                        <td>:</td>
                                        <td>{{ $item['no_hp'] }}</td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td>{{ $item['alamat'] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="float-end mt-2">
                                <button class="btn btn-primary" type="button">Rute</button>
                                {{-- <a class="btn btn-success" href="https://wa.me/{{ $item['no_hp'] }}?text=Permisi%20saya%20ingin%20bertanya%20apakah%20produk%20tersedia?">Send Message</a> --}}
                                <a class="btn btn-success" href="#">Send Message</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- General Script  --}}
        {{-- <script src="{{ asset('js/app.js') }}" defer></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        {{-- <script src='https://api.mapbox.com/mapbox-gl-js/v2.9.1/mapbox-gl.js'></script> --}}
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.js"></script>

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

        // const style = "dark-v10";
        // map.setStyle(`mapbox://styles/mapbox/${style}`)

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

                const content = `
                    <div style="overflow-y, auto;mac-height:400px,width:100%" class="rounded">
                        <table class="table table-sm mt-2 table-borderless">
                            <tbody>
                                <tr>
                                    <td>Nama UMKM :</td>
                                    <td>${nama_usaha}</td>
                                </tr>
                                <tr>
                                    <td>Jenis Produk :</td>
                                    <td>${jenis_produk}</td>
                                </tr>
                                <tr >
                                    <td colspan="2">
                                        <button class="btn btn-primary btn-sm mt-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar_${locationId}" aria-controls="offcanvasExample">
                                        Detail
                                        </button>
                                    </td>
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
                        <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar_${locationId}" aria-controls="offcanvasExample">Detail
                        </button>
                    </div>
                </div>
                `

                const popUp = new mapboxgl.Popup({
                    offset:25
                }).setHTML(card).setMaxWidth("50%")

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

        const geocoder = new MapboxGeocoder({
            accessToken: mapboxgl.accessToken,
            mapboxgl: mapboxgl
        });
        
        // document.getElementById('geocoder').appendChild(geocoder.onAdd(map));

        map.addControl(
            new MapboxDirections({
                accessToken: mapboxgl.accessToken,
            }),
            'top-left'
        );

        map.on('click', (e) => {
            const longtitude = e.lngLat.lng
            const lattitude = e.lngLat.lat

            console.log({longtitude,lattitude});
            $("#Longtitude").val(longtitude);
            $("#Lattitude").val(lattitude);
        })
        
    </script>
    </body>
</html>
