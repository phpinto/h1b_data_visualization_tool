<?php

namespace App\Http\Controllers;
use Storage;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function get_image($file)
    {
        return Storage::disk('local')->get('public\\'.$file.'.png');
    }
}
