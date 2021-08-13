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
                            @hasanyrole('webmaster|admin')
                            <a href={{ route('pencairan.create') }} class="btn btn-success">Tambah</a>
                            @endhasanyrole

                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Tahun :</strong></label>
                                        <select name="year" id="year" class="custom-select form-control">
                                            <option value="all">Semua</option>
                                            @foreach ($years as $year)
                                                <option value="{{ $year->id }}" @if (now()->year == $year->year) selected @endif>{{ $year->year }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Triwulan :</strong></label>
                                        <select name="triwulan" id="triwulan" class="custom-select form-control">
                                            <option value="all" selected>Semua</option>
                                            <option value="1">Triwulan 1</option>
                                            <option value="2">Triwulan 2</option>
                                            <option value="3">Triwulan 3</option>
                                            <option value="4">Triwulan 4</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label><strong>Rekening :</strong></label>
                                        <select class="custom-select form-control" name="reks" id="reks">
                                            <option value="all" selected>Semua</option>
                                            {!! $sel !!}
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="table-striped ">
                                <div class="table-responsive">

                                    <table id="dataTable" class="table table-striped  dt-responsive ">
                                        <thead>
                                            <tr class="text-center">
                                                <th>#</th>
                                                <th>No. Rekening</th>
                                                <th>Triwulan</th>
                                                <th>Nominal</th>
                                                <th>Tgl. Kegiatan</th>
                                                <th>Tgl. Pencairan</th>
                                                <th>Download</th>
                                                @hasanyrole('webmaster|admin')
                                                <th>Aksi</th>
                                                @endhasanyrole
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
    @hasanyrole('webmaster|admin')
    <script>
        $(function() {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: {
                    url: '{!! url()->current() !!}',
                    data: function(d) {
                        d.year = $('#year').val();
                        d.triwulan = $('#triwulan').val();
                        d.reks = $('#reks').val();
                    },

                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                    },
                    {
                        data: 'no_rek',
                        name: 'no_rek',
                        className: 'text-center',
                        orderable: false,

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
        })
    </script>
@else
    <script>
        $(function() {
            var table = $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: {
                    url: '{!! url()->current() !!}',
                    data: function(d) {
                        d.year = $('#year').val();
                        d.triwulan = $('#triwulan').val();
                        d.reks = $('#reks').val();
                    },

                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center',
                        orderable: false,
                    },
                    {
                        data: 'no_rek',
                        name: 'no_rek',
                        className: 'text-center',
                        orderable: false,

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


                ]
            });
        })
    </script>
    @endhasanyrole
    <script>
        $(function() {
            $('#year, #triwulan, #reks').change(function() {
                table.draw();
            });

            // Hapus data via ajax
            $(document).on('click', '.btn-delete', function(e) {
                var id = $(this).data('id');
                var url = $(this).data('act');

                swal({
                        title: "Yakin hapus data Pencairan ?",
                        text: '',
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
