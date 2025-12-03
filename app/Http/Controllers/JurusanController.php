<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class JurusanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jurusans = Jurusan::withCount('kelas')
            ->orderBy('kode_jurusan')
            ->paginate(10);

        return view('jurusan.index', compact('jurusans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jurusan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_jurusan' => ['required', 'string', 'unique:jurusans,kode_jurusan'],
            'nama_jurusan' => ['required', 'string'],
        ]);

        Jurusan::create($data);

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Jurusan $jurusan)
    {
        return view('jurusan.show', compact('jurusan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jurusan $jurusan)
    {
        return view('jurusan.edit', compact('jurusan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jurusan $jurusan)
    {
        $data = $request->validate([
            'kode_jurusan' => [
                'required',
                'string',
                Rule::unique('jurusans', 'kode_jurusan')->ignore($jurusan->id),
            ],
            'nama_jurusan' => ['required', 'string'],
        ]);

        $jurusan->update($data);

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jurusan $jurusan)
    {
        $jurusan->delete();

        return redirect()->route('jurusan.index')->with('success', 'Jurusan berhasil dihapus.');
    }
}
