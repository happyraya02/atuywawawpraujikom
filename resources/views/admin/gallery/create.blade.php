{{-- @extends('layouts.index') --}}
{{-- @section('css')
<link rel="stylesheet" href="{{asset('assets/backend/assets/vendor/select2/select2.min.css')}}">
@endsection --}}

{{-- @section('js')
<script src="{{asset('assets/backend/assets/vendor/select2/select2.min.js')}}"></script>
<script src="{{asset('assets/backend/assets/js/components/select2-init.js')}}"></script>
@endsection --}}
{{-- @section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Membuat Data Gallery</div>
                <div class="card-body">
                    <form action="{{ route('gallery.store') }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="">Judul</label>
                            <input class="form-control" type="text" name="judul">
                        </div>
                        <div class="form-group">
                            <label>Konten</label>
                            <textarea class="ckeditor" id="ck" rows="8" cols="30" name="konten"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Foto</label>
                            <input type="file" class="form-control" name="foto">
                        </div>
                        <div class="form-group">
                            <label for="">Tag</label><br>
                            <select name="tag[]" id="select2" class="form-control select2 multiple" multiple="multiple">
                        @foreach($tag as $data)
                            <option value="{{ $data->id }}">
                                {{ $data->nama }}
                            </option>
                        @endforeach
                            </select>
                            </div>
                        <div class="form-group">
                            <label for="">Kategori</label>
                            <select name="id_kategori" class="form-control">
                        @foreach($kategori as $data)
                            <option value="{{ $data->id }}">
                                {{ $data->nama}}
                            </option>
                        @endforeach
                            </select>
                            </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-info">
                            Simpan Data
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script>
   CKEDITOR.replace('ck', options);
</script> --}}
{{-- <script>
$(document).ready(function() {
    $('.#select2').select2();
});
</script> --}}
{{-- @endsection --}}
