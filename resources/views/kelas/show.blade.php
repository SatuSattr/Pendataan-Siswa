<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/kelas/show/{{ $kelas->nama_kelas }}" title="Detail Kelas" />
    </x-slot>

    @php
    $totalSiswa = $kelas->kelasDetails->count();
    $aktif = $kelas->kelasDetails->where('status', 'aktif')->count();
    $nonAktif = $totalSiswa - $aktif;
    @endphp

    <div class="space-y-6">
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-50 via-white to-slate-50 p-6 ring-1 ring-slate-200">
            <div class="absolute -left-10 -top-10 h-40 w-40 rounded-full bg-brand-200/30 blur-2xl"></div>
            <div class="absolute -right-12 -bottom-16 h-48 w-48 rounded-full bg-indigo-100/40 blur-3xl"></div>

            <div class="relative flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-brand-700">Detail Kelas</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $kelas->nama_kelas }}</h1>
                    <p class="mt-1 text-sm text-slate-600">Informasi kelas, status siswa, dan tahun ajar aktif.</p>
                </div>
                <a href="{{ route('kelas.edit', $kelas) }}" class="btn-brand p-4 absolute right-0 top-0">
                    <i class="fa-solid fa-pen-to-square"></i>
                </a>
            </div>

            <div class="relative mt-5 flex flex-wrap gap-3">
                <span class="inline-flex items-center gap-2 rounded-full bg-white/70 px-3 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                    <i class="fa-solid fa-layer-group text-brand-600"></i> Level {{ $kelas->level_kelas }}
                </span>
                <span class="inline-flex items-center gap-2 rounded-full bg-white/70 px-3 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                    <i class="fa-solid fa-diagram-project text-brand-600"></i> {{ $kelas->jurusan->nama_jurusan ?? 'Jurusan belum diatur' }}
                </span>
                <span class="inline-flex items-center gap-2 rounded-full bg-white/70 px-3 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                    <i class="fa-solid fa-calendar-days text-brand-600"></i> Tahun ajar {{ $kelas->tahunAjar->kode_tahun_ajar ?? '-' }}
                </span>
            </div>
        </div>


        <div class="card-surface rounded-2xl p-6 ring-1 ring-slate-100">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Siswa dalam Kelas Ini</h3>
                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total: {{ $totalSiswa }}</span>
            </div>
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full table-soft divide-y divide-slate-100">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left">NISN</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Jenis Kelamin</th>
                            <th class="px-4 py-3 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($kelas->kelasDetails as $detail)
                        <tr class="transition hover:bg-slate-50/60">
                            <td class="px-4 py-3 font-semibold text-slate-800">{{ $detail->siswa->nisn ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-800">{{ $detail->siswa->nama ?? '-' }}</td>
                            <td class="px-4 py-3 text-slate-800">
                                @if ($detail->siswa?->jenis_kelamin === 'L')
                                Laki-laki
                                @elseif ($detail->siswa?->jenis_kelamin === 'P')
                                Perempuan
                                @else
                                -
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-800">
                                <span class="rounded-full px-2 py-1 text-xs {{ $detail->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-700' }}">{{ ucfirst($detail->status) }}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-4 py-6 text-center text-slate-500">Belum ada siswa aktif di kelas ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>