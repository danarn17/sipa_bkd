<?php

namespace App\Http\Controllers;

use App\Models\Anggaran;
use App\Models\ChildSubKegiatan;
use App\Models\Pencairan;
use App\Models\SubKegiatan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class PencairanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Pencairan::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('no_rek', function ($row) {
                    // $res = 'no_rek ' . $row->no_rek;
                    $res = ChildSubKegiatan::where('id', $row->no_rek)->first();

                    return $res->name;
                })
                ->addColumn('triwulan', function ($row) {
                    $tahun = Anggaran::where('id', $row->year)->first();
                    $res = '<h5>' . $tahun->year . '</h5>';
                    $res .= 'Triwulan ' . $row->triwulan;
                    return $res;
                })
                ->addColumn('nominal', function ($row) {
                    $res = 'Rp. ' . number_format($row->nominal, 0, '', '.');
                    return $res;
                })
                ->addColumn('tgl_kegiatan', function ($row) {
                    $res = '<h5>' . Carbon::parse($row->tgl_kegiatan)->format(' d/m/Y') . '</h5>';
                    return $res;
                })
                ->addColumn('tgl_pencairan', function ($row) {
                    $res = '<h5>' . Carbon::parse($row->tgl_pencairan)->format(' d/m/Y') . '</h5>';
                    return $res;
                })
                ->addColumn('archive', function ($row) {
                    if (!is_null($row->archive)) {
                        $res = '<a target="_blank" href="' . Storage::url($row->archive) . '" class="btn btn-primary">Download</a>';
                        // $res = ;
                    } else {
                        $res = '<div class="text-danger">Belum Ada Arsip</div>';
                    }
                    return $res;
                })
                ->addColumn('action', function ($row) {
                    // $actionBtn = '<button data-act="' . route('pencairan.update', $row->id) . '" data-det="' . route('pencairan.show', $row->id) . '"  type="button" class="btn-edit btn btn-icon btn-primary" data-toggle="modal" data-target="#form-modal"><i class="fas fa-edit"></i></button> ';
                    $actionBtn = '<a href="' . route('pencairan.edit', $row->id) . '" class="btn-edit btn btn-icon btn-primary"><i class="fas fa-edit"></i></a> ';
                    $actionBtn .= ' <button data-act="' . route('pencairan.destroy', $row->id) . '"  class="btn-delete btn btn-icon btn-danger"><i class="fas fa-times"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['no_rek', 'action', 'triwulan', 'nominal', 'tgl_kegiatan', 'tgl_pencairan', 'archive'])
                ->make(true);
        }
        return view('admin.pencairan.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $reks = ChildSubKegiatan::where('level_sub', 4)->get();
        $sel = "";
        foreach ($reks as $id) {
            $a = "<optgroup label='" . $id->name . "'>";
            $child = ChildSubKegiatan::where(['level_sub' => 5, 'child_of' => $id->id])->get();
            foreach ($child as $ch) {
                $a .= "<option value='" . $ch->id . "'>" . $ch->name . "</option>";
            }
            $a .= '</optgroup>';
            $sel .= $a;
        };
        $years = Anggaran::get();


        // dd($reks->pluck('id', 'name'));
        return view('admin.pencairan.create', compact('sel', 'years'));
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
            'no_rek' => 'required',
            'year' => 'required',
            'nominal' => 'required',
            'triwulan' => 'required',
            'tgl_kegiatan' => 'required',
            'tgl_pencairan' => 'required',
            'archive' => 'mimes:jpeg,bmp,png,gif,svg,pdf|max:1000',
        ]);
        if ($request->hasFile('archive')) {
            $data['archive'] = $request->file('archive')->store('archive', 'public');
        }
        $data['nominal'] = intval(preg_replace('/[($)\s\._\-]+/', '', $request->nominal));

        $pencairan = Pencairan::create($data);
        $pencairan->save();
        $request->session()->flash('status', 'sukses');
        return redirect()->route('pencairan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pencairan  $pencairan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $pencairan = Pencairan::find($id);
        return response()->json(['success' => true, 'data' => $pencairan]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pencairan  $pencairan
     * @return \Illuminate\Http\Response
     */
    public function edit(Pencairan $pencairan)
    {
        // dd($pencairan->no_rek);
        $reks = ChildSubKegiatan::where('level_sub', 4)->get();
        $sel = "";
        foreach ($reks as $id) {
            $a = "<optgroup label='" . $id->name . "'>";
            $child = ChildSubKegiatan::where(['level_sub' => 5, 'child_of' => $id->id])->get();
            foreach ($child as $ch) {
                $selected = "";
                if ($ch->id == $pencairan->no_rek) {
                    $selected = "selected";
                }
                $a .= "<option value='" . $ch->id . "' " . $selected . ">" . $ch->name . "</option>";
            }
            $a .= '</optgroup>';
            $sel .= $a;
        };
        $years = Anggaran::get();


        // dd($reks->pluck('id', 'name'));
        return view('admin.pencairan.edit', compact('pencairan', 'sel', 'years'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Pencairan  $pencairan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $data = $request->all();
        $pencairan = Pencairan::find($id);
        $this->validate($request, [
            'no_rek' => 'required',
            'year' => 'required',
            'nominal' => 'required',
            'triwulan' => 'required',
            'tgl_kegiatan' => 'required',
            'tgl_pencairan' => 'required',
            'archive' => 'mimes:jpeg,bmp,png,gif,svg,pdf|max:1000',
        ]);
        if ($request->hasFile('archive')) {
            $data['archive'] = $request->file('archive')->store('archive', 'public');
            // Storage::disk('public')->delete('archive/' . $item->image);
        }
        $data['nominal'] = intval(preg_replace('/[($)\s\._\-]+/', '', $request->nominal));

        $pencairan->update($data);
        $pencairan->save();
        $request->session()->flash('status', 'sukses');
        return redirect()->route('pencairan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pencairan  $pencairan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        //
        $pencairan = Pencairan::find($id);
        $pencairan->delete();
        $request->session()->flash('status', 'sukses');
        return response()->json(array('success' => true));
    }
    public function download($file)
    {
        dd($file);
        return response()->download($file);
    }
}
