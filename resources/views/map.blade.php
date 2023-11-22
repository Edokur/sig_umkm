<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="container py-12">
        {{-- <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    Map Box
                    <div id='map' style='width: 400px; height: 300px;'></div>
                </div>
            </div>
        </div> --}}

        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        MapBox
                        <div id="geocoder" class="geocoder"></div>
                    </div>
                    <div class="card-body">
                        <div id='map' style='width: 100%; height: 60vh;'></div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header bg-dark text-white">
                        Form
                    </div>
                    <div class="card-body">
                        <form action="{{ url('add-map') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col">
                                    <label for="Longtitude">Longtitude</label>
                                    <input type="text" class="form-control mt-1" placeholder="Longtitude" id="Longtitude" name="Longtitude">
                                    @error('Longtitude')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="col">
                                    <label for="Lattitude">Lattitude</label>
                                    <input type="text" class="form-control mt-1" placeholder="Lattitude" id="Lattitude" name="Lattitude">
                                    @error('Lattitude')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="">Title</label>
                                <input type="text" class="form-control mt-1" placeholder="Title" name="title">
                                @error('title')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label for="">Description</label>
                                <textarea class="form-control mt-1" rows="3" name="description"></textarea>
                                @error('description')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group mt-3">
                                <label for="">Picture</label>
                                <input class="form-control mt-1" type="file" id="formFile" name="image" onchange="loadFile(event)">
                                @error('image')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror

                                <img id="output"/>
                            </div>
                            <div class="d-grid gap-2 mt-4">
                                <button class="btn btn-dark text-dark" type="submit">Submit Location</button>
                                <button class="btn btn-danger text-dark" type="submit">Delete Location</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
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
            zoom: 11.15,
            style: 'mapbox://styles/mapbox/streets-v12'
        });

        // const style = "dark-v10";
        // map.setStyle(`mapbox://styles/mapbox/${style}`)

        const loadLocations = (geoJson) => {
            geoJson.features.forEach((location) => {
                const {geometry, properties} = location
                const {iconSize, locationId, title, image, description} = properties

                let markerElement = document.createElement('div')
                markerElement.className = 'marker' + locationId
                markerElement.id = locationId
                markerElement.style.backgroundImage = 'url(https://static-00.iconduck.com/assets.00/mapbox-icon-2048x2048-pmda994e.png)'
                markerElement.style.backgroundSize = 'cover'
                markerElement.style.width = '50px'
                markerElement.style.height = '50px'

                const content = `
                    <div style="overflow-y, auto;mac-height:400px,width:100%">
                        <table class="table table-sm mt-2">
                            <tbody>
                                <tr>
                                    <td>Title</td>
                                    <td>${title}</td>
                                </tr>
                                <tr>
                                    <td>Picture</td>
                                    <td><img src="{{ URL::asset('/uploads/image/') }}/${image}" loading="lazy" class="img-fluid"></td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>${description}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                `

                const popUp = new mapboxgl.Popup({
                    offset:25
                }).setHTML(content).setMaxWidth("400px")

                new mapboxgl.Marker(markerElement)
                .setLngLat(geometry.coordinates)
                .setPopup(popUp)
                .addTo(map)
            })
        }

        loadLocations({!! $geoJson !!})


        map.addControl(new mapboxgl.NavigationControl())

        // map.addControl(
        //     new mapboxgl.GeolocateControl({
        //         positionOptions: {
        //             enableHighAccuracy: true
        //         },
        //         // When active the map will receive updates to the device's location as it changes.
        //         trackUserLocation: true,
        //         // Draw an arrow next to the location dot to indicate which direction the device is heading.
        //         showUserHeading: true
        //     })
        // );

        const geocoder = new MapboxGeocoder({
        accessToken: mapboxgl.accessToken,
        mapboxgl: mapboxgl
        });
        
        document.getElementById('geocoder').appendChild(geocoder.onAdd(map));

        // map.addControl(
        //     new MapboxDirections({
        //     accessToken: mapboxgl.accessToken
        //     }),
        //     'top-left'
        //     );

        map.on('click', (e) => {
            const longtitude = e.lngLat.lng
            const lattitude = e.lngLat.lat

            console.log({longtitude,lattitude});
            $("#Longtitude").val(longtitude);
            $("#Lattitude").val(lattitude);
        })
        

        
    </script>
    @endpush
</x-app-layout>



