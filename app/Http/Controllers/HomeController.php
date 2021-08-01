<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\Pencairan;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $years = Anggaran::get();
        if ($request->ajax()) {
            $data = $request->all();
            $tahun = $data['tahun'];

            $anggaran = Anggaran::where('year', $tahun)->first();
            // $triwulan_1 = $anggaran->triwulan_1;
            $pencairan = Pencairan::where(['year' => $anggaran->id])->get();
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
                    $penyerapan_2 += intval($value->nominal);
                } elseif (intval($value->triwulan) == 4) {
                    $penyerapan_2 += intval($value->nominal);
                }
            }
            $sisa_1 = intval($anggaran->triwulan_1) - $penyerapan_1;
            $sisa_2 = intval($anggaran->triwulan_2) - $penyerapan_2;
            $sisa_3 = intval($anggaran->triwulan_3) - $penyerapan_3;

            $total_anggaran_t1 = intval($anggaran->triwulan_1);
            $total_anggaran_t2 = intval($anggaran->triwulan_2) + $sisa_1;
            $total_anggaran_t3 = intval($anggaran->triwulan_3) + $sisa_2;
            $total_anggaran_t4 = intval($anggaran->triwulan_4) + $sisa_3;

            $data_chart = array(
                // 'a' => $anggaran->triwulan_1,
                'triwulan_1' => array(
                    'data' => array(
                        intval($penyerapan_1), intval($total_anggaran_t1)
                    ),
                    'label' => array(
                        'Penyerapan', 'Anggaran'
                    ),
                ),
                'triwulan_2' => array(
                    'data' => array(
                        intval($penyerapan_2), intval($total_anggaran_t2)
                    ),
                    'label' => array(
                        'Penyerapan', 'Anggaran dan Sisa Triwulan 1'
                    ),
                ),
                'triwulan_3' => array(
                    'data' => array(
                        intval($penyerapan_3), intval($total_anggaran_t3)
                    ),
                    'label' => array(
                        'Penyerapan', 'Anggaran dan Sisa Triwulan 2'
                    ),
                ),
                'triwulan_4' => array(
                    'data' => array(
                        intval($penyerapan_4), intval($total_anggaran_t4)
                    ),
                    'label' => array(
                        'Penyerapan', 'Anggaran dan Sisa Triwulan 3'
                    ),
                ),
            );
            return response()->json(json_encode($data_chart));
        };
        return view('admin.dashboard', compact('years'));
    }
    // public function dash_webmaster()
    // {
    //     return view('admin.dash_webmaster');
    // }
    // public function dash_admin()
    // {
    //     return view('admin.dash_admin');
    // }
    // public function dash_author()
    // {
    //     return view('admin.dash_author');
    // }
}
