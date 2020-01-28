<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class kategori extends Model
{
    protected $fillable = ['nama','slug'];
    public $timestamps = true;
    public function gallery()
    {
        return $this->hasMany('App\gallery', 'id_kategori');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
