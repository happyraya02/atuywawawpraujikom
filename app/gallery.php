<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gallery extends Model
{
    protected $fillable = [
        'nama', 'slug', 'foto',
        'konten','harga','stok', 'id_kategori'
    ];
    public $timestamps = true;


    public function kategori()
    {
        return $this->belongsTo('App\kategori', 'id_kategori');
    }

    public function stokmasuk()
    {
        return $this->hasMany('App\StokMasuk','galleri_id');
    }


    public function getRouteKeyName()
    {
        return 'slug';
    }
}
