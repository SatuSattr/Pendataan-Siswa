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
            ->withCount(['kelasDetails as siswa_count' => function ($q) {
                $q->where('status', 'aktif');
            }])
            ->orderByDesc('created_at')
            ->paginate(10);

        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $tahunAjars = TahunAjar::orderByDesc('kode_tahun_ajar')->get();

        return view('kelas.index', compact('kelas', 'jurusans', 'tahunAjars'));
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
                $query->where('status', 'aktif')->with(['siswa.jurusan', 'kelas', 'tahunAjar']);
            },
        ]);

        $kelasList = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        $tahunAjars = TahunAjar::orderByDesc('kode_tahun_ajar')->get();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $kelasJurusanMap = $kelasList->mapWithKeys(function ($k) {
            return [
                $k->id => [
                    'jurusan_id' => $k->jurusan_id,
                    'jurusan' => optional($k->jurusan)->nama_jurusan,
                ],
            ];
        });

        return view('kelas.show', compact('kelas', 'kelasList', 'tahunAjars', 'kelasJurusanMap', 'jurusans'));
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

        $redirectTo = $request->input('redirect_to');
        if ($redirectTo) {
            return redirect($redirectTo)->with('success', 'Kelas berhasil diperbarui.');
        }

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

    /**
     * Handle bulk actions for kelas.
     */
    public function bulk(Request $request)
    {
        $data = $request->validate([
            'action' => ['required', Rule::in(['delete', 'set_jurusan', 'set_level', 'set_tahun_ajar'])],
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:kelas,id'],
            'jurusan_id' => ['nullable', 'exists:jurusans,id'],
            'level_kelas' => ['nullable', Rule::in(['X', 'XI', 'XII'])],
            'tahun_ajar_id' => ['nullable', 'exists:tahun_ajars,id'],
        ]);

        $query = Kelas::whereIn('id', $data['ids']);

        switch ($data['action']) {
            case 'delete':
                $query->delete();
                break;
            case 'set_jurusan':
                if (! $data['jurusan_id']) {
                    return redirect()->route('kelas.index')->with('error', 'Jurusan harus dipilih untuk aksi ini.');
                }
                $query->update(['jurusan_id' => $data['jurusan_id']]);
                break;
            case 'set_level':
                if (! $data['level_kelas']) {
                    return redirect()->route('kelas.index')->with('error', 'Level harus dipilih untuk aksi ini.');
                }
                $query->update(['level_kelas' => $data['level_kelas']]);
                break;
            case 'set_tahun_ajar':
                if (! $data['tahun_ajar_id']) {
                    return redirect()->route('kelas.index')->with('error', 'Tahun ajar harus dipilih untuk aksi ini.');
                }
                $query->update(['tahun_ajar_id' => $data['tahun_ajar_id']]);
                break;
        }

        return redirect()->route('kelas.index')->with('success', 'Aksi massal berhasil dijalankan.');
    }
}
