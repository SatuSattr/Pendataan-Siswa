<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/siswa/index" title="Data Siswa">
            <x-slot name="actions">
                <button type="button" class="btn-brand" @click="$dispatch('open-add-modal')">
                    <i class="fa-solid fa-plus"></i> Tambah Siswa
                </button>
            </x-slot>
        </x-page-header>
    </x-slot>

    <div x-data="{
        showModal: false,
        showAddModal: {{ $errors->any() ? 'true' : 'false' }},
        showEditModal: false,
        viewMode: localStorage.getItem('siswaViewMode') || 'table',
        selected: null,
        selectedHistory: [],
        kelasJurusanMap: @js($kelasJurusanMap),
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
        updateActionBase: `{{ url('/siswa') }}`,
        setMode(mode) {
            this.viewMode = mode;
            localStorage.setItem('siswaViewMode', mode);
        },
        openAddModal() {
            this.showAddModal = true;
            this.$nextTick(() => this.$refs.namaInput?.focus());
        },
        openModal(data) {
            this.selected = data;
            this.selectedHistory = data.history || [];
            this.showModal = true;
            this.$nextTick(() => { this.renderBarcode(); });
        },
        closeModal() {
            this.showModal = false;
            setTimeout(() => {
                this.selected = null;
                this.selectedHistory = [];
            }, 250);
        },
        closeAddModal() {
            this.showAddModal = false;
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
        renderBarcode() {
            if (!window.JsBarcode || !this.$refs.barcode || !this.selected?.nisn) return;
            JsBarcode(this.$refs.barcode, this.selected.nisn, {
                format: 'CODE128',
                displayValue: true,
                fontSize: 20,
                height: 60,
                margin: 0,
            });
        }
    }" @open-add-modal.window="openAddModal()" class="space-y-6">
        <div class="card-surface rounded-2xl p-6">
            <form method="GET" action="{{ route('siswa.index') }}"
                class="flex flex-col gap-4 md:flex-row md:flex-wrap md:items-end">
                <div class="md:flex-1 min-w-[260px]">
                    <label class="block text-sm font-semibold text-slate-700">Cari nama atau NISN</label>
                    <div
                        class="mt-2 flex items-center gap-1 rounded-xl border border-slate-200 bg-white px-3 pr-0 text-slate-800 shadow-sm focus-within:border-brand-400 focus-within:ring-2 focus-within:ring-brand-100">
                        <input type="text" name="search" value="{{ $search }}"
                            class="flex-1 border-0 bg-transparent py-2 text-sm focus:outline-none focus:ring-0 focus:ring-offset-0 focus-visible:ring-0 focus-visible:ring-offset-0"
                            placeholder="Cari...">
                        <a href="{{ route('siswa.index') }}"
                            class="inline-flex h-10 w-10 items-center justify-center rounded-lg text-slate-500 hover:text-brand-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-400"
                            title="Reset">
                            <i class="fa-solid fa-rotate-right"></i>
                        </a>
                        <button type="submit"
                            class="btn-brand inline-flex h-10 w-10 items-center justify-center shadow-none"
                            title="Cari">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>

                    </div>
                </div>
                <div class="md:w-64">
                    <label class="block text-sm font-semibold text-slate-700">Filter Jurusan</label>
                    <select name="jurusan_id"
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                        <option value="">Semua Jurusan</option>
                        @foreach ($jurusans as $jurusan)
                            <option value="{{ $jurusan->id }}" @selected($jurusanId == $jurusan->id)>
                                {{ $jurusan->nama_jurusan }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="md:w-64">
                    <label class="block text-sm font-semibold text-slate-700">Filter Kelas</label>
                    <select name="kelas_id"
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                        <option value="">Semua Kelas</option>
                        @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}" @selected($kelasId == $kelas->id)>{{ $kelas->nama_kelas }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <div class="card-surface rounded-2xl p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Daftar Siswa</h3>
                    <span class="text-xs font-semibold uppercase tracking-wide text-slate-500">Total:
                        {{ $siswas->total() }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-sm font-semibold transition"
                        :class="viewMode === 'table' ? 'bg-brand-50 text-brand-700 ring-1 ring-brand-100' :
                            'text-slate-500 hover:text-brand-600 ring-1 ring-transparent hover:ring-slate-200'"
                        @click="setMode('table')" title="Tampilan tabel">
                        <i class="fa-solid fa-table"></i>
                    </button>
                    <button type="button"
                        class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-sm font-semibold transition"
                        :class="viewMode === 'card' ? 'bg-brand-50 text-brand-700 ring-1 ring-brand-100' :
                            'text-slate-500 hover:text-brand-600 ring-1 ring-transparent hover:ring-slate-200'"
                        @click="setMode('card')" title="Tampilan kartu">
                        <i class="fa-solid fa-grip"></i>
                    </button>
                </div>
            </div>
            <div class="mt-4 overflow-x-auto" x-show="viewMode === 'table'" x-cloak>
                <table class="min-w-full table-soft divide-y divide-slate-100">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 text-left">Foto</th>
                            <th class="px-4 py-3 text-left">NISN</th>
                            <th class="px-4 py-3 text-left">Nama</th>
                            <th class="px-4 py-3 text-left">Jurusan</th>
                            <th class="px-4 py-3 text-left">Kelas Aktif</th>
                            <th class="px-4 py-3 text-left">Tahun Ajar</th>
                            <th class="px-4 py-3 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($siswas as $siswa)
                            @php
                                $activeDetail =
                                    $siswa->kelasDetails->firstWhere('status', 'aktif') ??
                                    $siswa->kelasDetails->first();
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
                            @endphp
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-4 py-3">
                                    @if ($siswa->foto_path)
                                        <img src="{{ Storage::url($siswa->foto_path) }}"
                                            alt="Foto {{ $siswa->nama }}"
                                            class="size-14 rounded-lg object-cover ring-1 ring-slate-200">
                                    @else
                                        <span
                                            class="inline-flex size-14 items-center justify-center rounded-lg bg-slate-100 text-slate-400 ring-1 ring-slate-200">
                                            <i class="fa-regular fa-user text-lg"></i>
                                        </span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 font-semibold text-slate-800">{{ $siswa->nisn }}</td>
                                <td class="px-4 py-3 text-slate-800">{{ $siswa->nama }}</td>
                                <td class="px-4 py-3 text-slate-800">{{ $siswa->jurusan->nama_jurusan ?? '-' }}</td>
                                <td class="px-4 py-3 text-slate-800">{{ $activeDetail->kelas->nama_kelas ?? '-' }}</td>
                                <td class="px-4 py-3 text-slate-800">
                                    {{ $activeDetail->tahunAjar->kode_tahun_ajar ?? ($siswa->tahunAjar->kode_tahun_ajar ?? '-') }}
                                </td>
                                <td class="px-4 py-3 text-slate-800">
                                    <div class="flex items-center gap-3">
                                        <a href="{{ route('siswa.show', $siswa) }}"
                                            class="text-brand-600 hover:text-brand-700" title="Detail">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                        <a href="{{ route('siswa.edit', $siswa) }}"
                                            class="text-sky-600 hover:text-sky-700" title="Edit"
                                            @click.prevent="openEditModal({
                                                id: {{ $siswa->id }},
                                                nama: @js($siswa->nama),
                                                nisn: @js($siswa->nisn),
                                                alamat: @js($siswa->alamat),
                                                tanggal_lahir: @js(optional($siswa->tanggal_lahir)->toDateString()),
                                                jenis_kelamin: @js($siswa->jenis_kelamin),
                                                jurusan_id: {{ $siswa->jurusan_id ?? 'null' }},
                                                tahun_ajar_id: {{ $siswa->tahun_ajar_id ?? 'null' }},
                                                kelas_id: {{ optional($activeDetail->kelas)->id ?? 'null' }},
                                                foto_url: @js($siswa->foto_path ? Storage::url($siswa->foto_path) : null),
                                            })">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </a>
                                        <form action="{{ route('siswa.destroy', $siswa) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-700"
                                                onclick="return confirm('Hapus data siswa ini?')" title="Hapus">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-4 py-6 text-center text-slate-500">Belum ada data siswa.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4" x-show="viewMode === 'card'" x-cloak>
                @if ($siswas->isEmpty())
                    <div
                        class="rounded-xl border border-dashed border-slate-200 bg-slate-50/60 px-4 py-6 text-center text-sm text-slate-500">
                        Belum ada data siswa.
                    </div>
                @else
                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                        @foreach ($siswas as $siswa)
                            @php
                                $activeDetail =
                                    $siswa->kelasDetails->firstWhere('status', 'aktif') ??
                                    $siswa->kelasDetails->first();
                            @endphp
                            <div
                                class="group rounded-xl border relative border-slate-200 bg-white p-4 shadow-sm ring-1 ring-transparent transition hover:-translate-y-1 hover:border-brand-200 hover:shadow-lg hover:ring-brand-100/70">
                                @if ($siswa->foto_path)
                                    <img src="{{ Storage::url($siswa->foto_path) }}" alt="Foto {{ $siswa->nama }}"
                                        class="w-24 h-full z-20 rounded-lg rounded-r-none object-cover absolute top-0 left-0 ring-1 ring-slate-200">
                                @else
                                    <span
                                        class="w-24 h-full absolute top-0 left-0 rounded-r-none inline-flex items-center justify-center rounded-lg bg-slate-100 text-slate-400 ring-1 ring-slate-200">
                                        <i class="fa-regular fa-user text-lg"></i>
                                    </span>
                                @endif
                                <div class="flex items-start justify-between relative pl-24 gap-3">
                                    <div class="flex items-center gap-3">
                                        <div>
                                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                                                {{ $siswa->nisn }}</p>
                                            <p class="mt-1 text-lg font-bold text-slate-900">
                                                {{ Str::limit($siswa->nama, 20) }}</p>
                                            <p class="text-sm text-slate-600">
                                                {{ $siswa->jurusan->nama_jurusan ?? '-' }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 flex flex-wrap gap-2 text-xs pl-24 text-slate-600">
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1 ring-1 ring-slate-200">
                                        <i class="fa-solid fa-door-open text-brand-600"></i>
                                        {{ $activeDetail->kelas->nama_kelas ?? '-' }}
                                    </span>
                                    <span
                                        class="inline-flex items-center gap-2 rounded-full bg-slate-50 px-3 py-1 ring-1 ring-slate-200">
                                        <i class="fa-solid fa-calendar-days text-brand-600"></i>
                                        {{ $activeDetail->tahunAjar->kode_tahun_ajar ?? ($siswa->tahunAjar->kode_tahun_ajar ?? '-') }}
                                    </span>
                                </div>
                                <div class="mt-3 flex items-center pl-24 gap-3 text-slate-600">
                                    <a href="{{ route('siswa.show', $siswa) }}"
                                        class="text-brand-600 hover:text-brand-700" title="Detail">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('siswa.edit', $siswa) }}"
                                        class="text-sky-600 hover:text-sky-700" title="Edit"
                                        @click.prevent="openEditModal({
                                        id: {{ $siswa->id }},
                                        nama: @js($siswa->nama),
                                        nisn: @js($siswa->nisn),
                                        alamat: @js($siswa->alamat),
                                        tanggal_lahir: @js(optional($siswa->tanggal_lahir)->toDateString()),
                                        jenis_kelamin: @js($siswa->jenis_kelamin),
                                        jurusan_id: {{ $siswa->jurusan_id ?? 'null' }},
                                        tahun_ajar_id: {{ $siswa->tahun_ajar_id ?? 'null' }},
                                        kelas_id: {{ optional($activeDetail->kelas)->id ?? 'null' }},
                                        foto_url: @js($siswa->foto_path ? Storage::url($siswa->foto_path) : null),
                                    })">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('siswa.destroy', $siswa) }}" method="POST"
                                        class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-rose-600 hover:text-rose-700"
                                            onclick="return confirm('Hapus data siswa ini?')" title="Hapus">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="mt-4">
                {{ $siswas->links() }}
            </div>
        </div>

        <template x-teleport="body">
            @include('siswa.partials.create-modal')
        </template>

        <template x-teleport="body">
            @include('siswa.partials.edit-modal')
        </template>

    </div>
</x-app-layout>
