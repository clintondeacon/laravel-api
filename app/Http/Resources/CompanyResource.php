<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\Company;
use App\Models\Station;
use Illuminate\Support\Facades\DB;

class CompanyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $companyids = DB::table("companies")->select('companies.company_ids')->whereRaw('companies.id = '.$this->id)->get()[0]->company_ids;

        return [
            'id' => $this->id,
            'name' => $this->name,
            'children' => Company::with('children')->where('company_ids','IN',$companyids)->get(),
            'stations' => Station::query()->whereRaw('FIND_IN_SET(company_id,\''.$companyids.'\')')->get(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
