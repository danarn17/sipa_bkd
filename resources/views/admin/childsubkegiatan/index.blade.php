@extends('layouts.app')
@section('title')
    Sub Sub Kegiatan
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Sub Sub Kegiatan</h3>
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
                            <h4>Daftar Sub Sub Kegiatan</h4>
                            <a href={{ route('childsubkegiatan.create') }} class="btn btn-success">Tambah</a>
                        </div>
                        <div class="card-body">
                            <div class="table-striped ">
                                <table id="dataTable" class="table table-striped table-md">
                                    <thead>
                                        <tr class="text-center">
                                            <th>#</th>
                                            <th>No. Rek.</th>
                                            <th>Uraian</th>
                                            <th>Level Sub</th>
                                            <th>Parent</th>
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
                <form action="{{ route('childsubkegiatan.store') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Submenu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Uraian</label>
                                    <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Sub..">
                                </div>
                                <div class="form-group">
                                    <label>Level Sub</label>
                                    <select name="level_sub" id="level" class="form-control">
                                        @for ($i = 1; $i < 6; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>No. Rekening</label>
                                    <input type="text" name="no_rek_sub" class="form-control"
                                        placeholder="Masukkan No Rekening..">
                                </div>

                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Parent</label>
                                    <select name="child_of" id="" class="form-control">
                                        @foreach ($parent as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </div>

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

    <script>
        $(function() {
            $("#level").on('change', function() {
                const val = $(this).val();


                // $.ajax({
                //     url: "{{ route('getParent') }}",
                //     data: {
                //         _token: "{{ csrf_token() }}",
                //         level: val
                //     },
                //     method: 'POST',
                //     success: function(data) {
                //         console.log(data.data);

                //     }
                // });
            })
        })

    </script>

    {{-- // Sweetalert Notifikasi --}}
    @if (session()->get('status') == 'hapus sukses')
        <script>
            $(document).ready(function() {
                swal("Sukses!", "Sub Sub Kegiatan berhasil terhapus..", "success");
            })

        </script>
    @endif

    @if (session()->get('status') == 'sukses')
        <script>
            $(document).ready(function() {
                swal("Sukses!", "Sub Sub Kegiatan berhasil disimpan..", "success");
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
                        data: 'no_rek_sub',
                        name: 'no_rek_sub'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'level_sub',
                        name: 'level_sub'
                    },
                    {
                        data: 'child_of',
                        name: 'child_of'
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
                $('.modal-title').html('Edit Sub Sub Kegiatan')
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
                        $('input[name = name]').val(data.name)
                        $('input[name = no_rek_sub]').val(data.no_rek_sub)
                        $('input[name = child_of]').val(data.child_of)
                        $('input[name = level_sub]').val(data.level_sub)
                        $('input[name = _method]').val('PUT')

                    }
                });

            })

            $('#btn-add').click(function() {
                $('.modal-title').html('Tambah Sub Sub Kegiatan')
                $('.modal-footer button[type=submit]').html('Tambah')
                $('.modal form').attr('action', "{{ route('childsubkegiatan.store') }}")
                $('.modal form').attr('method', 'post')

                $('input[name = name]').val('')
                $('input[name = no_rek_sub]').val('')
                $('input[name = child_of]').val('')
                $('input[name = level_sub]').val('')
                $('input[name = _method]').val('')

            })

            // Hapus data via ajax
            $(document).on('click', '.btn-delete', function(e) {
                var id = $(this).data('id');
                var url = $(this).data('act');

                swal({
                        title: "Yakin hapus Sub Sub Kegiatan ?",
                        text: 'Seluruh sub dalam Sub sub kegiatan ini akan ikut terhapus!',
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
            })


        });

    </script>
@endsection
