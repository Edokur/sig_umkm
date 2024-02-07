<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>UMKM Location</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        
        <link href="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.css" rel="stylesheet">
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.14.1/mapbox-gl.js"></script>

        {{-- rute lokasi --}}
        <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.js"></script>
        <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.css" type="text/css">

        {{-- searching lokasi --}}
        <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.min.js"></script>
        <link rel="stylesheet" href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v5.0.0/mapbox-gl-geocoder.css" type="text/css">
        
        
    </head>
    <body class="font-sans antialiased">
        <div class="container-fluid mt-2">
            <div class="card">
                <div class="card-header">
                    <h6>UMKM Location</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div id='map' style='width: 100%; height: 90vh;'></div>
                        </div>
                        <div class="col-md-4">
                            <div class="mt-4" style="width:100%;">
                                <div class="card">
                                    <div class="card-body">
                                        <form action="" class="mt-5" id="filterForm">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="mb-3">
                                                        <label for="searchUmkm" class="form-label">Cari Nama UMKM</label>
                                                        <input type="text" id="searchUmkm" name="searchUmkm" class="form-control" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="kecamatanFilter" class="form-label">Kecamatan</label>
                                                    <select id="kecamatanFilter" class="form-select" name="kecamatanFilter">
                                                        <option value="">Semua kecamatan</option>
                                                        <option value="GONDOKUSUMAN">GONDOKUSUMAN</option>
                                                        <option value="WIROBRAJAN">WIROBRAJAN</option>
                                                        <option value="TEGALREJO">TEGALREJO</option>
                                                        <option value="KOTAGEDE">KOTAGEDE</option>
                                                        <option value="KRATON">KRATON</option>
                                                        <option value="GONDOMANAN">GONDOMANAN</option>
                                                        <option value="UMBULHARJO">UMBULHARJO</option>
                                                        <option value="PAKUALAMAN">PAKUALAMAN</option>
                                                        <option value="JETIS">JETIS</option>
                                                        <option value="MANTRIJERON">MANTRIJERON</option>
                                                        <option value="MERGANGSAN">MERGANGSAN</option>
                                                        <option value="NGAMPILAN">NGAMPILAN</option>
                                                        <option value="DANUREJAN">DANUREJAN</option>
                                                        <option value="GEDONGTENGEN">GEDONGTENGEN</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="klasifikasiFilter" class="form-label">Klasifikasi Usaha</label>
                                                    <select id="klasifikasiFilter" name="klasifikasiFilter" class="form-select">
                                                        <option value="">Semua Klasifikasi</option>
                                                        <option value="Usaha Mikro">Usaha Mikro</option>
                                                        <option value="Usaha Kecil">Usaha Kecil</option>
                                                        <option value="Usaha Menengah">Usaha Menengah</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="kategoriFilter" class="form-label">Kategori</label>
                                                    <select id="kategoriFilter" class="form-select" aria-label="Default select example">
                                                        <option value="">Semua Kategori</option>
                                                        <option value="Furnitur Dekorasi dan Kerajinan">Furnitur Dekorasi dan Kerajinan</option>
                                                        <option value="Makanan Siap Saji dan Minuman Segar">Makanan Siap Saji dan Minuman Segar</option>
                                                        <option value="Makanan Kemasan dan Frozen">Makanan Kemasan dan Frozen</option>
                                                        <option value="Kue Desert dan Camilan">Kue Desert dan Camilan</option>
                                                        <option value="Fashion dan Aksesoris">Fashion dan Aksesoris</option>
                                                        <option value="Sambal Bumbu dan Kebutuhan Rumah Tangga">Sambal Bumbu dan Kebutuhan Rumah Tangga</option>
                                                        <option value="Pertanian Buah dan Tanaman">Pertanian Buah dan Tanaman</option>
                                                        <option value="Herbal Kesehatan dan Kecantikan">Herbal Kesehatan dan Kecantikan</option>
                                                        <option value="Kain Batik Jumputan dan Eco Printing">Kain Batik Jumputan dan Eco Printing</option>
                                                        <option value="Jasa dan Lain-lain">Jasa dan Lain-lain</option>
                                                    </select>
                                                </div>
                                                
                                            </div>
                                            <button type="button" onclick="applyFilter()" id="filterButton" class="btn btn-primary mt-4 mr-2">Cari</button>
                                            <button type="button" onclick="loadAllLocations()" id="resetButton" class="btn btn-danger mt-4">Reset</button>
                                        </form>
                                    </div>
                                </div>

                                @foreach ($geoArray as $item)
                                    <div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar_{{ $item['locationId'] }}" aria-labelledby="offcanvasExampleLabel">
                                        <div class="offcanvas-header">
                                            <h4 class="offcanvas-title fw-bold" id="offcanvasExampleLabel">Detail UMKM</h4>
                                            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                        </div>
                                        <div class="offcanvas-body">
                                            <h5 class="fw-bold">{{ $item['nama_umkm'] }}</h5>
                                            <div class="rounded">
                                                <table class="table table-sm mt-2 table-borderless">
                                                    <tbody>
                                                        <tr>
                                                            <td>Pemilik Usaha</td>
                                                            <td>:</td>
                                                            <td>{{ $item['pemilik'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Merk Dagang</td>
                                                            <td>:</td>
                                                            <td>{{ $item['nama_umkm'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Kegiatan Usaha</td>
                                                            <td>:</td>
                                                            <td>{{ $item['kegiatan_usaha'] }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Klasifikasi Usaha</td>
                                                            <td>:</td>
                                                            <td>{{ $item['klasifikasi_usaha'] }}</td>
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
                                                    <a style="cursor: pointer;" class="btn btn-primary" onclick="myNavFunc({{ $item['lattitude'] }}, {{ $item['longtitude'] }})">Rute</a>
                                                    {{-- <a class="btn btn-success" href="https://wa.me/{{ $item['no_hp'] }}?text=Permisi%20saya%20ingin%20bertanya%20apakah%20produk%20tersedia?">Send Message</a> --}}
                                                    <a class="btn btn-success" href="#">Send Message</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- General Script  --}}
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
        <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.1.1/mapbox-gl-directions.js"></script>
        <script src="{{ asset('js/guest.js') }}"></script>

        <script>
            
            const defaultLocation = [110.3652040575596, -7.801623569777348];

            mapboxgl.accessToken = '{{ env('MAP_KEY') }}';
            var map = new mapboxgl.Map({
                container: 'map',
                center: defaultLocation,
                zoom: 13,
                // style: 'mapbox://styles/mapbox/standard'
                style: 'mapbox://styles/mapbox/streets-v12'
            });

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


            // Fungsi untuk memuat semua lokasi saat halaman dimuat
            function loadAllLocations() {
                const filters = {
                    kategoriFilter: 'all',
                    klasifikasiFilter: 'all',
                    kecamatanFilter: 'all'
                };
                // Kirim permintaan ke server untuk mendapatkan semua data lokasi
                $.ajax({
                    url: '/get-all-locations', // Ganti URL dengan endpoint yang sesuai di server Anda
                    method: 'GET',
                    success: function(data) {
                        const parsedallData = JSON.parse(data.geoJson);
                        // Membentuk ulang objek sesuai dengan format yang diinginkan
                        const formattedallData = {
                            type: parsedallData.type,
                            features: parsedallData.features
                        };

                        // Panggil fungsi untuk menampilkan lokasi pada peta
                        loadLocations(formattedallData, filters);
                    },
                    error: function(error) {
                        console.error('Error loading all locations:', error);
                    }
                });
            }

            function applyFilter() {
                const klasifikasiFilter = document.getElementById('klasifikasiFilter').value;
                const kategoriFilter = document.getElementById('kategoriFilter').value;
                const kecamatanFilter = document.getElementById('kecamatanFilter').value;
                const searchUmkm = document.getElementById('searchUmkm').value;

                const filters = {
                    kategoriFilter: kategoriFilter,
                    klasifikasiFilter: klasifikasiFilter,
                    kecamatanFilter: kecamatanFilter,
                    searchUmkm: searchUmkm
                };
                // Kirim permintaan filter ke server dengan Ajax
                $.ajax({
                    url: '/filter-locations',
                    method: 'GET',
                    data: {
                        klasifikasi_usaha: klasifikasiFilter,
                        kategori: kategoriFilter,
                        kecamatanFilter: kecamatanFilter,
                        searchUmkm: searchUmkm,
                    },
                    success: function (data) {
                        // Parsing string JSON dari data
                        const parsedData = JSON.parse(data.geoJsonFilter);
                        // Membentuk ulang objek sesuai dengan format yang diinginkan
                        const formattedData = {
                            type: parsedData.type,
                            features: parsedData.features
                        };
                        // Perbarui peta dengan data yang disaring
                        loadLocations(formattedData, filters);
                    },
                    error: function (error) {
                        
                        console.error('Error applying filter:', error);
                    }
                });
            }

            let markers = []; // Array untuk menyimpan marker
            function loadLocations(geoJson, filters) {
                // Hapus semua marker dari peta
                markers.forEach(marker => marker.remove());
                markers = []; // Bersihkan array marker

                // Tambahkan marker untuk setiap fitur dalam geoJson
                geoJson.features.forEach((location) => {
                    const {geometry, properties, filter} = location
                    const {iconSize, locationId, nama_umkm, jenis_produk, klasifikasi_usaha, kecamatan} = properties
                    // Terapkan filter
                    if (
                        (!filters.kategoriFilter || jenis_produk === filters.kategoriFilter) &&
                        (!filters.klasifikasiFilter || klasifikasi_usaha === filters.klasifikasiFilter) &&
                        (!filters.kecamatanFilter || kecamatan === filters.kecamatanFilter)
                    ) {
                        let markerElement = document.createElement('div');
                        markerElement.className = 'marker' + locationId;
                        markerElement.id = locationId;

                        // Set gambar latar belakang marker berdasarkan klasifikasi_usaha
                        if (klasifikasi_usaha === 'Usaha Mikro') {
                            markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location_merah.png') !!})';
                        } else if (klasifikasi_usaha === 'Usaha Kecil') {
                            markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location_kuning.png') !!})';
                        } else if (klasifikasi_usaha === 'Usaha Menengah') {
                            markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location_hijau.png') !!})';
                        } else {
                            markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location_orange.png') !!})';
                        }
                        markerElement.style.backgroundSize = 'cover';
                        markerElement.style.width = '50px';
                        markerElement.style.height = '50px';

                        // Buat card untuk popup
                        const card = `
                            <div style="overflow-y, auto;mac-height:400px,width:100%">
                                <div class="card-body">
                                    <h5 class="card-title">${nama_umkm}</h5>
                                    <p class="card-text">${jenis_produk}</p>
                                    <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar_${locationId}" aria-controls="offcanvasExample">Detail
                                    </button>
                                </div>
                            </div>
                        `;

                        // Buat popup
                        const popUp = new mapboxgl.Popup({
                            offset: 25
                        }).setHTML(card).setMaxWidth("50%");

                        // Tambahkan marker ke peta
                        const marker = new mapboxgl.Marker(markerElement)
                            .setLngLat(geometry.coordinates)
                            .setPopup(popUp)
                            .addTo(map);

                        markers.push(marker); // Tambahkan marker ke dalam array
                    }else{
                        let markerElement = document.createElement('div');
                        markerElement.className = 'marker' + locationId;
                        markerElement.id = locationId;

                        // Set gambar latar belakang marker berdasarkan klasifikasi_usaha
                        if (klasifikasi_usaha === 'Usaha Mikro') {
                            markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location_merah.png') !!})';
                        } else if (klasifikasi_usaha === 'Usaha Kecil') {
                            markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location_kuning.png') !!})';
                        } else if (klasifikasi_usaha === 'Usaha Menengah') {
                            markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location_hijau.png') !!})';
                        } else {
                            markerElement.style.backgroundImage = 'url({!! asset('admin_assets/img/location_orange.png') !!})';
                        }
                        markerElement.style.backgroundSize = 'cover';
                        markerElement.style.width = '50px';
                        markerElement.style.height = '50px';

                        // Buat card untuk popup
                        const card = `
                            <div style="overflow-y, auto;mac-height:400px,width:100%">
                                <div class="card-body">
                                    <h5 class="card-title">${nama_umkm}</h5>
                                    <p class="card-text">${jenis_produk}</p>
                                    <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar_${locationId}" aria-controls="offcanvasExample">Detail
                                    </button>
                                </div>
                            </div>
                        `;

                        // Buat popup
                        const popUp = new mapboxgl.Popup({
                            offset: 25
                        }).setHTML(card).setMaxWidth("50%");

                        // Tambahkan marker ke peta
                        const marker = new mapboxgl.Marker(markerElement)
                            .setLngLat(geometry.coordinates)
                            .setPopup(popUp)
                            .addTo(map);

                        markers.push(marker); // Tambahkan marker ke dalam array
                    }
                });
            }

            // Panggil applyFilter() ketika tombol filter ditekan
            document.getElementById('filterButton').addEventListener('click', applyFilter);

            // Panggil fungsi untuk memuat semua lokasi saat halaman dimuat
            loadAllLocations();
        
    </script>
    </body>
</html>
