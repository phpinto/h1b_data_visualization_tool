<?php

namespace App\Http\Resources;
use App\Listing;

use Illuminate\Http\Resources\Json\JsonResource;

class FilingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'case_status' => $this->case_status,
            'employer' => $this->employer,
            'job_category' => $this->job_category,
            'job_title' => $this->job_title,
            'full_time' => $this->full_time,
            'salary' => $this->salary,
            'year' => $this->year,
            'city' => $this->city,
            'state' => $this->state,
            'logitude' => $this->logitude,
            'latitude' => $this->latitude,
        ];
    }

    public function with($request) {
        return [
            'version' => '1.0.0',
            'author_url' => 'Pedro Pinto'
        ];
    }
}
