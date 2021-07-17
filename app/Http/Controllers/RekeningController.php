<?php

namespace App\Http\Controllers;

use App\Models\ChildSubKegiatan;
use App\Models\SubKegiatan;
use Illuminate\Http\Request;

class RekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parentCategories = SubKegiatan::all();
        return view('admin.rekening.index', compact('parentCategories'));
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
    public function destroy($id, Request $request)
    {
        // kurang child nya
        $childsub = ChildSubKegiatan::find($id);
        $count = $childsub->child->count();

        if ($count > 0) {
            foreach ($childsub->child as $c) {
                $bb = $this->getChild($c);
                $c->delete();
            }
        }
        $childsub->delete();
        $request->session()->flash('status', 'hapus sukses');
        return response()->json(array('success' => true));
    }
    public function getChild($parent)
    {
        foreach ($parent->child as $c) {
            $bb = $c->child->count();
            if ($bb > 0) {
                foreach ($c->child as $cc) {
                    $cc_count = $cc->child->count();
                    if ($cc_count > 0) {
                        $this->getChild($cc);
                        $cc->delete();
                        return $cc;
                    }
                }
            }
        }
    }
}
