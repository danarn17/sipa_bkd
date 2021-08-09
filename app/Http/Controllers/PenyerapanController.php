<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\ChildSubKegiatan;
use App\Models\Pencairan;
use Illuminate\Http\Request;

class PenyerapanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $years = Anggaran::get();

        $reks = ChildSubKegiatan::where('level_sub', 4)->get();
        $sel = "";
        foreach ($reks as $id) {
            $a = "<optgroup label='" . $id->name . "'>";
            $child = ChildSubKegiatan::where(['level_sub' => 5, 'child_of' => $id->id])->get();
            foreach ($child as $ch) {
                $stat = "";
                if ($request['rekening'] == $ch->id) {
                    $stat = "selected";
                }
                $a .= "<option value='" . $ch->id . "' " . $stat . ">" . $ch->name . "</option>";
            }
            $a .= '</optgroup>';
            $sel .= $a;
        };

        if ($request->ajax()) {
            $data = $request->all();
            $tahun = $data['tahun'];
            $rekening = $data['rekening'];

            $anggaran = Anggaran::where(['year' => $tahun])->first();

            // $reks = ChildSubKegiatan::where('level_sub', 5)->pluck('id');
            // $as = array();
            $total = array();
            $penyerapan = array();
            for ($a = 1; $a <= 4; $a++) {
                // RUMUSNYA ADALAH ANGGARAN REKENING + SISA REKENING TRIWULAN SEBELUMNYA
                $triw = "triwulan_" . $a;
                $pertri = json_decode($anggaran[$triw])->data;
                // $triwulan = "";
                // foreach ($reks as $r) {
                $r = $rekening;
                $pencairan = Pencairan::where(['year' => $anggaran->id, 'triwulan' => $a, 'no_rek' => $r])->get();
                $rek = 0;
                if ($pencairan->count() > 0) {
                    foreach ($pencairan as $p) {
                        $rek += $p->nominal;
                    }
                }

                $sisa_rek = $pertri->{$r} - $rek;
                if ($a == 2) {
                    $sisa_rek = ($total[1] + $pertri->{$r}) - $rek;
                } else if ($a == 3) {
                    $sisa_rek = ($total[2] + $pertri->{$r}) - $rek;
                } else if ($a == 4) {
                    $sisa_rek = ($total[3] + $pertri->{$r}) - $rek;
                }

                // $triwulan[$r] = $sisa_rek;
                // }
                $total[$a] = $sisa_rek;
                $penyerapan[$a] = $rek;
                // $as[$a] = $pertri;
            }
            $data_chart = array(
                // 'a' => $anggaran->triwulan_1,
                'triwulan_1' => array(
                    'data' => array(
                        intval($penyerapan[1]), intval($total[1])
                    ),
                    'label' => array(
                        'Penyerapan', 'Anggaran'
                    ),
                ),
                'triwulan_2' => array(
                    'data' => array(
                        intval($penyerapan[2]), intval($total[2])
                    ),
                    'label' => array(
                        'Penyerapan', 'Anggaran dan Sisa Triwulan 1'
                    ),
                ),
                'triwulan_3' => array(
                    'data' => array(
                        intval($penyerapan[3]), intval($total[3])
                    ),
                    'label' => array(
                        'Penyerapan', 'Anggaran dan Sisa Triwulan 2'
                    ),
                ),
                'triwulan_4' => array(
                    'data' => array(
                        intval($penyerapan[4]), intval($total[4])
                    ),
                    'label' => array(
                        'Penyerapan', 'Anggaran dan Sisa Triwulan 3'
                    ),
                ),
            );
            return response()->json(json_encode($data_chart));
        };
        return view('admin.penyerapan.index', compact('years', 'sel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
