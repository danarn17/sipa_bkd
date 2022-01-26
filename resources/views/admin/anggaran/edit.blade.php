@extends('layouts.app')
@section('title')
    Edit Data Anggaran
@endsection
@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Edit Data Anggaran</h3>
        </div>
        <div class="section-body">
            <h2 class="section-title">Edit Data Anggaran</h2>
            <p class="section-lead">***</p>
            <div class="card">
                <div class="card-body">
                    <form class="m-1" action="{{ route('anggaran.update', [$anggaran->id]) }}" method="POST">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    <li>{{ $error }}</li>
                                </div>
                            @endforeach
                        @endif
                        @csrf
                        @method('PUT')

                        {{-- <h5 id="anggaran"></h5> --}}
                        <div class="row">
                            <div class="col-12">
                                <h3 class="text-primary text-center">ANGGARAN</h3>
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>TAHUN</label>
                                            <input type="number" name="year" class="form-control w-50"
                                                placeholder="Masukkan Tahun" min=2020 value="{{ $anggaran->year }}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @for ($i = 1; $i <= 4; $i++)
                                <div class="col-sm-6">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <h3 class="text-primary text-center">TRIWULAN {{ $i }}</h3>
                                            <br>

                                            <ol type="1">
                                                @foreach ($subkeg as $sk)
                                                    <li>
                                                        <h6>{{ $sk->name }}</h6>
                                                        @foreach ($sk->filtered as $r)
                                                            <div class="form-group">
                                                                <label>{{ $r['name'] }}</label>

                                                                @php
                                                                    $val = '';
                                                                @endphp
                                                                @switch($i)
                                                                    @case(1)
                                                                        @php
                                                                            $val = json_decode($anggaran->triwulan_1)->data;
                                                                        @endphp
                                                                    @break
                                                                    @case(2)
                                                                        @php
                                                                            $val = json_decode($anggaran->triwulan_2)->data;
                                                                        @endphp
                                                                    @break
                                                                    @case(3)
                                                                        @php
                                                                            $val = json_decode($anggaran->triwulan_3)->data;
                                                                        @endphp
                                                                    @break
                                                                    @case(4)
                                                                        @php
                                                                            $val = json_decode($anggaran->triwulan_4)->data;
                                                                        @endphp
                                                                    @break
                                                                    @default
                                                                        @php
                                                                            $val = json_decode($anggaran->triwulan_1)->data;
                                                                        @endphp
                                                                @endswitch


                                                                <div class="input-group mb-3">
                                                                    <div class="input-group-prepend">
                                                                        <span class="input-group-text">Rp.</span>
                                                                    </div>


                                                                    <input type="text"
                                                                        class="form-control finn rek-{{ $i }}"
                                                                        data-rek="{{ $i }}"
                                                                        name="triwulan[{{ $i }}][{{ $r['id'] }}]"
                                                                        value="{{ isset($val->{$r['id']}) ? $val->{$r['id']} : 0 }}">

                                                                </div>
                                                                <hr>
                                                            </div>
                                                        @endforeach
                                                    </li>
                                                @endforeach
                                            </ol>




                                            <div class="text-center">
                                                <h5>Total Anggaran</h5>
                                                <input type="hidden" id="total_{{ $i }}"
                                                    name="total[{{ $i }}]" value=0>
                                                <h4 class="text-primary" id="total_ang_{{ $i }}">Rp. 0</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endfor
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
            function getTotal(a) {
                var value = 0;
                $('.rek-' + a).each(function(i, obj) {
                    var val = (this).value;
                    val = val.replace(/[($)\s\._\-]+/g, "");
                    value += parseInt(val);
                });
                $('#total_ang_' + a).html("Rp. " + value.toLocaleString("id-ID"));
                $('#total_' + a).val(value);
            }
            for (var a = 1; a <= 4; a++) {
                getTotal(a);
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
                // Get the value.

                var input = $this.val();
                var input = input.replace(/[\D\s\._\-]+/g, "");
                input = input ? parseInt(input, 10) : 0;
                $this.val(function() {
                    return (input === 0) ? 0 : input.toLocaleString("id-ID");
                });
                getTotal($(this).data('rek'));
            });
        });
    </script>
@endsection
