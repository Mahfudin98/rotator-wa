<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kavist\RajaOngkir\Facades\RajaOngkir;
use App\Models\City;
use App\Models\Province;
use App\Models\District;

class IndexController extends Controller
{
    public function index()
    {
        $provinces = Province::orderBy('created_at', 'DESC')->get();

        return view('index', compact('provinces'));
    }

    public function getCity()
    {
        $cities = City::where('province_id', request()->province_id)->get();
        return response()->json(['status' => 'success', 'data' => $cities]);
    }

    public function getDistrict()
    {
        $districts = District::where('city_id', request()->city_id)->get();
        return response()->json(['status' => 'success', 'data' => $districts]);
    }

    public function getCourier(Request $request)
    {
        $cost = RajaOngkir::ongkosKirim([
            'origin'            => 3556,
            'originType'        => 'subdistrict',
            'destination'       => $request->destination,
            'destinationType'   => 'subdistrict',
            'weight'            => $request->weight,
            'courier'           => $request->courier
        ])->get();


        return response()->json($cost[0]['costs'][0]['cost']);
    }
}
