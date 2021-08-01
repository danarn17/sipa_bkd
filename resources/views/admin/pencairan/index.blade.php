@extends('layouts.app')
@section('title')
    Pencairan
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Pencairan</h3>
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
                            <h4>Daftar Pencairan</h4>
                            {{-- <button type="button" id="btn-add" class="btn btn-success" data-toggle="modal"
                                data-target="#form-modal">Tambah</button> --}}
                            <a href={{ route('pencairan.create') }} class="btn btn-success">Tambah</a>
                        </div>
                        <div class="card-body">
                            <div class="table-striped ">
                                <div class="table-responsive">

                                    <table id="dataTable" class="table table-striped    table-md">
                                        <thead>
                                            <tr class="text-center">
                                                <th>#</th>
                                                <th>No. Rekening</th>
                                                <th>Triwulan</th>
                                                <th>Nominal</th>
                                                <th>Tgl. Kegiatan</th>
                                                <th>Tgl. Pencairan</th>
                                                <th>Downlad</th>
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
        </div>
    </section>

@endsection

@section('scripts')
    <script src="{{ asset('assets/js/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>


    {{-- // Sweetalert Notifikasi --}}
    @if (session()->get('status') == 'hapus sukses')
        <script>
            $(document).ready(function() {
                swal("Sukses!", "Anggaran berhasil terhapus..", "success");
            })
        </script>
    @endif

    @if (session()->get('status') == 'sukses')
        <script>
            $(document).ready(function() {
                swal("Sukses!", "Anggaran berhasil disimpan..", "success");
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
                        data: 'no_rek',
                        name: 'no_rek',
                        className: 'text-center'
                    },
                    {
                        data: 'triwulan',
                        name: 'triwulan',
                        className: 'text-center'
                    },
                    {
                        data: 'nominal',
                        name: 'nominal',
                        className: 'text-center'

                    },
                    {
                        data: 'tgl_kegiatan',
                        name: 'tgl_kegiatan',
                        className: 'text-center'
                    },
                    {
                        data: 'tgl_pencairan',
                        name: 'tgl_pencairan',
                        className: 'text-center'
                    },
                    {
                        data: 'archive',
                        name: 'archive',
                        className: 'text-center'
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
                $('.modal-title').html('Edit Anggaran')
                $('.modal-footer button[type=submit]').html('Simpan')
                var url = $(this).data('act');
                $('.modal form').attr('action', url)
                var det = $(this).data('det');
                $.ajax({
                    url: det,
                    cache: true,
                    method: 'GET',
                    datatype: 'JSON',
                    success: function(data) {
                        var data = data.data
                        $('input[name = year]').val(data.year)
                        $('input[name = triwulan_1]').val(data.triwulan_1)
                        $('input[name = triwulan_2]').val(data.triwulan_2)
                        $('input[name = triwulan_3]').val(data.triwulan_3)
                        $('input[name = triwulan_4]').val(data.triwulan_4)

                        $('input[name = _method]').val('PUT')

                    }
                });

            })

            $('#btn-add').click(function() {
                $('.modal-title').html('Tambah Anggaran')
                $('.modal-footer button[type=submit]').html('Tambah')
                $('.modal form').attr('action', "{{ route('pencairan.store') }}")
                $('.modal form').attr('method', 'post')

                $('input[name = year]').val('')
                $('input[name = triwulan_1]').val('')
                $('input[name = triwulan_2]').val('')
                $('input[name = triwulan_3]').val('')
                $('input[name = triwulan_4]').val('')
                $('input[name = _method]').val('')

            })

            // Hapus data via ajax
            $(document).on('click', '.btn-delete', function(e) {
                var id = $(this).data('id');
                var url = $(this).data('act');

                swal({
                        title: "Yakin hapus Anggaran ?",
                        text: 'Seluruh sub dalam Anggaran ini akan ikut terhapus!',
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
                                    table.draw();
                                }
                            });
                        } else {

                        }
                    });
            });

            $(".finn").on("keyup", function(event) {
                // When user select text in the document, also abort.
                var selection = window.getSelection().toString();
                if (selection !== '') {
                    return;
                }
                // When the arrow keys are pressed, abort.
                if ($.inArray(event.keyCode, [38, 40, 37, 39]) !== -1) {
                    return;
                }
                var $this = $(this);
                // Get the value.

                var input = $this.val();
                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt(input, 10) : 0;
                $this.val(function() {
                    return (input === 0) ? 0 : input.toLocaleString("id-ID");
                });
            });
        });
    </script>
@endsection
