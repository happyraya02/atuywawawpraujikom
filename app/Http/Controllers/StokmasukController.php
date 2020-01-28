<?php

namespace App\Http\Controllers;
use App\gallery;
use Illuminate\Http\Request;
use App\StokMasuk;
use DataTables;
use DB;
class StokmasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = StokMasuk::with('gallery')->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-warning btn-sm edit"><i class="nav-icon fas fa-pen" style="color:white"></i></a>';
                    $btn = $btn . ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm hapus"><i class="nav-icon fas fa-trash" style="width:15px"></i></a>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.stokmasuk');
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

        DB::transaction(function () use ($request) {

            $stokgallery = '';
            $getdatagallery = \DB::select('SELECT stok FROM galleries WHERE id = ' . $request->galleri_id . '');
            foreach ($getdatagallery as $value) {
                $stokgallery .= $value->stok;
            }

            if (isset($request->stokmasuk_id)) {
                $data = '';
                $getdata = \DB::select('select qty from stok_masuks where id =' . $request->stokmasuk_id . '');
                foreach ($getdata as $key) {
                    $data .= $key->qty;
                }
                //
                $old_qty = $data;
                $qty = $request->qty;

                if ($qty < $old_qty) {
                    $new_qty = $old_qty - $qty;
                    $stok = $stokgallery - $new_qty;
                    gallery::updateOrCreate(
                        ['id' => $request->galleri_id],
                        ['stok' => $stok]
                    );
                } elseif ($qty > $old_qty) {

                    $new_qty = $qty - $old_qty;
                    $stok = $stokgallery + $new_qty;
                    gallery::updateOrCreate(
                        ['id' => $request->galleri_id],
                        ['stok' => $stok]
                    );
                } else {
                    gallery::updateOrCreate(
                        ['id' => $request->galleri_id],
                        ['stok' => $stokgallery]
                    );
                }
            } else {
                $stok = $stokgallery + $request->qty;
                gallery::updateOrCreate(
                    ['id' => $request->galleri_id],
                    ['stok' => $stok]
                );
            }

            StokMasuk::updateOrCreate(
                ['id' => $request->stokmasuk_id],
                [
                    'tgl' => $request->tgl,
                    'galleri_id' => $request->galleri_id,
                    'qty' => $request->qty
                ]
            );
        });

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
        $stokmasuk = StokMasuk::find($id);
        $gallery = \DB::select('SELECT id,nama FROM galleries');
        foreach ($gallery as $value) {
            $data[] = '<option value="' . $value->id . '" ' . ($value->id == $stokmasuk->galleri_id ? 'selected' : '') . '>' . $value->nama . '</option>';
        }

        $option = implode('', $data);

        return response()->json(['stokmasuk' => $stokmasuk, 'gallery' => $option]);
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
        StokMasuk::find($id)->delete();
        return response()->json(['success' => 'Berhasil Dihapus']);
    }
}
