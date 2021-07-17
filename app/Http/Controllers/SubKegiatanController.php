<?php

namespace App\Http\Controllers;

use App\Models\ChildSubKegiatan;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SubKegiatanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = SubKegiatan::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button data-act="' . route('subkeg.update', [$row->id]) . '" data-det="' . route('subkeg.show', $row->id) . '"  type="button" class="btn-edit btn btn-icon btn-primary" data-toggle="modal" data-target="#form-modal"><i class="fas fa-edit"></i></button> ';
                    $actionBtn .= ' <button data-act="' . route('subkeg.destroy', $row->id) . '"  class="btn-delete btn btn-icon btn-danger"><i class="fas fa-times"></i></button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        $a = SubKegiatan::find(1);
        // $a->child;
        return view('admin.subkegiatan.index', compact('a'));
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
        $data = $request->all();
        // dd($data);

        $this->validate($request, [
            'name' => 'required',
            'no_rek' => 'required|unique:sub_kegiatan,no_rek',
        ]);
        $data['name'] = $request->name;
        $data['no_rek'] = trim($request->no_rek);

        $subkeg = SubKegiatan::create($data);

        $subkeg->save();
        $request->session()->flash('status', 'sukses');
        return redirect()->route('subkeg.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubKegiatan  $subKegiatan
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $subkeg = SubKegiatan::find($id);
        return response()->json(['success' => true, 'data' => $subkeg]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubKegiatan  $subKegiatan
     * @return \Illuminate\Http\Response
     */
    public function edit(SubKegiatan $subKegiatan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubKegiatan  $subKegiatan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,  $id)
    {
        $data = $request->all();
        // dd($data);
        $subkeg = SubKegiatan::find($id);
        $this->validate($request, [
            'name' => 'required',
            'no_rek' => 'required|unique:sub_kegiatan,no_rek,' . $id . ',id',
        ]);
        $data['name'] = $request->name;
        $data['no_rek'] = trim($request->no_rek);
        $subkeg->update($data);
        $subkeg->save();
        $request->session()->flash('status', 'sukses');
        return redirect()->route('subkeg.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubKegiatan  $subKegiatan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $subkeg = SubKegiatan::find($id);
        // foreach ($subkeg->child as $c) {
        //     $c->delete();
        // }
        $count = $subkeg->child->count();
        $aaa = array();
        if ($count > 0) {
            foreach ($subkeg->child as $c) {
                $this->getChild($c);
                $c->delete();
            }
        }
        $subkeg->delete();
        $request->session()->flash('status', 'hapus sukses');
        return response()->json(array('success' => true));
    }
    public function getFirstLevel(Request $request)
    {
        $first_id = $request->first;

        $subb = ChildSubKegiatan::where(['level_sub' => 1, 'child_of' => $first_id])->get();
        $res = array(
            'success' => true,
            'data' => $subb
        );
        return response()->json($res);
    }

    // public function getChild
    public function getChild($parent)
    {
        foreach ($parent->child as $c) {
            $bb = $c->child->count();
            if ($bb > 0) {
                foreach ($c->child as $cc) {
                    $cc_count = $cc->child->count();
                    if ($cc_count > 0) {
                        $this->getChild($cc);
                    }
                    $cc->delete();
                }
            }
            $c->delete();
        }
    }
}
