<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/kelas/show/{{ $kelas->nama_kelas }}" title="Detail Kelas" />
    </x-slot>

    <div class="space-y-6">
        <div class="card-surface rounded-2xl p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-sm font-semibold text-slate-600">Nama Kelas</p>
                    <p class="mt-1 text-lg font-semibold text-slate-900">{{ $kelas->nama_kelas }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-600">Level</p>
                    <p class="mt-1 text-lg font-semibold text-slate-900">{{ $kelas->level_kelas }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-600">Jurusan</p>
                    <p class="mt-1 text-lg font-semibold text-slate-900">{{ $kelas->jurusan->nama_jurusan ?? '-' }}</p>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-600">Tahun Ajar</p>
                    <p class="mt-1 text-lg font-semibold text-slate-900">{{ $kelas->tahunAjar->kode_tahun_ajar ?? '-' }}</p>
                </div>
            </div>
            <div class="mt-6 flex items-center justify-end gap-3">
                <a href="{{ route('kelas.index') }}" class="inline-flex items-center rounded-xl border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-700 hover:border-brand-300 hover:text-brand-700">
                    Kembali
                </a>
                <a href="{{ route('kelas.edit', $kelas) }}" class="btn-brand inline-flex items-center gap-2">
                    <i class="fa-solid fa-pen-to-square"></i> Edit
                </a>
            </div>
        </div>

        <div class="card-surface rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <h3 class="text-lg font-semibold text-slate-900">Siswa dalam Kelas Ini</h3>
                <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total: {{ $kelas->kelasDetails->count() }}</span>
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
                            <tr class="hover:bg-slate-50/60 transition">
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
                                    <span class="px-2 py-1 rounded-full text-xs {{ $detail->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-slate-100 text-slate-700' }}">{{ ucfirst($detail->status) }}</span>
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
