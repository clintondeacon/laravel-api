<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = ['parent_id', 'name'];

    public function parent()
    {
        return $this->belongsTo('App\Models\Company','id','parent_id')->with('parent');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Company','parent_id','id')->with('children');
    }
}
