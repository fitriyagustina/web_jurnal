<?php

namespace App\Http\Controllers;

use App\Models\guru;
use App\Models\mapel;
use App\Models\pengajar;
use Illuminate\Http\Request;
use Illumiate\Support\Facades\Storage;

class PengajarController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get pengajar
        $pengajar = pengajar::all();

        //render view with pengajar
        return view('pengajar.index', compact('pengajar'));
    }


    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        $data = mapel::all();
        $item = guru::all();
        return view('pengajar.create', compact('data', 'item'));
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [

        'mapel_id' => 'required',
        'guru_id' => 'required',
        'kelas' =>'required',
        'jam_pelajaran' => 'required',


        ]);

        //create pengajar
        pengajar::create([
            'mapel_id'     => $request->mapel_id,
            'guru_id'     => $request->guru_id,
            'kelas'     => $request->kelas,
            'jam_pelajaran'     => $request->jam_pelajaran,

        ]);
        //redirect to index
        return redirect()->route('pengajar.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * edit
     *
     * @param  mixed $pengajar
     * @return void
     */
    public function edit(pengajar $pengajar)
    {
        $data = mapel::all();
        $item = guru::all();
        return view('pengajar.edit', compact( 'data','item', 'pengajar'));
    }

    public function destroy(pengajar $pengajar)
    {
        $pengajar->delete();

        return redirect()->route('pengajar.index')->with(['success' => 'Data Berhasil Didelete!']);
    }
    public function update(Request $request, pengajar $pengajar)
    {
        //validate form
        $this->validate($request, [
            'mapel_id' => 'required',
            'guru_id' => 'required',
            'kelas' =>'required',
            'jam_pelajaran' => 'required',

        ]);

            //update post without image
            $pengajar->update([
                'mapel_id'     => $request->mapel_id,
                'guru_id'     => $request->guru_id,
                'kelas'     => $request->kelas,
                'jam_pelajaran'     => $request->jam_pelajaran,
            ]);


       //redirect to index
       return redirect()->route('pengajar.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

}
