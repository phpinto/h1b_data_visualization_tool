<?php

namespace App\Http\Controllers;
use Storage;

use Illuminate\Http\Request;

class DataVizController extends Controller
{
    public function index()
    {
        return view('pages.dataviz');
    }

    public function get_data_image($file)
    {
        return Storage::disk('local')->get('public\\'.$file.'.png');
    }
 
}
