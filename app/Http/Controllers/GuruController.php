<?php

namespace App\Http\Controllers;

use App\Models\guru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get guru
        $guru = guru::latest()->paginate(5);

        //render view with guru
        return view('guru.index', compact('guru'));
    }

    /**
     * create
     *
     * @return void
     */
    public function create()
    {
        return view('guru.create');
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

            'nama'     => 'required',
            'no_hp'     => 'required',
            'gambar'     => 'required',


        ]);

        //upload gambar
        $gambar = $request->file('gambar');
        $gambar->storeAs('public/guru', $gambar->hashName());

        //create guru
        guru::create([

            'nama'     => $request->nama,
            'no_hp'     => $request->no_hp,
            'gambar'     => $gambar->hashName(),

        ]);

        //redirect to index
        return redirect()->route('guru.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * edit
     *
     * @param  mixed $guru
     * @return void
     */
    public function edit(guru $guru)
    {
        return view('guru.edit', compact('guru'));
    }

     /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $guru
     * @return void
     */
    public function update(Request $request, guru $guru)
    {
        //validate form
        $this->validate($request, [
            'nama'     => 'required',
            'no_hp'     => 'required',
            'gambar'     => 'required',


        ]);

        //check if gambar is uploaded
        if ($request->hasFile('gambar')) {

            //upload new gambar
            $gambar = $request->file('gambar');
            $gambar->storeAs('public/guru', $gambar->hashName());

            //delete old gambar
            Storage::delete('public/guru/'.$guru->gambar);

            //update guru with new gambar
            $guru->update([

                'nama'     => $request->nama,
                'no_hp'     => $request->no_hp,
                'gambar'     => $gambar->hashName(),

            ]);

        } else {

            //update guru without foto
            $guru->update([

            'nama'     => $request->nama,
            'no_hp'     => $request->no_hp,
            ]);
        }

        //redirect to index
        return redirect()->route('guru.index')->with(['success' => 'Data Berhasil Diubah!']);
    }
    public function destroy(guru $guru)
    {
        //delete image
        Storage::delete('public/guru/'. $guru->gambar);

        //delete guru
        $guru->delete();

        //redirect to index
        return redirect()->route('guru.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
