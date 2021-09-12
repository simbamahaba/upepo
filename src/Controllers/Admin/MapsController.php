<?php

namespace Simbamahaba\Upepo\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Simbamahaba\Upepo\Models\Map;
class MapsController extends Controller
{
    private $map;
    public function __construct()
    {
        $this->middleware('web');
        $this->middleware('admin.only');
        $this->map = Map::first();
    }
    public function index()
    {
        return view('upepo::admin.maps.index',['map'=>$this->map]);
    }

    public function update(Request $request)
    {
        $this->validate($request,[
            'latitude'  => 'required|numeric',
            'longitude'  => 'required|numeric',
            'company'  => 'required',
            'region'  => 'required',
            'city'  => 'required',
            'address'  => 'required',
        ]);

        $this->map->latitude = $request->latitude;
        $this->map->longitude = $request->longitude;
        $this->map->company = $request->company;
        $this->map->region = $request->region;
        $this->map->city = $request->city;
        $this->map->address = $request->address;
        $this->map->save();

        return redirect('admin/maps');
    }
}
