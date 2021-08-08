<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\ChildSubKegiatan;
use App\Models\Pencairan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class AnggaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        if ($request->ajax()) {
            $data = Anggaran::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = "<div style='white-space:nowrap;'>";
                    $actionBtn .= '<a href="' . route('anggaran.edit', [$row->id]) . '"  class="btn-edit btn btn-icon btn-primary"><i class="fas fa-edit"></i></a> ';
                    $actionBtn .= ' <button data-act="' . route('anggaran.destroy', $row->id) . '"  class="btn-delete btn btn-icon btn-danger"><i class="fas fa-times"></i></button>';
                    $actionBtn .= "</div>";
                    return $actionBtn;
                })
                ->editColumn('triwulan_1', function ($row) {
                    $val = json_decode($row->triwulan_1);
                    return "<div style='white-space:nowrap;'> Rp. " . number_format($val->total, 0, '', '.') . "</div>";
                })
                ->editColumn('triwulan_2', function ($row) {
                    $val = json_decode($row->triwulan_2);
                    return "<div style='white-space:nowrap;'> Rp. " . number_format($val->total, 0, '', '.') . "</div>";
                })
                ->editColumn('triwulan_3', function ($row) {
                    $val = json_decode($row->triwulan_3);
                    return "<div style='white-space:nowrap;'> Rp. " . number_format($val->total, 0, '', '.') . "</div>";
                })
                ->editColumn('triwulan_4', function ($row) {
                    $val = json_decode($row->triwulan_4);
                    return "<div style='white-space:nowrap;'> Rp. " . number_format($val->total, 0, '', '.') . "</div>";
                })
                ->rawColumns(['action', 'triwulan_1', 'triwulan_2', 'triwulan_3', 'triwulan_4'])
                ->make(true);
        }
        return view('admin.anggaran.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reks = ChildSubKegiatan::where('level_sub', 5)->get();
        return view('admin.anggaran.create', compact('reks'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // dump($data['triwulan'][1][36]);
        $this->validate($request, [
            'year' => 'required',
            'triwulan' => 'required',
        ]);
        $data['year'] = intval(preg_replace('/[($)\s\._\-]+/', '', $request->year));

        $tri_1 = collect($data['triwulan'][1])->map(function ($item, $key) {
            $item = intval(preg_replace('/[($)\s\._\-]+/', '', $item));
            return $item;
        });
        $tri_2 = collect($data['triwulan'][2])->map(function ($item, $key) {
            $item = intval(preg_replace('/[($)\s\._\-]+/', '', $item));
            return $item;
        });
        $tri_3 = collect($data['triwulan'][3])->map(function ($item, $key) {
            $item = intval(preg_replace('/[($)\s\._\-]+/', '', $item));
            return $item;
        });
        $tri_4 = collect($data['triwulan'][4])->map(function ($item, $key) {
            $item = intval(preg_replace('/[($)\s\._\-]+/', '', $item));
            return $item;
        });

        // dd(json_encode($tri_1));
        $data['triwulan_1'] = array(
            'data' => $tri_1,
            'total' => $data['total'][1]
        );
        $data['triwulan_2'] = array(
            'data' => $tri_2,
            'total' => $data['total'][2]
        );
        $data['triwulan_3'] = array(
            'data' => $tri_3,
            'total' => $data['total'][3]
        );
        $data['triwulan_4'] = array(
            'data' => $tri_4,
            'total' => $data['total'][4]
        );
        $data['triwulan_1'] = json_encode($data['triwulan_1']);
        $data['triwulan_2'] = json_encode($data['triwulan_2']);
        $data['triwulan_3'] = json_encode($data['triwulan_3']);
        $data['triwulan_4'] = json_encode($data['triwulan_4']);

        $anggaran = Anggaran::create($data);

        $anggaran->save();
        $request->session()->flash('status', 'sukses');
        return redirect()->route('anggaran.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Anggaran  $anggaran
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $anggaran = Anggaran::find($id);

        $anggaran['sisa_t1'] = array(
            'data' => array(),
            'total' => 0
        );
        $anggaran['sisa_t2'] = array(
            'data' => array(),
            'total' => 0
        );
        $anggaran['sisa_t3'] = array(
            'data' => array(),
            'total' => 0
        );
        $anggaran['sisa_t4'] = array(
            'data' => array(),
            'total' => 0
        );

        // $anggaran
        $reks = ChildSubKegiatan::where('level_sub', 5)->pluck('id');
        $as = array();
        $penyerapan = array();
        for ($a = 1; $a <= 4; $a++) {
            // RUMUSNYA ADALAH ANGGARAN REKENING + SISA REKENING TRIWULAN SEBELUMNYA
            $triw = "triwulan_" . $a;
            $pertri = json_decode($anggaran[$triw])->data;
            $triwulan = array();
            foreach ($reks as $r) {

                $pencairan = Pencairan::where(['year' => $anggaran->id, 'triwulan' => $a, 'no_rek' => $r])->get();
                $rek = 0;
                if ($pencairan->count() > 0) {
                    foreach ($pencairan as $p) {
                        $rek += $p->nominal;
                    }
                }
                $sisa_rek = $pertri->{$r} - $rek;
                // if ($a > 1) {
                //     $b = $a - 1;
                //     $sisa_rek = ($penyerapan[$b][$r] + $pertri->{$r}) - $rek;
                // }
                if ($a == 2) {
                    $sisa_rek = ($penyerapan[1][$r] + $pertri->{$r}) - $rek;
                } else if ($a == 3) {
                    $sisa_rek = ($penyerapan[1][$r] + $penyerapan[2][$r] + $pertri->{$r}) - $rek;
                } else if ($a == 4) {
                    $sisa_rek = ($penyerapan[1][$r] + $penyerapan[2][$r] + $penyerapan[3][$r] + $pertri->{$r}) - $rek;
                }

                $triwulan[$r] = $sisa_rek;
            }
            $penyerapan[$a] = $triwulan;
            $as[$a] = $pertri;
        }








        $penyerapan_1 = 0;
        $penyerapan_2 = 0;
        $penyerapan_3 = 0;
        $penyerapan_4 = 0;
        foreach ($pencairan as $key => $value) {
            if (intval($value->triwulan) == 1) {
                $penyerapan_1 += intval($value->nominal);
            } elseif (intval($value->triwulan) == 2) {
                $penyerapan_2 += intval($value->nominal);
            } elseif (intval($value->triwulan) == 3) {
                $penyerapan_3 += intval($value->nominal);
            } elseif (intval($value->triwulan) == 4) {
                $penyerapan_4 += intval($value->nominal);
            }
        }
        $sisa_1 = intval(json_decode($anggaran->triwulan_1)->total) - $penyerapan_1;
        $sisa_2 = intval(json_decode($anggaran->triwulan_2)->total) - $penyerapan_2;
        $sisa_3 = intval(json_decode($anggaran->triwulan_3)->total) - $penyerapan_3;

        $anggaran['sisa_t1'] = intval(json_decode($anggaran->triwulan_1)->total) - $penyerapan_1;
        $anggaran['sisa_t2'] = intval(json_decode($anggaran->triwulan_2)->total) + $anggaran['sisa_t1'] - $penyerapan_2;
        $anggaran['sisa_t3'] = intval(json_decode($anggaran->triwulan_3)->total) +  $anggaran['sisa_t2'] - $penyerapan_3;
        $anggaran['sisa_t4'] = intval(json_decode($anggaran->triwulan_4)->total) +  $anggaran['sisa_t3'] - $penyerapan_4;

        $anggaran['sis_t1'] = $penyerapan[1];
        $anggaran['sis_t2'] = $penyerapan[2];
        $anggaran['sis_t3'] = $penyerapan[3];
        $anggaran['sis_t4'] = $penyerapan[4];

        return response()->json(['success' => true, 'data' => $anggaran]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Anggaran  $anggaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Anggaran $anggaran)
    {
        $reks = ChildSubKegiatan::where('level_sub', 5)->get();
        return view('admin.anggaran.edit', compact('reks', 'anggaran'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Anggaran  $anggaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();
        $anggaran = Anggaran::find($id);
        $this->validate($request, [
            'year' => 'required',
            'triwulan' => 'required',
        ]);
        $request['year'] = intval(preg_replace('/[($)\s\._\-]+/', '', $request->year));

        $tri_1 = collect($data['triwulan'][1])->map(function ($item, $key) {
            $item = intval(preg_replace('/[($)\s\._\-]+/', '', $item));
            return $item;
        });
        $tri_2 = collect($data['triwulan'][2])->map(function ($item, $key) {
            $item = intval(preg_replace('/[($)\s\._\-]+/', '', $item));
            return $item;
        });
        $tri_3 = collect($data['triwulan'][3])->map(function ($item, $key) {
            $item = intval(preg_replace('/[($)\s\._\-]+/', '', $item));
            return $item;
        });
        $tri_4 = collect($data['triwulan'][4])->map(function ($item, $key) {
            $item = intval(preg_replace('/[($)\s\._\-]+/', '', $item));
            return $item;
        });

        $data['triwulan_1'] = array(
            'data' => $tri_1,
            'total' => $data['total'][1]
        );
        $data['triwulan_2'] = array(
            'data' => $tri_2,
            'total' => $data['total'][2]
        );
        $data['triwulan_3'] = array(
            'data' => $tri_3,
            'total' => $data['total'][3]
        );
        $data['triwulan_4'] = array(
            'data' => $tri_4,
            'total' => $data['total'][4]
        );
        $data['triwulan_1'] = json_encode($data['triwulan_1']);
        $data['triwulan_2'] = json_encode($data['triwulan_2']);
        $data['triwulan_3'] = json_encode($data['triwulan_3']);
        $data['triwulan_4'] = json_encode($data['triwulan_4']);

        $anggaran->update($data);

        $anggaran->save();
        $request->session()->flash('status', 'sukses');
        return redirect()->route('anggaran.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Anggaran  $anggaran
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //
        $anggaran = Anggaran::find($id);

        $anggaran->delete();
        $request->session()->flash('status', 'hapus sukses');
        return response()->json(array('success' => true));
    }
    public function cek_anggaran(Request $request)
    {
    }
}
