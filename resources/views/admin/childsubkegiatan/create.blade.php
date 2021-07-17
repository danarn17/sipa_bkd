@extends('layouts.app')
@section('title')
    Tambah Child Sub Keg
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Tambah Child Sub Keg</h3>
        </div>
        <div class="section-body">
            <h2 class="section-title">Tambah Child Sub Keg</h2>
            <p class="section-lead">*********************.</p>
            <div class="card">
                <div class="card-body">
                    <form class="m-1" action="{{ route('childsubkegiatan.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    <li>{{ $error }}</li>
                                </div>
                            @endforeach
                        @endif
                        <h5 id="rekening"></h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Uraian</label>
                                    <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Sub..">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>No. Rekening</label>
                                    <input type="text" name="no_rek_sub" class="form-control"
                                        placeholder="Masukkan No Rekening..">

                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Level Sub</label>
                                    <select name="level_sub" id="level" class="form-control" required>
                                        <option value="">====PILIH LEVEL=====</option>
                                        @for ($i = 1; $i < 6; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Sub Kegiatan</label>
                                    <select name="child_of" id="parent" class="form-control" required disabled>
                                        <option value="">====Pilih Sub Kegiatan=====</option>
                                        @foreach ($parent as $p)
                                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 row" id="sub_others">



                            </div>
                        </div>

                        <div class="form-group float-right">
                            <button type="reset" class="btn btn-flat">Reset</button>
                            <button type="submit" name="" class="btn btn-success btn-flat">
                                <i class="fas fa-check-circle"> Simpan</i>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(() => {
            const parentForm = $("#parent");
            const sub_others = $("#sub_others");
            $("#level").on('change', function() {
                const val = $(this).val();
                if (val !== "") {
                    parentForm.prop('disabled', false);
                    let __html = "";
                    for (let i = 1; i < parseInt(val); i++) {
                        __html += '<div class="col-4">';
                        __html += '<div class="form-group">';
                        __html += '<label>Sub ' + i + '</label>';
                        __html += '<select name="sub_' + i + '" id="sub_' + i + '" data-level="' + i +
                            '" class="form-control sub_" required disabled>';
                        __html += '<option value="">====Pilih Sub Kegiatan=====</option>';
                        __html += ' </select>';
                        __html += '</div>';
                        __html += '</div>';
                    }
                    sub_others.html(__html);
                } else {
                    parentForm.prop('disabled', true);
                }
            })
            parentForm.on('change', function() {
                const val = $(this).val();
                $.ajax({
                    url: "{{ route('getFirstLevel') }}",
                    data: {
                        _token: "{{ csrf_token() }}",
                        first: val
                    },
                    method: 'POST',
                    success: function(data) {
                        console.log(data.data);
                        let _option = '<option value="">====Pilih Sub Kegiatan=====</option>';
                        data.data.map((item) => {
                            _option += '<option value="' + item.id + '">' + item.name +
                                '</option>';
                        })
                        $("#sub_1").prop('disabled', false);
                        $("#sub_1").html(_option);
                    }
                });
            })

        });

    </script>
@endsection
