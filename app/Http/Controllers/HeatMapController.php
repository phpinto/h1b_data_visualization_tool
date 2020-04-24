<?php

namespace App\Http\Controllers;
use Storage;

use Illuminate\Http\Request;

class HeatMapController extends Controller
{
    public function index()
    {
        return view('pages.heatmap');
    }

    public function get_map_json()
    {
        $map_json = Storage::disk('local')->get('public\states.json');
        $map_json = json_decode($map_json, true);
        return $map_json;
    }

    public function return_image($type)
    {
        return Storage::disk('local')->get('public\legend_'.$type.'.png');
    }

}
