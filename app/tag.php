<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class tag extends Model
{
    protected $fillable = ['nama','slug'];
    public $timestamps = true;
    public function galleri()
    {
        return $this->belongsToMany('App\galleri','galleri_tag','id_tag','id_galleri');
}
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
