<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\kategori;
use App\tag;
use App\gallery;
use Session;
use Auth;
use File;
class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gallery = gallery::with('kategori', 'tag', 'user')->get();
            $response = [
                'success' => true,
                'data' =>  $gallery,
                'message' => 'Berhasil!'
            ];
        // return response()->json($response, 200);
        return view('admin.gallery.index', compact('gallery'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $kategori = kategori::all();
        $tag = tag::all();
        return view('admin.gallery.create', compact('kategori', 'tag'));
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'foto' => 'required|mimes:jpeg,jpg,png,gif|required|max:2560',
            'id_kategori' => 'required',
            'tag' => 'required'
        ]);
        $gallery = new gallery();
        $gallery->judul = $request->judul;
        $gallery->slug = str::slug($request->judul, '-');
        $gallery->konten = $request->konten;
        $gallery->id_user = Auth::user()->id;
        $gallery->id_kategori = $request->id_kategori;
        //foto
        if ($request->hasFile('foto')){
            $file = $request->file('foto');
            $path = public_path() . '/assets/img/gallery/';
            $filename = str_random(6) . '_' . $file->getClientOriginalName();
            $upload = $file->move($path, $filename);
            $gallery->foto = $filename;
        }
        $gallery->save();
        $gallery->tag()->attach($request->tag);

        $response = [
                'success' => true,
                'data' =>  $gallery,
                'message' => 'Berhasil!'
            ];
            return redirect()->route('gallery.index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required|min:50',
            'id_kategori' => 'required',
            'tag' => 'required'
        ]);
        $gallery = gallery::findOrFail($id);
        $gallery->judul = $request->judul;
        $gallery->slug = str::slug($request->judul, '-');
        $gallery->konten = $request->konten;
        $gallery->id_user = Auth::user()->id;
        $gallery->id_kategori = $request->id_kategori;
        //foto
        if ($request->hasFile('foto')){
            $file = $request->file('foto');
            $path = public_path() . '/assets/img/gallery/';
            $filename = str_random(6) . '_' . $file->getClientOriginalName();
            $uploadSuccsess = $file->move($path, $filename);
            //hapus foto lama
            if ($gallery->foto){
                $old_foto = $gallery->foto;
                $filepath = public_path() . '/assets/img/gallery/' . $gallery->foto;
                try {
                    File::delete($filepath);
                }
                catch (FileNotFoundException $e){
                    //File sudah dihapus atau tidak ada
                }
            }
            $gallery->foto = $filename;
        }
        $gallery->save();
        $gallery->tag()->sync($request->tag);
        $response = [
            'success' => true,
            'data' => $gallery,
            'message' => 'Berhasil Dirubah!'
        ];
        return redirect()->route('gallery.index');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = gallery::findOrFail($id);
        $blog = gallery::findOrFail($id);
        if ($gallery->foto){
            $old_foto = $gallery->foto;
            $filepath = public_path() . '/assets/img/gallery' . $gallery->foto;
            try {
                File::delete($filepath);
            }
            catch (FileNotFoundException $e){
                //File sudah dihapus/tidak ada
            }
        }
        $gallery->tag()->detach($gallery->id);
        $gallery->delete();
        $response = [
            'success' => true,
            'data' => $gallery,
            'message' => 'Berhasil Dihapus!'
        ];
        return redirect()->route('gallery.index');
    }
    // public function latest()
    // {
    //     $gallery = gallery::take(3)->get();
    //     $response = [
    //         'success' => true,
    //         'data' => $gallery,
    //         'message' => "Berhasil"
    //     ];
    //     return response()->json($response, 200);
    // }
}
