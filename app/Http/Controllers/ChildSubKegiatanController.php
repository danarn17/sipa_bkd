<?php

namespace App\Http\Controllers;

use App\Models\ChildSubKegiatan;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;


class ChildSubKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = ChildSubKegiatan::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button data-act="' . route('childsubkegiatan.update', $row->id) . '" data-det="' . route('childsubkegiatan.show', $row->id) . '"  type="button" class="btn-edit btn btn-icon btn-primary" data-toggle="modal" data-target="#form-modal"><i class="fas fa-edit"></i></button> ';
                    $actionBtn .= ' <button data-act="' . route('childsubkegiatan.destroy', $row->id) . '"  class="btn-delete btn btn-icon btn-danger"><i class="fas fa-times"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $parent = SubKegiatan::get();
        return view('admin.childsubkegiatan.index', compact('parent'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $parent = SubKegiatan::get();
        return view('admin.childsubkegiatan.create', compact('parent'));
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
        // dd($data);

        $this->validate($request, [
            'no_rek_sub' => 'required',
            'name' => 'required',
            'child_of' => 'required',
            'level_sub' => 'required',
        ]);
        $data['name'] = $request->name;
        $data['no_rek_sub'] = trim($request->no_rek_sub);
        $data['child_of'] = $request->child_of;
        $data['level_sub'] = $request->level_sub;

        $childsub = ChildSubKegiatan::create($data);

        $childsub->save();
        $request->session()->flash('status', 'sukses');
        return redirect()->route('rekening.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChildSubKegiatan  $childSubKegiatan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $childsub = ChildSubKegiatan::find($id);
        return response()->json(['success' => true, 'data' => $childsub]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChildSubKegiatan  $childSubKegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit(ChildSubKegiatan $childSubKegiatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChildSubKegiatan  $childSubKegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $data = $request->all();
        $childsub = ChildSubKegiatan::find($id);
        $this->validate($request, [
            'no_rek_sub' => 'required',
            'name' => 'required',
            'child_of' => 'required',
            'level_sub' => 'required',
        ]);
        $data['name'] = $request->name;
        $data['no_rek_sub'] = trim($request->no_rek_sub);
        $data['child_of'] = $request->child_of;
        $data['level_sub'] = $request->level_sub;
        $childsub->update($data);
        $childsub->save();
        $request->session()->flash('status', 'sukses');
        return redirect()->route('childsubkegiatan.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChildSubKegiatan  $childSubKegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $childsub = ChildSubKegiatan::find($id);
        $childsub->delete();
        $request->session()->flash('status', 'hapus sukses');
        return response()->json(array('success' => true));
    }
}
