<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Station extends Model
{
    protected $fillable = ['name','latitude','longitude','company_id','address'];

    public function parent()
    {
        return $this->belongsTo('App\Models\Station','id','parent_id')->with('parent');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Station','parent_id','id')->with('children');
    }

}
