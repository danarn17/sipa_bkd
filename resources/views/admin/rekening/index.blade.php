@extends('layouts.app')
@section('title')
    Rekening
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Rekening</h3>
        </div>
        <div class="section-body ">
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
                        <div class="card-body">
                            <h1 class="title">Rekening</h1>
                            <ul class="wtree">
                                @foreach ($parentCategories as $category)
                                    <li>
                                        <span>
                                            <div class="row">
                                                <div class="col-8">
                                                    {{ $category->name }} <b>({{ $category->no_rek }})</b>
                                                </div>
                                                <div class="col-4">
                                                    <a href="#" class="addChild" data-toggle="modal" data-level=0
                                                        data-parent={{ $category->id }}
                                                        data-rek="{{ $category->no_rek }}" data-target="#tambahChild">+
                                                        Tambah Sub Rekening</a>
                                                </div>
                                            </div>
                                        </span>
                                        @if (count($category->child))
                                            <ul>
                                                @include('admin.rekening.subCat',['subcategories' =>
                                                $category->child,'no_parent'=>$category->no_rek])
                                            </ul>
                                        @else
                                        @endif
                                    </li>
                                @endforeach

                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="tambahChild" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form action="{{ route('childsubkegiatan.store') }}" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Item</h5>
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
                            <div class="input-group mb-2">
                                <div class="input-group-prepend">
                                    <div class="input-group-text" id="no_rek_parent">@</div>
                                </div>
                                <input type="text" name="no_rek_sub" class="form-control"
                                    placeholder="Masukkan No Rekening..">

                            </div>
                        </div>
                        <div class="form-group">
                            <label>Level</label>
                            <input type="text" name="level_sub" id="level_sub" class="form-control" readonly>
                        </div>
                        <input type="hidden" name="_method" value="">
                        <input type="hidden" name="child_of" value="">
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
                swal("Sukses!", "Rekening berhasil terhapus..", "success");
            })
        </script>

    @endif
    @if (session()->get('status') == 'sukses')
        <script>
            $(document).ready(function() {
                swal("Sukses!", "Rekening berhasil disimpan..", "success");
            })
        </script>
    @endif
    <script>
        $(document).ready(function() {

            $('.list-group-item').on('click', function() {
                $('.fas', this)
                    .toggleClass('fa-chevron-right')
                    .toggleClass('fa-chevron-down');
            });
            const modal = $("#tambahChild")

            $(".addChild").on('click', function() {
                modal.find('.modal-footer button[type=submit]').html('Tambah')
                var url = "{{ route('childsubkegiatan.store') }}";
                modal.find('.modal form').attr('action', url)
                modal.find('#no_rek_parent').html($(this).data('rek'))
                modal.find('input[name = child_of]').val($(this).data('parent'))
                modal.find('input[name = level_sub]').val(parseInt($(this).data('level')) + 1)
            })

            $(".minChild").on('click', function(e) {
                var id = $(this).data('id');
                var level = $(this).data('level');
                var title_t = "Yakin hapus kategori ini ?";
                var text_t = "Seluruh rekening dibawah kategori ini akan ikut terhapus!";
                if (level == 5) {
                    title_t = "Yakin hapus rekening ini ?";
                    text_t = "Seluruh data dibawah rekening ini akan ikut terhapus!";

                }

                swal({
                        title: title_t,
                        text: text_t,
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
                                url: $(this).data('url'),
                                success: function(data) {
                                    location.reload();
                                    // console.log(data)
                                }
                            });
                        } else {

                        }
                    });
            })

            modal.on('hidden.bs.modal', function() {
                modal.find('.modal-footer button[type=submit]').html('Tambah')
                modal.find('.modal form').attr('action', '')
                modal.find('#no_rek_parent').html("")

                modal.find('input[name = child_of]').val("")
                modal.find('input[name = level_sub]').val("")
            })

        });
    </script>


@endsection
@section('css')
    <style>
        ul {
            margin-left: 20px;
        }

        .wtree li {
            list-style-type: none;
            margin: 10px 0 10px 10px;
            position: relative;
        }

        .wtree li:before {
            content: "";
            position: absolute;
            top: -10px;
            left: -20px;
            border-left: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            width: 20px;
            height: 15px;
        }

        .wtree li:after {
            position: absolute;
            content: "";
            top: 5px;
            left: -20px;
            border-left: 1px solid #ddd;
            border-top: 1px solid #ddd;
            width: 20px;
            height: 100%;
        }

        .wtree li:last-child:after {
            display: none;
        }

        .wtree li span {
            display: block;
            border: 1px solid #ddd;
            padding: 10px;
            color: #888;
            text-decoration: none;
        }

        .wtree li span:hover,
        .wtree li span:focus {
            background: #eee;
            color: #000;
            border: 1px solid #aaa;
        }

        .wtree li span:hover+ul li span,
        .wtree li span:focus+ul li span {
            background: #eee;
            color: #000;
            border: 1px solid #aaa;
        }

        .wtree li span:hover+ul li:after,
        .wtree li span:focus+ul li:after,
        .wtree li span:hover+ul li:before,
        .wtree li span:focus+ul li:before {
            border-color: #aaa;
        }

    </style>

@endsection
