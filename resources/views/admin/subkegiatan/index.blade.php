@extends('layouts.app')
@section('title')
    Sub Kegiatan
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Sub Kegiatan</h3>
        </div>
        <div class="section-body">
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <div class="alert alert-danger">
                        <li>{{ $error }}</li>
                    </div>
                @endforeach
            @endif
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>Daftar Sub Kegiatan</h4>
                            <button type="button" id="btn-add" class="btn btn-success" data-toggle="modal"
                                data-target="#form-modal">Tambah</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="dataTable" class="table table-striped dt-responsive table-md">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Nama Sub Kegiatan</th>
                                            <th>No. Rek.</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="form-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('subkeg.store') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Submenu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input hidden name="id">
                        <div class="form-group">
                            <label>Nama Sub Kegiatan</label>
                            <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Sub..">
                        </div>
                        <div class="form-group">
                            <label>No. Rekening</label>
                            <input type="text" name="no_rek" class="form-control" placeholder="Masukkan No Rekening..">
                        </div>
                        <input type="hidden" name="_method" value="">
                        @csrf

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    // Sweetalert Notifikasi
    @if (session()->get('status') == 'hapus sukses')
        <script>
            $(document).ready(function() {
                swal("Sukses!", "Sub Kegiatan berhasil terhapus..", "success");
            })
        </script>
    @endif

    @if (session()->get('status') == 'sukses')
        <script>
            $(document).ready(function() {
                swal("Sukses!", "Sub Kegiatan berhasil disimpan..", "success");
            })
        </script>
    @endif

    <script>
        $(function() {

            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: "{{ url()->current() }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'no_rek',
                        name: 'no_rek'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                ]
            });

            $("#dataTable").on('click', ".btn-edit", function() {
                $('.modal-title').html('Edit Sub Kegiatan')
                $('.modal-footer button[type=submit]').html('Simpan')
                var url = $(this).data('act');
                $('.modal form').attr('action', url)
                var det = $(this).data('det');
                $.ajax({
                    url: det,
                    cache: false,
                    method: 'GET',
                    datatype: 'JSON',
                    success: function(data) {
                        var data = data.data
                        $('input[name = name]').val(data.name)
                        $('input[name = no_rek]').val(data.no_rek)
                        $('input[name = _method]').val('PUT')
                    }
                });

            });


            $('#btn-add').click(function() {
                $('.modal-title').html('Tambah Sub Kegiatan')
                $('.modal-footer button[type=submit]').html('Tambah')
                $('.modal form').attr('action', "{{ route('subkeg.store') }}")
                $('.modal form').attr('method', 'post')

                $('input[name = name]').val('')
                $('input[name = no_rek]').val('')
                $('input[name = _method]').val('')

            })

            // Hapus data via ajax
            $(document).on('click', '.btn-delete', function(e) {
                var id = $(this).data('id');
                var url = $(this).data('act');
                swal({
                        title: "Yakin hapus Sub Kegiatan ?",
                        text: 'Seluruh sub dalam sub kegiatan ini akan ikut terhapus!',
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                type: "DELETE",
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                url: url,
                                success: function(data) {
                                    location.reload();
                                    // console.log(data);
                                }
                            });
                        } else {

                        }
                    });
            })


        });
    </script>
@endsection
