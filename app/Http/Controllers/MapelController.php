<?php

namespace App\Http\Controllers;

use App\Models\mapel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class mapelController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get mapel
        $mapel = mapel::latest()->paginate(5);

        //render view with mapel
        return view('mapel.index', compact('mapel'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('mapel.create');
    }

    /**
     * store
     *
     * @param Request $request
     * @return void
     */

    public function show($id)
    {

    }
    public function store(Request $request)
    {
        //validate form
        $this->validate($request, [

            'nama_mapel'     => 'required',



        ]);



        //create mapel
        mapel::create([

            'nama_mapel'     => $request->nama_mapel,


        ]);

        //redirect to index
        return redirect()->route('mapel.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * edit
     *
     * @param  mixed $mapel
     * @return void
     */
    public function edit(mapel $mapel)
    {
        return view('mapel.edit', compact('mapel'));
    }

     /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $mapel
     * @return void
     */
    public function update(Request $request, mapel $mapel)
    {
        //validate form
        $this->validate($request, [
            'nama_mapel'     => 'required',

        ]);



            //update mapel without foto
            $mapel->update([

                 'nama_mapel'     => $request->nama_mapel,
            ]);


        //redirect to index
        return redirect()->route('mapel.index')->with(['success' => 'Data Berhasil Diubah!']);
    }

    public function destroy(mapel $mapel)
    {
        //delete image
        Storage::delete('public/mapel/'. $mapel->gambar);

        //delete mapel
        $mapel->delete();

        //redirect to index
        return redirect()->route('mapel.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
