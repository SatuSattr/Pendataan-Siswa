<?php

namespace App\Http\Controllers;

use App\Models\Jurusan;
use App\Models\Kelas;
use App\Models\KelasDetail;
use App\Models\Siswa;
use App\Models\TahunAjar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $jurusanId = $request->query('jurusan_id');
        $kelasId = $request->query('kelas_id');

        $query = Siswa::with([
            'jurusan',
            'tahunAjar',
            'kelasDetails' => fn ($q) => $q->with(['kelas', 'tahunAjar'])->orderByDesc('created_at'),
        ]);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");
            });
        }

        if ($jurusanId) {
            $query->where('jurusan_id', $jurusanId);
        }

        if ($kelasId) {
            $query->whereHas('kelasDetails', function ($q) use ($kelasId) {
                $q->where('status', 'aktif')->where('kelas_id', $kelasId);
            });
        }

        $siswas = $query->orderBy('nama')->paginate(10)->withQueryString();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $kelasList = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        $tahunAjars = TahunAjar::orderByDesc('kode_tahun_ajar')->get();
        $kelasJurusanMap = $kelasList->mapWithKeys(function ($k) {
            return [
                $k->id => [
                    'jurusan_id' => $k->jurusan_id,
                    'jurusan' => optional($k->jurusan)->nama_jurusan,
                ],
            ];
        });

        return view('siswa.index', compact('siswas', 'jurusans', 'kelasList', 'tahunAjars', 'kelasJurusanMap', 'search', 'jurusanId', 'kelasId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $kelasList = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        $tahunAjars = TahunAjar::orderByDesc('kode_tahun_ajar')->get();

        return view('siswa.create', compact('jurusans', 'kelasList', 'tahunAjars'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nisn' => ['required', 'string', 'unique:siswas,nisn'],
            'nama' => ['required', 'string'],
            'alamat' => ['nullable', 'string'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['required', 'string', Rule::in(['L', 'P'])],
            'jurusan_id' => ['required', 'exists:jurusans,id'],
            'tahun_ajar_id' => ['required', 'exists:tahun_ajars,id'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        DB::transaction(function () use ($data, $request) {
            $fotoPath = null;
            if ($request->hasFile('foto')) {
                $fotoPath = $request->file('foto')->store('fotos', 'public');
            }

            $siswa = Siswa::create([
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'alamat' => $data['alamat'] ?? null,
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $data['jenis_kelamin'],
                'jurusan_id' => $data['jurusan_id'],
                'tahun_ajar_id' => $data['tahun_ajar_id'],
                'foto_path' => $fotoPath,
            ]);

            KelasDetail::create([
                'siswa_id' => $siswa->id,
                'kelas_id' => $data['kelas_id'],
                'tahun_ajar_id' => $data['tahun_ajar_id'],
                'status' => 'aktif',
            ]);
        });

        return redirect()->route('siswa.index')->with('success', 'Siswa baru berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Siswa $siswa)
    {
        $siswa->load(['jurusan', 'tahunAjar', 'kelasDetails' => fn ($q) => $q->with(['kelas', 'tahunAjar'])->orderByDesc('created_at')]);

        $activeDetail = $siswa->kelasDetails->firstWhere('status', 'aktif') ?? $siswa->kelasDetails->first();
        $history = $siswa->kelasDetails
            ->map(function ($detail) {
                return [
                    'kelas' => $detail->kelas->nama_kelas ?? '-',
                    'tahun' => $detail->tahunAjar->kode_tahun_ajar ?? '-',
                    'status' => $detail->status,
                    'tanggal' => optional($detail->created_at)->format('d M Y'),
                ];
            })
            ->values();
        $fotoUrl = $siswa->foto_path ? Storage::url($siswa->foto_path) : null;
        $kelasList = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        $tahunAjars = TahunAjar::orderByDesc('kode_tahun_ajar')->get();
        $kelasJurusanMap = $kelasList->mapWithKeys(function ($k) {
            return [
                $k->id => [
                    'jurusan_id' => $k->jurusan_id,
                    'jurusan' => optional($k->jurusan)->nama_jurusan,
                ],
            ];
        });

        $initialEdit = [
            'id' => $siswa->id,
            'nama' => $siswa->nama,
            'nisn' => $siswa->nisn,
            'alamat' => $siswa->alamat,
            'tanggal_lahir' => optional($siswa->tanggal_lahir)->toDateString(),
            'jenis_kelamin' => $siswa->jenis_kelamin,
            'jurusan_id' => $siswa->jurusan_id,
            'jurusan_name' => $siswa->jurusan->nama_jurusan ?? null,
            'tahun_ajar_id' => $activeDetail?->tahunAjar?->id ?? $siswa->tahun_ajar_id,
            'kelas_id' => $activeDetail?->kelas?->id,
            'foto_url' => $fotoUrl,
        ];

        return view('siswa.show', compact('siswa', 'activeDetail', 'history', 'fotoUrl', 'kelasList', 'tahunAjars', 'kelasJurusanMap', 'initialEdit'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Siswa $siswa)
    {
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $kelasList = Kelas::with('jurusan')->orderBy('nama_kelas')->get();
        $tahunAjars = TahunAjar::orderByDesc('kode_tahun_ajar')->get();
        $activeDetail = $siswa->kelasDetails()->where('status', 'aktif')->first();

        return view('siswa.edit', compact('siswa', 'jurusans', 'kelasList', 'tahunAjars', 'activeDetail'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Siswa $siswa)
    {
        $data = $request->validate([
            'nisn' => ['required', 'string', Rule::unique('siswas', 'nisn')->ignore($siswa->id)],
            'nama' => ['required', 'string'],
            'alamat' => ['nullable', 'string'],
            'tanggal_lahir' => ['nullable', 'date'],
            'jenis_kelamin' => ['required', 'string', Rule::in(['L', 'P'])],
            'jurusan_id' => ['required', 'exists:jurusans,id'],
            'tahun_ajar_id' => ['required', 'exists:tahun_ajars,id'],
            'kelas_id' => ['required', 'exists:kelas,id'],
            'foto' => ['nullable', 'image', 'max:2048'],
            'remove_foto' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($data, $request, $siswa) {
            if ($request->hasFile('foto')) {
                if ($siswa->foto_path) {
                    Storage::disk('public')->delete($siswa->foto_path);
                }

                $data['foto_path'] = $request->file('foto')->store('fotos', 'public');
            } elseif ($request->boolean('remove_foto')) {
                if ($siswa->foto_path) {
                    Storage::disk('public')->delete($siswa->foto_path);
                }
                $data['foto_path'] = null;
            }

            $siswa->update([
                'nisn' => $data['nisn'],
                'nama' => $data['nama'],
                'alamat' => $data['alamat'] ?? null,
                'tanggal_lahir' => $data['tanggal_lahir'] ?? null,
                'jenis_kelamin' => $data['jenis_kelamin'],
                'jurusan_id' => $data['jurusan_id'],
                'tahun_ajar_id' => $data['tahun_ajar_id'],
                'foto_path' => array_key_exists('foto_path', $data) ? $data['foto_path'] : $siswa->foto_path,
            ]);

            $activeDetail = $siswa->kelasDetails()->where('status', 'aktif')->latest()->first();

            if (! $activeDetail || $activeDetail->kelas_id !== (int) $data['kelas_id'] || $activeDetail->tahun_ajar_id !== (int) $data['tahun_ajar_id']) {
                if ($activeDetail) {
                    $activeDetail->update(['status' => 'nonaktif']);
                }

                KelasDetail::create([
                    'siswa_id' => $siswa->id,
                    'kelas_id' => $data['kelas_id'],
                    'tahun_ajar_id' => $data['tahun_ajar_id'],
                    'status' => 'aktif',
                ]);
            }
        });

        $redirectTo = $request->input('redirect_to');
        if ($redirectTo) {
            return redirect($redirectTo)->with('success', 'Data siswa berhasil diperbarui.');
        }

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto_path) {
            Storage::disk('public')->delete($siswa->foto_path);
        }

        $siswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
