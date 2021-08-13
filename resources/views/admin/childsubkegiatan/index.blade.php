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
                            <table id="dataTable" class="table table-striped dt-responsive nowrap">
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
    </section>

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
