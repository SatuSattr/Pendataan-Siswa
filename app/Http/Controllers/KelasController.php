<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Jurusan;
use App\Models\TahunAjar;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = Kelas::with(['jurusan', 'tahunAjar'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('kelas.index', compact('kelas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $tahunAjars = TahunAjar::orderByDesc('kode_tahun_ajar')->get();

        return view('kelas.create', compact('jurusans', 'tahunAjars'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_kelas' => ['required', 'string'],
            'level_kelas' => ['required', 'string', Rule::in(['X', 'XI', 'XII'])],
            'jurusan_id' => ['required', 'exists:jurusans,id'],
            'tahun_ajar_id' => ['required', 'exists:tahun_ajars,id'],
        ]);

        Kelas::create($data);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelas $kelas)
    {
        $kelas->load([
            'jurusan',
            'tahunAjar',
            'kelasDetails' => function ($query) {
                $query->where('status', 'aktif')->with('siswa');
            },
        ]);

        return view('kelas.show', compact('kelas'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelas $kelas)
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $tahunAjars = TahunAjar::orderByDesc('kode_tahun_ajar')->get();

        return view('kelas.edit', compact('kelas', 'jurusans', 'tahunAjars'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelas $kelas)
    {
        $data = $request->validate([
            'nama_kelas' => ['required', 'string'],
            'level_kelas' => ['required', 'string', Rule::in(['X', 'XI', 'XII'])],
            'jurusan_id' => ['required', 'exists:jurusans,id'],
            'tahun_ajar_id' => ['required', 'exists:tahun_ajars,id'],
        ]);

        $kelas->update($data);

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelas $kelas)
    {
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus.');
    }
}
