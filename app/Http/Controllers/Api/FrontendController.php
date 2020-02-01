<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\gallery;
use App\kategori;
class FrontendController extends Controller
{
    public function latest(){
        $latest = gallery::take(9)->get();

        $response = [
            'success' => true,
            'data' => $latest,
            'message' => 'Berhasil'
        ];
        return response()->json($response, 200);
    }

    public function shop(){
        $kategori = kategori::take(7)->get();
        $gallery = gallery::take(6)->get();
        $response = [
            'success' => true,
            'data' => [
                'kategori' => $kategori,
                'gallery' => $gallery
            ],
            'message' => 'Berhasil'
        ];
        return response()->json($response, 200);
    }

    public function kategorishop(kategori $kategori){
        $gallery = $kategori->gallery()->take(6)->get();
        $kategoris = kategori::take(7)->get();
        $response = [
            'success' => true,
            'data' => [
                'kategori' => $kategoris,
                'gallery' => $gallery
            ],
            'message' => 'Berhasil'
        ];
        return response()->json($response, 200);
    }

    public function produkdetail(gallery $gallery){
       $gallery = gallery::where('slug', '=', $gallery->slug)->first();


        $response = [
            'success' => true,
            'data' => $gallery,
            'message' => 'Berhasil'
        ];
        return response()->json($response, 200);
    }
}
