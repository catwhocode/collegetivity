<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notes;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Notes::all();

        return view('pages.backend.notes.index', [
            'items' => $items
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.backend.notes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'thumbnail' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $resource = $request->file('thumbnail');
            $name = $resource->getClientOriginalName();
            $finalName = date('His')  . $name;
            $request->file('thumbnail')->storeAs('images/', $finalName, 'public');
            Notes::create([
                'judul' => $request->judul,
                'thumbnail' => $finalName,
                'tanggal' => $request->tanggal,
                'author' => $request->author,
                'matkul' => $request->matkul,
                'content' => $request->content,

            ]);
        } else {
            Notes::create([
                'judul' => $request->judul,
                'thumbnail' => 'thumbnail-default.jpg',
                'tanggal' => $request->tanggal,
                'author' => $request->author,
                'matkul' => $request->matkul,
                'content' => $request->content,
            ]);
        }

        return redirect('/dashboard/catatan-pelajaran');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $item = Notes::findOrFail($id);

        return view('pages.backend.notes.detail', [
            'item' => $item
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Notes::findOrFail($id);

        return view('pages.backend.notes.edit', [
            'item' => $item
        ]);
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
    public function destroy($id)
    {
        $item = Notes::findOrFail($id);
        $item->delete();

        return redirect('/dashboard/catatan-pelajaran');
    }
}
