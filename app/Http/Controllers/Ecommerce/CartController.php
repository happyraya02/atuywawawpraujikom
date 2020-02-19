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
        $carts = json_decode(request()->cookie('dw-carts'), true);
        $carts = $carts != '' ? $carts : [];
        return $carts;
    }

    public function cart()
    {
        $carts = $this->getCarts();

        return view('frontend.cart', compact('carts'));
    }

    public function addToCart(Request $request)
    {
        //VALIDASI DATA YANG DIKIRIM
        $this->validate($request, [
            'galleri_id' => 'required|exists:galleries,id', //PASTIKAN PRODUCT_IDNYA ADA DI DB
            'qty' => 'required|integer' //PASTIKAN QTY YANG DIKIRIM INTEGER
        ]);

        //AMBIL DATA CART DARI COOKIE, KARENA BENTUKNYA JSON MAKA KITA GUNAKAN JSON_DECODE UNTUK MENGUBAHNYA MENJADI ARRAY
        $carts = $this->getCarts();

        //CEK JIKA CARTS TIDAK NULL DAN PRODUCT_ID ADA DIDALAM ARRAY CARTS
        if ($carts && array_key_exists($request->galleri_id, $carts)) {
            //MAKA UPDATE QTY-NYA BERDASARKAN PRODUCT_ID YANG DIJADIKAN KEY ARRAY
            $carts[$request->galleri_id]['qty'] += $request->qty;
        } else {
            //SELAIN ITU, BUAT QUERY UNTUK MENGAMBIL PRODUK BERDASARKAN PRODUCT_ID
            $produk = gallery::find($request->galleri_id);
            //TAMBAHKAN DATA BARU DENGAN MENJADIKAN produk_ID SEBAGAI KEY DARI ARRAY CARTS
            $carts[$request->galleri_id] = [
                'qty' => $request->qty,
                'galleri_id' => $produk->id,
                'nama_produk' => $produk->nama,
                'harga_produk' => $produk->harga,
                'foto_produk' => $produk->foto
            ];
        }

        //BUAT COOKIE-NYA DENGAN NAME DW-CARTS
        //JANGAN LUPA UNTUK DI-ENCODE KEMBALI, DAN LIMITNYA 2800 MENIT ATAU 48 JAM

        $cookie = cookie('dw-carts', json_encode($carts), 36000);
        Cookie::queue($cookie);
        return response()->json('Berhasil');
    }

    public function subtotal()
    {
        //MENGAMBIL DATA DARI COOKIE
        $carts = $this->getCarts();

        //UBAH ARRAY MENJADI COLLECTION, KEMUDIAN GUNAKAN METHOD SUM UNTUK MENGHITUNG SUBTOTAL
        $subtotal = collect($carts)->sum(function ($q) {
            return $q['qty'] * $q['harga_produk']; //SUBTOTAL TERDIRI DARI QTY * PRICE
        });

        //LOAD VIEW CART.BLADE.PHP DAN PASSING DATA CARTS DAN SUBTOTAL
        return response()->json($subtotal);
    }

    public function updateCart(Request $request)
    {
        //AMBIL DATA DARI COOKIE
        $carts = $this->getCarts();

        if (is_null($request->galleri_id)) {
            return response()->json('Error : Your Product Not Found, Please Refresh Again or Try Again to AddToCart Your Product', 500);
        }
        //KEMUDIAN LOOPING DATA PRODUCT_ID, KARENA NAMENYA ARRAY PADA VIEW SEBELUMNYA
        //MAKA DATA YANG DITERIMA ADALAH ARRAY SEHINGGA BISA DI-LOOPING
        foreach ($request->galleri_id as $key => $row) {
            //DI CHECK, JIKA QTY DENGAN KEY YANG SAMA DENGAN PRODUCT_ID = 0
            if ($request->qty[$key] == 0) {
                //MAKA DATA TERSEBUT DIHAPUS DARI ARRAY
                unset($carts[$row]);
            } else {
                //SELAIN ITU MAKA AKAN DIPERBAHARUI
                $carts[$row]['qty'] = $request->qty[$key];
            }
        }
        //SET KEMBALI COOKIE-NYA SEPERTI SEBELUMNYA
        $cookie = cookie('dw-carts', json_encode($carts), 36000);
        //DAN STORE KE BROWSER.
        Cookie::queue($cookie);
        return response()->json('Berhasil');
    }

    public function totalproduk()
    {
        $carts = $this->getCarts();
        $total = count($carts);
        return response()->json($total);
    }
}
