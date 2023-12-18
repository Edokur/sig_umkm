<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Location;

class MapController extends Controller
{

    /* public function index()
    {
        $this->loadlocations();
        return view('map');
    } */
    public function index()
    {
        $locations = Location::orderBy('created_at', 'desc')->get();
        // dd($locations);

        $customLocations = [];

        foreach ($locations as $location) {
            $customLocations[] = [
                'type' => 'Feature',
                'geometry' => [
                    'coordinates' => [$location->long, $location->lat],
                    'type' => 'point'
                ],
                'properties' => [
                    'locationId' => $location->id,
                    'title' => $location->title,
                    'image' => $location->image,
                    'description' => $location->description,
                ]
            ];
        }

        $geoLocation = [
            'type' => 'FeatureCollection',
            'features' => $customLocations
        ];

        $geoJson = collect($geoLocation)->toJson();

        return view('map', ['geoJson' => $geoJson]);
    }

    public function location()
    {
        $locations = Location::orderBy('created_at', 'desc')->get();
        // dd($locations);

        $customLocations = [];

        foreach ($locations as $location) {
            $customLocations[] = [
                'type' => 'Feature',
                'geometry' => [
                    'coordinates' => [$location->longtitude, $location->lattitude],
                    'type' => 'point'
                ],
                'properties' => [
                    'locationId' => $location->id,
                    'nama_pemilik' => $location->nama_pemilik,
                    'nama_usaha' => $location->nama_usaha,
                    'no_hp' => $location->no_hp,
                    'kegiatan_usaha' => $location->kegiatan_usaha,
                    'klasifikasi_usaha' => $location->klasifikasi_usaha,
                    'jenis_produk' => $location->jenis_produk,
                    'alamat' => $location->alamat,
                    'kecamatan' => $location->kecamatan,
                ]
            ];
        }

        $geoLocation = [
            'type' => 'FeatureCollection',
            'features' => $customLocations
        ];

        $geoJson = collect($geoLocation)->toJson();

        // dd(json_decode($geoJson));
        $geoArray = [];
        foreach ($locations as $locationarray) {
            $geoArray[] = [
                'locationId' => $locationarray->id,
                'nama_pemilik' => $locationarray->nama_pemilik,
                'nama_usaha' => $locationarray->nama_usaha,
                'no_hp' => $locationarray->no_hp,
                'kegiatan_usaha' => $locationarray->kegiatan_usaha,
                'klasifikasi_usaha' => $locationarray->klasifikasi_usaha,
                'jenis_produk' => $locationarray->jenis_produk,
                'alamat' => $locationarray->alamat,
                'kecamatan' => $locationarray->kecamatan,
                'coordinates' => [$locationarray->longtitude, $locationarray->lattitude],
                'type' => 'point'
            ];
        }

        return view(
            'guest.location',
            [
                'geoJson' => $geoJson,
                'geoArray' => $geoArray
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);

        $request->validate([
            'Longtitude' => 'required',
            'Lattitude' => 'required',
            'title' => 'required',
            'description' => 'required',
            'image' => 'image|max:2048|required',
        ]);

        $location = new Location();
        $location->long = $request->input('Longtitude');
        $location->lat = $request->input('Lattitude');
        $location->title = $request->input('title');
        $location->description = $request->input('description');
        if ($request->hasfile('image')) {
            $file = $request->file('image');
            $extention = $file->getClientOriginalExtension();
            $filename = time() . '.' . $extention;
            $file->move('uploads/image/', $filename);
            $location->image = $filename;
        }
        $location->save();
        return redirect()->back()->with('status', 'Location Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
