<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/kelas/show/{{ $kelas->nama_kelas }}" title="Detail Kelas" />
    </x-slot>

    @php
    $totalSiswa = $kelas->kelasDetails->count();
    $aktif = $kelas->kelasDetails->where('status', 'aktif')->count();
    $nonAktif = $totalSiswa - $aktif;
    @endphp

    <div class="space-y-6" x-data="kelasSiswaDetail()">
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
                            <th class="px-4 py-3 text-left">Foto</th>
                            <th class="px-4 py-3 text-left">NISN</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Jenis Kelamin</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($kelas->kelasDetails as $detail)
                        <tr class="transition hover:bg-slate-50/60">
                            <td class="px-4 py-3">
                                @php
                                    $foto = $detail->siswa?->foto_path ? asset($detail->siswa->foto_path) : null;
                                    if ($detail->siswa?->foto_path && ! Str::startsWith($detail->siswa->foto_path, 'images/')) {
                                        $foto = Storage::url($detail->siswa->foto_path);
                                    }
                                @endphp
                                @if($foto)
                                <img src="{{ $foto }}" alt="Foto {{ $detail->siswa->nama ?? 'Siswa' }}" class="size-14 rounded-lg object-cover ring-1 ring-slate-200" loading="lazy">
                                @else
                                <div class="flex size-14 items-center justify-center rounded-lg bg-slate-100 text-slate-400 ring-1 ring-slate-200">
                                    <i class="fa-regular fa-user text-lg"></i>
                                </div>
                                @endif
                            </td>
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
                            <td class="px-4 py-3">
                                @if($detail->siswa)
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('siswa.show', $detail->siswa) }}" class="text-brand-600 hover:text-brand-700" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    @php
                                        $fotoUrl = $detail->siswa?->foto_path
                                            ? (Str::startsWith($detail->siswa->foto_path, 'images/') ? asset($detail->siswa->foto_path) : Storage::url($detail->siswa->foto_path))
                                            : null;
                                    @endphp
                                    <a href="{{ route('siswa.edit', $detail->siswa) }}" class="text-sky-600 hover:text-sky-700" title="Edit"
                                        @click.prevent="openEditModal({
                                            id: {{ $detail->siswa->id }},
                                            nama: @js($detail->siswa->nama),
                                            nisn: @js($detail->siswa->nisn),
                                            alamat: @js($detail->siswa->alamat),
                                            tanggal_lahir: @js(optional($detail->siswa->tanggal_lahir)->toDateString()),
                                            jenis_kelamin: @js($detail->siswa->jenis_kelamin),
                                            jurusan_id: {{ $detail->siswa->jurusan_id ?? 'null' }},
                                            jurusan_name: @js($detail->siswa->jurusan->nama_jurusan ?? null),
                                            tahun_ajar_id: {{ $detail->tahun_ajar_id ?? 'null' }},
                                            kelas_id: {{ $detail->kelas_id ?? 'null' }},
                                            foto_url: @js($fotoUrl),
                                        })">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('siswa.destroy', $detail->siswa) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-700" onclick="return confirm('Hapus data siswa ini?')" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-4 py-6 text-center text-slate-500">Belum ada siswa aktif di kelas ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <template x-teleport="body">
            @include('siswa.partials.edit-modal')
        </template>
    </div>


    @push('scripts')
        <script>
            function kelasSiswaDetail() {
                return {
                    showEditModal: false,
                    redirectTo: @js(request()->fullUrl()),
                    kelasJurusanMap: @json($kelasJurusanMap),
                    updateActionBase: `{{ url('/siswa') }}`,
                    editForm: {
                        id: null,
                        nama: '',
                        nisn: '',
                        alamat: '',
                        tanggal_lahir: '',
                        jenis_kelamin: '',
                        jurusan_id: '',
                        jurusan_name: '',
                        tahun_ajar_id: '',
                        kelas_id: '',
                        foto_url: null,
                        fotoPreview: null,
                        remove_foto: false,
                    },
                    openEditModal(data) {
                        this.editForm = {
                            ...data,
                            fotoPreview: data.foto_url || null,
                            remove_foto: false,
                        };
                        this.syncEditJurusan(this.editForm.kelas_id);
                        this.$watch('editForm.kelas_id', (val) => this.syncEditJurusan(val));
                        this.showEditModal = true;
                        this.$nextTick(() => this.$refs.editNamaInput?.focus());
                    },
                    closeEditModal() {
                        if (this.editForm.fotoPreview && this.editForm.fotoPreview === this.editForm.foto_url) {
                            // keep initial preview; do nothing
                        }
                        this.showEditModal = false;
                    },
                    handleEditFotoChange(event) {
                        const file = event?.target?.files?.[0];
                        if (this.editForm.fotoPreview && this.editForm.fotoPreview !== this.editForm.foto_url) {
                            URL.revokeObjectURL(this.editForm.fotoPreview);
                        }
                        this.editForm.fotoPreview = file ? URL.createObjectURL(file) : this.editForm.foto_url;
                        this.editForm.remove_foto = false;
                    },
                    clearEditFoto() {
                        if (this.editForm.fotoPreview && this.editForm.fotoPreview !== this.editForm.foto_url) {
                            URL.revokeObjectURL(this.editForm.fotoPreview);
                        }
                        this.editForm.fotoPreview = null;
                        this.editForm.foto_url = null;
                        this.editForm.remove_foto = true;
                        if (this.$refs.editFotoInput) {
                            this.$refs.editFotoInput.value = '';
                        }
                    },
                    syncEditJurusan(val) {
                        const data = this.kelasJurusanMap?.[val];
                        this.editForm.jurusan_id = data ? data.jurusan_id : null;
                        this.editForm.jurusan_name = data ? data.jurusan : '';
                    },
                };
            }
        </script>
    @endpush

    
</x-app-layout>
