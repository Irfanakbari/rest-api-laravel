<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Location\Coordinate;
use Location\Polygon;
use Location\Distance\Vincenty;
use Location\Formatter\Coordinate\GeoJSON;


class AbsenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $geofence = new Polygon();

        $geofence->addPoint(new Coordinate(3.751990669404107, 98.24938724237715));
        $geofence->addPoint(new Coordinate(3.7440354460794953, 98.2492909006943));
        $geofence->addPoint(new Coordinate(3.743626867702194, 98.2556976226045));
        $geofence->addPoint(new Coordinate(3.753216392241514, 98.25591439139093));
        $geofence->addPoint(new Coordinate(3.7513657904330255, 98.24659333357422));


        $insidePoint = new Coordinate(3.750509735989855, 98.25292790408683);





        return response()->json([
            'insidePoint' => $insidePoint,
            'isInside' => $geofence->contains($insidePoint),
        ]);
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
        $validator = Validator::make($request->all(), [
            'nis' => 'required',
            'absen' => 'required',
            'lat' => 'required',
            'long' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        // Geofencing
        $geofence = new Polygon();

        $geofence->addPoint(new Coordinate(3.751990669404107, 98.24938724237715));
        $geofence->addPoint(new Coordinate(3.7440354460794953, 98.2492909006943));
        $geofence->addPoint(new Coordinate(3.743626867702194, 98.2556976226045));
        $geofence->addPoint(new Coordinate(3.753216392241514, 98.25591439139093));
        $geofence->addPoint(new Coordinate(3.7513657904330255, 98.24659333357422));

        // get data from request
        $me = auth()->user();
        $tanggal = date('Y-m-d');
        $jam = date('H:i:s');
        $lat = floatval($request->lat);
        $long = floatval($request->long);

        // check if inside geofence or not
        $Point = new Coordinate($lat, $long);
        $isInside = $geofence->contains($Point);




        if (!$isInside || $isInside == null) {
            return response()->json([
                'status' => 'error',
                'message' => 'Anda Berada di luar radius absen'
            ], 401);
        }

        if ($me->nis == intval($request->nis)) {


            if (Absen::where('nis', $request->nis)->where('tanggal', $tanggal)->exists()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Anda Sudah Absen Hari Ini'
                ], 400);
            }

            $absen = Absen::create([
                'nis' => $request->nis,
                'absen' => $request->absen,
                'tanggal' => $tanggal,
                'timestamp' => $jam,
            ]);

            if ($absen) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Berhasil Absen'
                ], 200);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal Absen'
                ], 400);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Token Anda Tidak Sesuai dengan NIS'
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Absen  $absen
     * @return \Illuminate\Http\Response
     */
    public function show(Siswa $absen)
    {
        //
        $absensi = Absen::where('nis', $absen->nis)->get(

            [
                'tanggal',
                'absen',
                'timestamp'

            ]
        );
        return response()->json([
            'status' => 'success',
            'data' => [
                'nama' => $absen->nama,
                'nis' => $absen->nis,
                'kelas' => $absen->id_kelas,
            ],
            'absensi' => $absensi
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Absen  $absen
     * @return \Illuminate\Http\Response
     */
    public function edit(Absen $absen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Absen  $absen
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Absen $absen)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Absen  $absen
     * @return \Illuminate\Http\Response
     */
    public function destroy(Absen $absen)
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Hapus Absen'
        ], 200);
    }
}
