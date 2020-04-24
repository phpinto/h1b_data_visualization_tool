<?php

namespace App\Http\Resources;
use App\Employer;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployerResource extends JsonResource
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
            'employer' => $this->employer,
            'avg_salary' => $this->avg_salary,
            'avg_num_filings' => $this->avg_num_filings,
        ];
    }

    public function with($request) {
        return [
            'version' => '1.0.0',
            'author_url' => 'Pedro Pinto'
        ];
    }
}
