<?php

namespace App\Http\Controllers\Ecommerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\gallery;
use Cookie;

class CartController extends Controller
{
    private function getCarts()
    {
        $carts = json_decode( request()->cookie('dw-carts'), true);
        $carts = $carts != '' ? $carts : [];
        return $carts;
    }
    public function store(Request $request)
    {
    //VALIDASI DATA YANG DIKIRIM
    $this->validate($request, [
        'galleri_id' => 'required|exists:galleries,id', //PASTIKAN galleri_idNYA ADA DI DB
        'qty' => 'required|integer' //PASTIKAN QTY YANG DIKIRIM INTEGER
    ]);

    //AMBIL DATA CART DARI COOKIE, KARENA BENTUKNYA JSON MAKA KITA GUNAKAN JSON_DECODE UNTUK MENGUBAHNYA MENJADI ARRAY
    $carts = $this->getCarts();

    //CEK JIKA CARTS TIDAK NULL DAN galleri_id ADA DIDALAM ARRAY CARTS
    if ($carts && array_key_exists($request->galleri_id, $carts)) {
        //MAKA UPDATE QTY-NYA BERDASARKAN galleri_id YANG DIJADIKAN KEY ARRAY
        $carts[$request->galleri_id]['qty'] += $request->qty;
    } else {
        //SELAIN ITU, BUAT QUERY UNTUK MENGAMBIL PRODUK BERDASARKAN galleri_id
        $galleri = gallery::find($request->galleri_id);
        //TAMBAHKAN DATA BARU DENGAN MENJADIKAN galleri_id SEBAGAI KEY DARI ARRAY CARTS
        $carts[$request->galleri_id] = [
            'qty' => $request->qty,
            'galleri_id' => $galleri->id,
            'nama' => $galleri->nama,
            'harga' => $galleri->harga,
            'foto' => $galleri->foto
        ];
    }

    //BUAT COOKIE-NYA DENGAN NAME DW-CARTS
    //JANGAN LUPA UNTUK DI-ENCODE KEMBALI, DAN LIMITNYA 2800 MENIT ATAU 48 JAM
    $cookie = cookie('dw-carts', json_encode($carts), 2880);
    return redirect()->back()->cookie($cookie);
    }


    public function listCart()
    {
    //MENGAMBIL DATA DARI COOKIE
    $carts = $this->getCarts();
    //UBAH ARRAY MENJADI COLLECTION, KEMUDIAN GUNAKAN METHOD SUM UNTUK MENGHITUNG SUBTOTAL
    $subtotal = collect($carts)->sum(function($q) {
        return $q['qty'] * $q['harga_gallery']; //SUBTOTAL TERDIRI DARI QTY * PRICE
    });
    //LOAD VIEW CART.BLADE.PHP DAN PASSING DATA CARTS DAN SUBTOTAL
    return view('frontend.cart', compact('carts', 'subtotal'));
    }
}
