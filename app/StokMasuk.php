<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StokMasuk extends Model
{
    protected $fillable = ['galleri_id', 'qty', 'tgl'];
    public $timestamps = true;

    public function gallery()
    {
        return $this->belongsTo('App\gallery', 'galleri_id');
    }
}
