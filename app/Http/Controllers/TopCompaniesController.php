<?php

namespace App\Http\Controllers;

use App\Employer;
use App\Http\Resources\EmployerResource;

use Illuminate\Http\Request;


class TopCompaniesController extends Controller
{
    public function index()
    {
        return view('pages.top_companies');
    }

    public function get_top_companies()
    {
        $employers = Employer::paginate(10);
        return EmployerResource::collection($employers);
    }
}
