<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class gallery extends Model
{
    protected $fillable = [
        'judul', 'slug', 'foto',
        'konten', 'id_user', 'id_kategori'
    ];
    public $timestamps = true;
    public function kategori()
    {
        return $this->belongsTo('App\kategori', 'id_kategori');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'id_user');
    }
    public function tag()
    {
        return $this->belongsToMany('App\tag','galleri_tag','id_galleri','id_tag');
    }
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
