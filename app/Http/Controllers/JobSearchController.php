<?php

namespace App\Http\Controllers;
use App\Filing;
use App\Http\Resources\FilingResource;

use Illuminate\Http\Request;

class JobSearchController extends Controller
{
    public function index()
    {
        return view('pages.jobsearch');
    }

    public function get_jobs($job_title = "", $employer = "", $city = "", $state = "", $year = "")
    {

        if ($job_title == "*****") $job_title = "";
        if ($employer == "*****") $employer = "";
        if ($city == "*****") $city = "";
        if ($state == "*****") $state = "";
        if ($year == "*****") $year = "";
        if ($job_title == "" && $employer == "" && $city == "" && $state == "" && $year == "") {
            $jobs = Filing::take(1000)
            ->paginate(15);
        }
        else {
            
            $jobs = Filing::where([
                ['job_title', 'like', '%'.$job_title.'%'],
                ['employer', 'like', '%'.$employer.'%'],
                ['city', 'like', '%'.$city.'%'],
                ['state', 'like', '%'.$state.'%'],
                ['year', 'like', '%'.$year.'%'],
                ])
                ->limit(1000)
                ->paginate(15);
        }
        return FilingResource::collection($jobs);
        

    }
}
