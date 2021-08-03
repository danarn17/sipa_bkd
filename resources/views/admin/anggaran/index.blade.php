@extends('layouts.app')
@section('title')
    Anggaran
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Anggaran</h3>
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
                            <h4>Daftar Anggaran</h4>
                            {{-- <button type="button" id="btn-add" class="btn btn-success" data-toggle="modal"
                                data-target="#form-modal">Tambah</button> --}}
                            <a href={{ route('anggaran.create') }} class="btn btn-success">Tambah</a>
                        </div>
                        <div class="card-body">
                            <div class="table-striped ">
                                <table id="dataTable" class="table table-striped dt-responsive table-md">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>Tahun</th>
                                            <th>TRIWULAN 1</th>
                                            <th>TRIWULAN 2</th>
                                            <th>TRIWULAN 3</th>
                                            <th>TRIWULAN 4</th>
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

    <div class="modal lg fade" id="form-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <form action="{{ route('anggaran.store') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Anggaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tahun</label>
                            <input type="number" name="year" class="form-control" placeholder="Masukkan Tahun">
                        </div>
                        <div class="form-group row">

                            <div class="form-group col-md-6">
                                <label>TRIWULAN 1</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="text" name="triwulan_1" class="finn form-control"
                                        placeholder="Anggaran Triwulan 1">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>TRIWULAN 2</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="text" name="triwulan_2" class="finn form-control"
                                        placeholder="Anggaran Triwulan 2">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>TRIWULAN 3</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="text" name="triwulan_3" class="finn form-control"
                                        placeholder="Anggaran Triwulan 3">
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>TRIWULAN 4</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">Rp.</span>
                                    </div>
                                    <input type="text" name="triwulan_4" class="finn form-control"
                                        placeholder="Anggaran Triwulan 4">
                                </div>
                            </div>
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
                responsive: true,
                ajax: "{{ url()->current() }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        className: 'text-center'
                    },
                    {
                        data: 'year',
                        name: 'year'
                    },
                    {
                        data: 'triwulan_1',
                        name: 'triwulan_1'
                    },
                    {
                        data: 'triwulan_2',
                        name: 'triwulan_2'
                    },
                    {
                        data: 'triwulan_3',
                        name: 'triwulan_3'
                    },
                    {
                        data: 'triwulan_4',
                        name: 'triwulan_4'
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
                $('.modal form').attr('action', "{{ route('anggaran.store') }}")
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
