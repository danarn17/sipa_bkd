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
                                    <label>Tahun <b class="text-danger">*</b> </label>
                                    <select class="form-control cek_avail" name="year" id="year" required>
                                        @foreach ($years as $year)
                                            <option value="{{ $year->id }}" @if ($pencairan->year == $year->id) selected @endif>{{ $year->year }}</option>)
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Triwulan <b class="text-danger">*</b></label>
                                    <select class="form-control cek_avail" name="triwulan" id="triwulan" required>
                                        <option value="1" @if ($pencairan->triwulan == '1') selected @endif>Pertama</option>
                                        <option value="2" @if ($pencairan->triwulan == '2') selected @endif>Kedua</option>
                                        <option value="3" @if ($pencairan->triwulan == '3') selected @endif>Ketiga</option>
                                        <option value="4" @if ($pencairan->triwulan == '4') selected @endif>Keempat</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 border-bottom">
                                <div class="form-group">
                                    <label>Rekening <b class="text-danger">*</b></label>
                                    <select class="custom-select cek_avail" name="no_rek" id="no_rek" required>
                                        <option value="">Pilih Rekening</option>
                                        {!! $sel !!}
                                    </select>
                                </div>
                            </div>

                            <div class="col-sm-6 border-bottom">
                                <div class="form-group">
                                    <label>Anggaran Tersedia</label>
                                    <input type="hidden" name="avail_ang" value=0>
                                    <h3 class="text-primary" id="avail_ang">Rp. 0</h3>
                                </div>
                            </div>
                            <div class="col-sm-6 mt-1">
                                <div class="form-group">
                                    <label>Nominal <b class="text-danger">*</b></label>
                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Rp.</span>
                                        </div>
                                        <input class="form-control form-avail finn" name="nominal"
                                            value="{{ $pencairan->nominal }}" required>
                                    </div>
                                </div>
                            </div>


                            <div class="col-sm-6 mt-1">
                                <div class="form-group">
                                    <label>Tgl. Kegiatan <b class="text-danger">*</b></label>
                                    <input type="date" class="form-control form-avail" name="tgl_kegiatan" id="tgl_kegiatan"
                                        value="{{ $pencairan->tgl_kegiatan }}" required>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Keterangan <b class="text-danger">*</b></label>
                                    <textarea name="ket" id="ket" cols="30" rows="10"
                                        class="form-control form-avail">{{ $pencairan->ket }}</textarea>
                                    {{-- <input type="date" class="form-control" name="tgl_kegiatan" id="tgl_kegiatan" required> --}}
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label>Arsip</label>
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" data-preview=".sourcePreview" name="archive"
                                            class="custom-file-input form-avail" id="source">
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
                                    <label>Tgl. Pencairan <b class="text-danger">*</b></label>
                                    <input type="date" class="form-control form-avail" name="tgl_pencairan"
                                        value="{{ $pencairan->tgl_pencairan }}" id="tgl_pencairan" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-group float-right">
                            {{-- <button type="reset" class="btn btn-flat">Reset</button> --}}
                            <button type="submit" id="btn-submit" name="" class="btn btn-success form-avail btn-flat d-">
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
        $(".form-avail").prop("disabled", true);
        $(document).ready(() => {
            function toLocale(ini) {

                var $this = ini;
                // Get the value.

                var input = $this.val();
                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt(input, 10) : 0;
                $this.val(function() {
                    return (input === 0) ? 0 : input.toLocaleString("id-ID");
                });
            }
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
                toLocale($this);
            });

            toLocale($("input[name='nominal']"));

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
            $(".cek_avail").change(function() {
                cek_avail()
            })
            $("input[name='nominal']").on('keyup', function() {
                let value = (this).value;
                var input = value.replace(/[\D\s\._\-]+/g, "");
                const after = $("input[name='avail_ang']").val() - input;
                if (after < 0) {
                    $("#btn-submit").prop("disabled", true);
                    $("input[name='nominal']").addClass("is-invalid")
                    if ($(".invalid-feedback").length == 0) {
                        $("input[name='nominal']").after(
                            '<div class="invalid-feedback">Nominal Melebihi Anggaran</div>');
                    }
                } else {
                    $("#btn-submit").prop("disabled", false);
                    $("input[name='nominal']").removeClass("is-invalid")
                    $(".invalid-feedback").remove();
                }
            })

            function cek_avail() {
                let tahun = $("#year").val();
                let triwulan = $("#triwulan").val();
                let no_rek = $("#no_rek").val();

                $.ajax({
                    url: `/admin/anggaran/${tahun}`,
                    method: 'GET',
                    datatype: 'JSON',
                    success: function(data) {
                        if (data.success) {
                            if (data.data) {
                                let val = data.data;
                                let tri = "sis_t" + triwulan;
                                // let val_parsed = JSON.parse(val[tri]);
                                if (no_rek) {
                                    let available = val[tri][no_rek];
                                    $("#avail_ang").html("Rp. " + available.toLocaleString(
                                        "id-ID"));
                                    $("input[name='avail_ang']").val(available);
                                    $(".form-avail").prop("disabled", false);
                                } else {
                                    $("#avail_ang").html("Rp. 0");
                                    $("input[name='avail_ang']").val(0);
                                    $(".form-avail").prop("disabled", true);
                                }

                            }
                        }

                    }
                });
            }
            cek_avail()



        });
    </script>
@endsection
