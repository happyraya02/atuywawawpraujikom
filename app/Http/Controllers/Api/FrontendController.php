<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\gallery;
class FrontendController extends Controller
{
    public function latest(){
        $latest = gallery::take(4)->get();

        $response = [
            'success' => true,
            'data' => $latest,
            'message' => 'Berhasil',
        ];
        return response()->json($response, 200);
    }
}
