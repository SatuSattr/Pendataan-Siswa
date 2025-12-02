<?php

namespace App\Http\Controllers;

use App\Models\TahunAjar;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class TahunAjarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tahunAjars = TahunAjar::orderByDesc('created_at')->paginate(10);

        return view('tahun-ajar.index', compact('tahunAjars'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tahun-ajar.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kode_tahun_ajar' => ['required', 'string', 'unique:tahun_ajars,kode_tahun_ajar'],
            'nama_tahun_ajar' => ['required', 'string'],
        ]);

        TahunAjar::create($data);

        return redirect()->route('tahun-ajar.index')->with('success', 'Tahun ajar berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TahunAjar $tahunAjar)
    {
        return view('tahun-ajar.show', compact('tahunAjar'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TahunAjar $tahunAjar)
    {
        return view('tahun-ajar.edit', compact('tahunAjar'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TahunAjar $tahunAjar)
    {
        $data = $request->validate([
            'kode_tahun_ajar' => [
                'required',
                'string',
                Rule::unique('tahun_ajars', 'kode_tahun_ajar')->ignore($tahunAjar->id),
            ],
            'nama_tahun_ajar' => ['required', 'string'],
        ]);

        $tahunAjar->update($data);

        return redirect()->route('tahun-ajar.index')->with('success', 'Tahun ajar berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TahunAjar $tahunAjar)
    {
        $tahunAjar->delete();

        return redirect()->route('tahun-ajar.index')->with('success', 'Tahun ajar berhasil dihapus.');
    }
}
