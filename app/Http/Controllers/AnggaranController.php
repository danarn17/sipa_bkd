<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
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
                    $actionBtn = '<button data-act="' . route('anggaran.update', [$row->id]) . '" data-det="' . route('anggaran.show', $row->id) . '"  type="button" class="btn-edit btn btn-icon btn-primary" data-toggle="modal" data-target="#form-modal"><i class="fas fa-edit"></i></button> ';
                    $actionBtn .= ' <button data-act="' . route('anggaran.destroy', $row->id) . '"  class="btn-delete btn btn-icon btn-danger"><i class="fas fa-times"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
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
        $this->validate($request, [
            'year' => 'required',
            'triwulan_1' => 'required',
            'triwulan_2' => 'required',
            'triwulan_3' => 'required',
            'triwulan_4' => 'required',
        ]);
        $request['year'] = intval(preg_replace('/[($)\s\._\-]+/', '', $request->year));
        $request['triwulan_1'] = intval(preg_replace('/[($)\s\._\-]+/', '', $request->triwulan_1));
        $request['triwulan_2'] = intval(preg_replace('/[($)\s\._\-]+/', '', $request->triwulan_2));
        $request['triwulan_3'] = intval(preg_replace('/[($)\s\._\-]+/', '', $request->triwulan_3));
        $request['triwulan_4'] = intval(preg_replace('/[($)\s\._\-]+/', '', $request->triwulan_4));

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
        //
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
            'triwulan_1' => 'required',
            'triwulan_2' => 'required',
            'triwulan_3' => 'required',
            'triwulan_4' => 'required',
        ]);
        $request['year'] = intval(preg_replace('/[($)\s\._\-]+/', '', $request->year));
        $request['triwulan_1'] = intval(preg_replace('/[($)\s\._\-]+/', '', $request->triwulan_1));
        $request['triwulan_2'] = intval(preg_replace('/[($)\s\._\-]+/', '', $request->triwulan_2));
        $request['triwulan_3'] = intval(preg_replace('/[($)\s\._\-]+/', '', $request->triwulan_3));
        $request['triwulan_4'] = intval(preg_replace('/[($)\s\._\-]+/', '', $request->triwulan_4));
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
}
