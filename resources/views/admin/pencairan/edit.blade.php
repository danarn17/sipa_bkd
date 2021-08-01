@extends('layouts.app')
@section('title')
    Edit Data Pencairan
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Edit Data Pencairan</h3>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Data Pencairan</h2>
            <p class="section-lead">***</p>
            <div class="card">
                <div class="card-body">
                    <form class="m-1" action="{{ route('pencairan.update', [$pencairan->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    <li>{{ $error }}</li>
                                </div>
                            @endforeach
                        @endif
                        @csrf
                        @method('PUT')
                        <h5 id="rekening"></h5>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Rekening</label>
                                    <select class="custom-select" name="no_rek" required>
                                        <option value="">Pilih Rekening</option>
                                        {!! $sel !!}
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tahun</label>
                                    <select class="form-control" name="year" required>
                                        @foreach ($years as $year)
                                            <option value="{{ $year->id }}" @if ($pencairan->year == $year->id) selected @endif>{{ $year->year }}</option>)
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Nominal</label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                                        </div>
                                        <input class="form-control finn" name="nominal" required
                                            value="{{ $pencairan->nominal }}">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Triwulan</label>
                                    <select class="form-control" name="triwulan" required>
                                        <option value="1" @if ($pencairan->triwulan == '1') selected @endif>Pertama</option>
                                        <option value="2" @if ($pencairan->triwulan == '2') selected @endif>Kedua</option>
                                        <option value="3" @if ($pencairan->triwulan == '3') selected @endif>Ketiga</option>
                                        <option value="4" @if ($pencairan->triwulan == '4') selected @endif>Keempat</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tgl. Kegiatan</label>
                                    <input type="date" class="form-control" name="tgl_kegiatan" id="tgl_kegiatan" required
                                        value="{{ $pencairan->tgl_kegiatan }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea name="ket" id="ket" cols="30" rows="10"
                                        class="form-control">{{ $pencairan->ket }}</textarea>
                                    {{-- <input type="date" class="form-control" name="tgl_kegiatan" id="tgl_kegiatan" required> --}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>Arsip</label>
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" data-preview=".sourcePreview" name="archive"
                                            class="custom-file-input" id="source">
                                        <label class="custom-file-label " for="source">Choose File</label>
                                    </div>
                                    <div class="form-text text-muted">Maksimal ukuran file 2MB</div>
                                    @if (isset($pencairan->archive))
                                        @if (substr($pencairan->archive, -4) == '.pdf')
                                            <img class="d-none img-fluid mb-2 sourcePreviewImg" src="">
                                            <object data="{{ Storage::url($pencairan->archive) }}"
                                                class="img-fluid mb-2 sourcePreviewPdf" type="application/pdf"></object>
                                        @else
                                            <img class="img-fluid mb-2 sourcePreviewImg"
                                                src="{{ Storage::url($pencairan->archive) }}">
                                            <object data="" class="d-none img-fluid mb-2 sourcePreviewPdf"
                                                type="application/pdf"></object>
                                        @endif
                                    @else
                                        <img class="d-none img-fluid mb-2 sourcePreviewImg" src="">
                                        <object data="" class="d-none img-fluid mb-2 sourcePreviewPdf"
                                            type="application/pdf"></object>
                                    @endif

                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Tgl. Pencairan</label>
                                    <input type="date" class="form-control" name="tgl_pencairan" id="tgl_pencairan"
                                        value="{{ $pencairan->tgl_pencairan }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group float-right">
                            <button type="reset" class="btn btn-flat">Reset</button>
                            <button type="submit" name="" class="btn btn-success btn-flat d-">
                                <i class="fas fa-check-circle"> Simpan</i>
                            </button>
                        </div>
                        </object>

                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('scripts')
    <script>
        $(document).ready(() => {
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
            $('input[type="file"]').change(function() {
                const preview = $(this).data('preview');
                const id = $(this).attr('id');
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $(preview + "Pdf").attr('data', event.target.result);
                        $(preview + "Img").attr('src', event.target.result);
                        const ext = file.type;
                        if (ext == "application/pdf") {
                            $(preview + "Pdf").attr('data', event.target.result);
                            $(preview + "Img").addClass('d-none');
                            $(preview + "Pdf").removeClass('d-none');
                            $(preview + "Img").attr('src', '');

                        } else {
                            $(preview + "Img").attr('src', event.target.result);
                            $(preview + "Pdf").addClass('d-none');
                            $(preview + "Img").removeClass('d-none');
                            $(preview + "Pdf").attr('data', '');
                        }
                    }
                    reader.readAsDataURL(file);
                    const label = $(`label[for="${id}"]`);
                    label.html($(this).val()
                        .replace(/C:\\fakepath\\/i, ''))
                }
            });
            // const parentForm = $("#parent");
            // const sub_others = $("#sub_others");
            // $("#level").on('change', function() {
            //     const val = $(this).val();
            //     if (val !== "") {
            //         parentForm.prop('disabled', false);
            //         let __html = "";
            //         for (let i = 1; i < parseInt(val); i++) {
            //             __html += '<div class="col-4">';
            //             __html += '<div class="form-group">';
            //             __html += '<label>Sub ' + i + '</label>';
            //             __html += '<select name="sub_' + i + '" id="sub_' + i + '" data-level="' + i +
            //                 '" class="form-control sub_" required disabled>';
            //             __html += '<option value="">====Pilih Sub Kegiatan=====</option>';
            //             __html += ' </select>';
            //             __html += '</div>';
            //             __html += '</div>';
            //         }
            //         sub_others.html(__html);
            //     } else {
            //         parentForm.prop('disabled', true);
            //     }
            // })
            // parentForm.on('change', function() {
            //     const val = $(this).val();
            //     $.ajax({
            //         url: "{{ route('getFirstLevel') }}",
            //         data: {
            //             _token: "{{ csrf_token() }}",
            //             first: val
            //         },
            //         method: 'POST',
            //         success: function(data) {
            //             console.log(data.data);
            //             let _option = '<option value="">====Pilih Sub Kegiatan=====</option>';
            //             data.data.map((item) => {
            //                 _option += '<option value="' + item.id + '">' + item.name +
            //                     '</option>';
            //             })
            //             $("#sub_1").prop('disabled', false);
            //             $("#sub_1").html(_option);
            //         }
            //     });
            // })

        });
    </script>
@endsection
