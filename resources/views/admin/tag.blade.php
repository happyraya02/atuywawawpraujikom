@extends('layouts.backend')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
            <h1>tag</h1>
            </div>
            <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="/admin">Home</a></li>
                <li class="breadcrumb-item active">tag</li>
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
            <table class="table table-bordered datatable" width="100%">
            <thead class="thead-dark">
                <tr>
                    <th width="10px">No</th>
                    <th>Nama</th>
                    <th>Slug</th>
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
                <form id="form" name="form" class="form-horizontal">
                    <input type="hidden" name="tag_id" id="tag_id">
                    <div class="form-group">
                        <div class="col-lg-12">
                            <label for="name" class="control-label">Nama tag</label>
                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Nama tag" maxlength="50" autocomplete="off" required>
                            <p style="color: red;" id="error_nama"></p>
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
<script type="text/javascript">
    $(function () {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
      //INDEX TABEL
    var table = $('.datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ url('admin/tag') }}",
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'nama', name: 'nama'},
            {data: 'slug', name: 'slug'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
    $('#tambahdata').click(function () {
        $('#tag_id').val('');
        $('#form').trigger("reset");
        $('#modal').modal({backdrop: 'static', keyboard: false});
        $('#modal').modal('show');
    });
    $('body').on('click','.edit',function(){
        var idtag = $(this).data('id');
        $.get("{{ url('admin/tag') }}"+"/"+idtag+"/edit", function(data){
            // console.log(data);
            $('#modal').modal({backdrop: 'static', keyboard: false});
            $('#modal').modal('show');
            $('#tag_id').val(data.id);
            $('#nama').val(data.nama);
        });
    });
    $('body').on('click','.hapus', function(){
        var idtag = $(this).data('id');
        $.ajax({
            type: "DELETE",
            url: "{{ url('admin/tag-destroy') }}"+"/"+idtag,
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
        $.ajax({
            data: $('#form').serialize(),
            url: "{{ url('admin/tag-store') }}",
            type: "POST",
            dataType: 'json',
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
});
</script>
@endsection
