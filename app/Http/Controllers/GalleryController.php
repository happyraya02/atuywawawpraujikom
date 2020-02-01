<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use DataTables;
use App\gallery;
use Illuminate\Support\Facades\File;
use Auth;
use DB;
class GalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = gallery::with('kategori')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-warning btn-sm edit"><i class="nav-icon fas fa-pen" style="color:white"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm hapus"><i class="nav-icon fas fa-trash" style="width:15px"></i></a>';

                    return $btn;
                })
                ->addColumn('gambar', function ($data) {
                    $img = '<img src="../assets/poto/' . $data->foto . '" alt="" width="100%" height="15%">';
                    return $img;
                })
                ->rawColumns(['action', 'gambar'])
                ->make(true);
        }
        return view('admin.gallery');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = Str::slug($request->nama, '-');

        if (is_null($request->galleri_id)) {
            $photo = Str::random(6) . $request->file('foto')->getClientOriginalName();
            $request->foto->move(public_path('assets/poto'), $photo);
            gallery::updateOrCreate(
                ['id' => $request->galleri_id],
                [
                    'nama' => $request->nama,
                    'slug' => $slug,
                    'id_kategori' => $request->id_kategori,
                    'harga' => $request->harga,
                    'stok' => $request->stok,
                    'konten' => $request->konten,
                    'foto' => $photo,

                ]
            );
        } else {
            if (is_null($request->foto)) {
                gallery::updateOrCreate(
                    ['id' => $request->galleri_id],
                    [
                        'nama' => $request->nama,
                        'slug' => $slug,
                        'id_kategori' => $request->id_kategori,
                        'harga' => $request->harga,
                        'stok' => $request->stok,
                        'konten' => $request->konten

                    ]
                );
            } else {
                $old_photo = \DB::select('SELECT foto FROM galleries WHERE id = ' . $request->galleri_id . '');
                $data = '';
                foreach ($old_photo as $value) {
                    $data .= $value->foto;
                }
                $image_path = "assets/poto/" . $data;
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
                $photo = Str::random(6) . $request->file('foto')->getClientOriginalName();
                $request->foto->move(public_path('assets/poto'), $photo);
                gallery::updateOrCreate(
                    ['id' => $request->galleri_id],
                    [
                        'nama' => $request->nama,
                        'slug' => $slug,
                        'id_kategori' => $request->id_kategori,
                        'harga' => $request->harga,
                        'stok' => $request->stok,
                        'konten' => $request->konten,
                        'foto' => $photo,

                    ]
                );
            }
        }

        return response()->json(['success' => ' Berhasil di Simpan']);
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
        $gallery = gallery::find($id);
        $kategori = \DB::select('SELECT id,nama FROM kategoris');
        foreach ($kategori as $value) {
            $data[] = '<option value="' . $value->id . '" ' . ($value->id == $gallery->id_kategori ? 'selected' : '') . '>' . $value->nama . '</option>';
        }

        $option = implode('', $data);
        $data = ['gallery' => $gallery, 'kategori' => $option];
        return response()->json($data);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $gallery = gallery::find($id);
        $image_path = "assets/poto/" . $gallery->foto;
        if (File::exists($image_path)) {
            File::delete($image_path);
        }
        $gallery->delete();
        return response()->json(['success' => 'Berhasil Dihapus']);
    }
}
