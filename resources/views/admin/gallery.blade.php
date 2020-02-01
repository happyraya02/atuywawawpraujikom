@extends('layouts.backend')

@section('content')
 <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Gallery</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="/admin">Home</a></li>
              <li class="breadcrumb-item active">Gallery</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-body">
          <a class="btn btn-primary" href="javascript:void(0)" id="tambahdata">
            Tambah Data
          </a>
          <br/>
          <br/>
          <table class="table table-bordered data-table" width="100%">
          <thead class="thead-dark">
              <tr>
                  <th width="10px">No</th>
                  <th>Foto</th>
                  <th>Nama</th>
                  <th>Slug</th>
                  <th>Kategori</th>
                  <th>Harga</th>
                  <th>Stok</th>
                  <th width="71px">Opsi</th>
              </tr>
          </thead>
          <tbody>

          </tbody>
        </div>
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>


<!-- {{-- modal mulai --}} -->
<div class="modal fade" id="modal" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <!-- Bagian header modal-->
            <div class="modal-header">
                <h4 class="modal-title">Tambah Data</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <img src="{{ asset('assets/backend/open-iconic/svg/x.svg') }}">
                </button>
            </div>
            <!-- Akhir Bagian header modal-->
            <!-- Bagian Body Modal-->
            <div class="modal-body">
                <!-- Form-->
                <form id="form" name="form" class="form-horizontal" enctype="multipart/form-data">
                    <input type="hidden" name="galleri_id" id="galleri_id">
                    <div class="row">
                        <div class="col-sm-6">
                            <label for="name" class="control-label">Nama gallery</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama gallery" autocomplete="off" required>
                            <p style="color: red;" id="error_nama"></p>
                        </div>
                        <div class="col-sm-6">
                            <label for="name" class="control-label">Kategori</label>
                            <select name="id_kategori" id="id_kategori" class="select2 select2-selection--single">
                              <option></option>
                            </select>
                            <p style="color: red;" id="error_kategori"></p>
                        </div>
                        <div class="col-sm-6">
                            <label for="name" class="control-label">Harga</label>
                            <input type="text" class="form-control" id="harga" name="harga" placeholder="Harga" autocomplete="off" required>
                            <p style="color: red;" id="error_harga"></p>
                        </div>
                        <div class="col-sm-6">
                            <label for="name" class="control-label">Stok</label>
                            <input type="text" class="form-control" id="stok" name="stok" placeholder="Stok" autocomplete="off" required>
                            <p style="color: red;" id="error_stok"></p>
                        </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-12">
                          <label for="name" class="control-label">Foto</label>
                          <input type="file" name="foto" id="foto" class="form-control">
                          <p style="color: red;" id="error_foto"></p>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-sm-12">
                          <label for="name" class="control-label">konten</label>
                          <textarea name="konten" id="konten" class="form-control" cols="30" rows="5" style="resize: none;"></textarea>
                          <p style="color: red;" id="error_konten"></p>
                      </div>
                    </div>
                </form>
                <!-- Akhir Form-->
            </div>
            <!-- modal footer-->
            <div class="modal-footer">
                <button data-dismiss="modal" type="button" class="btn btn-danger pull-left"
                id="reset">Batal</button>

                <button align="right" type="submit" class="btn btn-primary" id="simpan">Simpan</button>
            </div>
            <!-- Akhir modal footer-->
        </div>
    </div>
</div>
<!-- modal berakhir -->
@endsection

@section('js')
<script>
$('.select2').select2({
    placeholder: "Pilih Kategori",
    allowClear: true
});
</script>
<script type="text/javascript">
    $(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      //INDEX TABEL
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('admin/gallery') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'gambar', name: 'gambar'},
            {data: 'nama', name: 'nama'},
            {data: 'slug', name: 'slug'},
            {data: 'kategori.nama', name: 'id_kategori'},
            {data: 'harga', name: 'harga'},
            {data: 'stok', name: 'stok'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    $('#tambahdata').click(function () {
        $('#form').trigger("reset");
        $('#id_kategori').trigger("reset");
        $('#galleri_id').val('');
        $('#modal').modal({backdrop: 'static', keyboard: false});
        $('#modal').modal('show');
    });
    $('body').on('click','.edit',function(){
        var idgallery = $(this).data('id');
        $.get("{{ url('admin/gallery') }}"+"/"+idgallery+"/edit", function(data){
            // console.log(data);
            $('#modal').modal({backdrop: 'static', keyboard: false});
            $('#modal').modal('show');
            $('#galleri_id').val(data.gallery.id);
            $('#nama').val(data.gallery.nama);
            $('#id_kategori').html('');
            $('#id_kategori').html(data.kategori);
            $('#harga').val(data.gallery.harga);
            $('#stok').val(data.gallery.stok);
            // $('#foto').html(data.gallery.foto);
            $('#konten').val(data.gallery.konten);
        });
    });
    $('body').on('click','.hapus', function(){
        var idgallery = $(this).data('id');
        $.ajax({
            type: "DELETE",
            url: "{{ url('admin/gallery-destroy') }}"+"/"+idgallery,
            success: function(data){
                table.draw();
            },
            error: function(request, status, error) {
                console.log(error);
            }
        });
    });
    //KETIKA BUTTON SAVE DI KLIK
    $('#simpan').click(function (e) {
        e.preventDefault();
        // $(this).hide();
        var formdata = new FormData($('#form')[0]);
        $.ajax({
            data: formdata,
            url: "{{ url('admin/gallery-store') }}",
            type: "POST",
            cache:false,
            contentType: false,
            processData: false,
            success: function (data) {
                $('#form').trigger("reset");
                $('#modal').modal('hide');
                table.draw();
                Swal.fire({
                    icon: 'success',
                    title: 'Your work has been saved',
                    showConfirmButton: false,
                    timer: 1000
                });
            },
            error: function (request, status, error) {
                console.log(error);
            }
        });
    });
    $.ajax({
        url: "{{ url('admin/kategori') }}",
        method: "GET",
        dataType: "json",
        success: function (berhasil) {
            $.each(berhasil.data, function (key, value) {
                $('#id_kategori').append(
                    `
                    <option value="${value.id}">
                        ${value.nama}
                    </option>
                    `
                )
            })
        },
        error: function () {
            console.log('data tidak ada');
        }
    });
});
</script>
@endsection
