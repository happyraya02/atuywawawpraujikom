<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    protected $fillable = ['nama','slug'];
    public $timestamps = true;
    public function galleri()
    {
        return $this->hasMany('App\galleri', 'id_kategori');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
