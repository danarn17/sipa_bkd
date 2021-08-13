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
            // $pencairan = Pencairan::where(['year' => $anggaran->id])->get();
            $total = array();
            $penyerapan = array();

            for ($a = 1; $a <= 4; $a++) {
                $triw = "triwulan_" . $a;
                // TOTAL DOANG
                $totalByTri = intval(json_decode($anggaran[$triw])->total);

                $pencairan_byTotal = Pencairan::where(['year' => $anggaran->id, 'triwulan' => $a])->get();
                $penyerapanByTri = 0;
                if ($pencairan_byTotal->count() > 0) {
                    foreach ($pencairan_byTotal as $p) {
                        $penyerapanByTri += $p->nominal;
                    }
                }
                $sisa_rek_total = $totalByTri - $penyerapanByTri;
                if ($a == 2) {
                    $sisa_rek_total = ($total[1] + $totalByTri) - $penyerapanByTri;
                } else if ($a == 3) {
                    $sisa_rek_total = ($total[2] + $totalByTri) - $penyerapanByTri;
                } else if ($a == 4) {
                    $sisa_rek_total = ($total[3] + $totalByTri) - $penyerapanByTri;
                }
                $total[$a] = $sisa_rek_total;
                $penyerapan[$a] = $penyerapanByTri;
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
