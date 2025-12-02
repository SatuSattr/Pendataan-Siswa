<div x-cloak x-show="showAddModal" class="fixed inset-0 z-[95] flex items-center justify-center px-4" role="dialog"
    aria-modal="true">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeAddModal()"></div>

    @php
        $kelasJurusanMap = $kelasList->mapWithKeys(
            fn($k) => [
                $k->id => [
                    'jurusan_id' => $k->jurusan_id,
                    'jurusan' => $k->jurusan->nama_jurusan ?? '-',
                ],
            ],
        );
        $oldJurusanName = optional($jurusans->firstWhere('id', old('jurusan_id')))->nama_jurusan;
    @endphp
    <form x-show="showAddModal" x-transition x-ref="addForm" method="POST" action="{{ route('siswa.store') }}"
        enctype="multipart/form-data" x-data="kelasForm"
        class="relative w-full max-w-4xl rounded-2xl bg-white h-[55vh] max-h-[95vh] overflow-y-auto p-6 shadow-2xl ring-1 ring-slate-200">
        @csrf

        <button type="button"
            class="absolute right-6 top-6 z-20 flex items-center rounded-xl border p-3 border-slate-200 text-slate-700 hover:border-brand-300 hover:text-brand-700"
            @click="closeAddModal()">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="flex flex-col gap-6 md:flex-row md:items-start h-full">
            <div class="flex justify-center md:justify-start h-full">
                <div
                    class="h-full w-72 bg-gradient-to-br from-gray-50 to-slate-200 overflow-hidden ring-1 ring-slate-200 rounded-xl flex flex-col">
                    <div class="relative flex-1 overflow-hidden rounded-xl ring-1 ring-slate-200 bg-white">
                        <template x-if="fotoPreview">
                            <img :src="fotoPreview" alt="Preview foto" class="h-full w-full object-cover">
                        </template>
                        <template x-if="!fotoPreview">
                            <div class="h-full w-full flex items-center justify-center bg-slate-50">
                                <span
                                    class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-white/70 text-slate-400 ring-1 ring-slate-200">
                                    <i class="fa-regular fa-user text-2xl"></i>
                                </span>
                            </div>
                        </template>

                        <button type="button"
                            class="absolute bottom-2 right-2 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-slate-700 shadow ring-1 ring-slate-200 hover:text-brand-700 hover:ring-brand-200"
                            @click="$refs.fotoInput.click()">
                            <i class="fa-solid fa-upload text-sm"></i>
                        </button>
                        <template x-if="fotoPreview">
                            <button type="button"
                                class="absolute bottom-2 left-2 inline-flex h-10 items-center justify-center rounded-lg bg-white px-3 text-rose-600 shadow ring-1 ring-slate-200 hover:text-rose-700 hover:ring-rose-200"
                                @click="clearFoto()">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </template>
                        <template x-if="!fotoPreview">
                            <div class="mt-3 text-left absolute bottom-2 left-2">
                                <p class="font-semibold text-slate-700">Foto Siswa</p>
                                <p class="text-xs text-slate-500">Opsional. Maks 2 MB.</p>
                            </div>
                        </template>
                    </div>


                    <input type="file" name="foto" class="hidden" accept="image/*" x-ref="fotoInput"
                        @change="handleFotoChange">
                    @error('foto')
                        <p class="mt-2 px-4 text-xs text-rose-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex-1 space-y-6">
                <div class="space-y-1">
                    <p class="text-xl font-bold text-slate-900">Tambah Siswa</p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700" for="nama">Nama Lengkap</label>
                        <input type="text" name="nama" id="nama" x-ref="namaInput"
                            value="{{ old('nama') }}" placeholder="Nama siswa" required
                            class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                        @error('nama')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700" for="nisn">NISN</label>
                        <input type="text" name="nisn" id="nisn" value="{{ old('nisn') }}"
                            placeholder="Masukkan NISN" required
                            class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                        @error('nisn')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Jenis Kelamin</label>
                        <div class="mt-2 flex gap-2">
                            <label
                                class="flex-1 cursor-pointer rounded-xl border border-slate-200 bg-white px-2 py-3 text-sm font-semibold text-slate-800 hover:border-brand-300">
                                <input type="radio" name="jenis_kelamin" value="L" class="mr-2 align-middle"
                                    required @checked(old('jenis_kelamin') === 'L')>
                                Laki-laki
                            </label>
                            <label
                                class="flex-1 cursor-pointer rounded-xl border border-slate-200 bg-white px-2 py-3 text-sm font-semibold text-slate-800 hover:border-brand-300">
                                <input type="radio" name="jenis_kelamin" value="P" class="mr-2 align-middle"
                                    required @checked(old('jenis_kelamin') === 'P')>
                                Perempuan
                            </label>
                        </div>
                        @error('jenis_kelamin')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700" for="tanggal_lahir">Tanggal
                            Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" value="{{ old('tanggal_lahir') }}"
                            class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                        @error('tanggal_lahir')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700" for="jurusan_display">Jurusan</label>
                        <input type="hidden" name="jurusan_id" :value="selectedJurusanId || ''">
                        <input type="text" id="jurusan_display" value="{{ $oldJurusanName ?? '' }}" readonly
                            :value="selectedJurusanName || ''" placeholder="Pilih kelas agar jurusan terisi otomatis"
                            class="mt-2 block w-full rounded-xl border-slate-200 bg-slate-50 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                        @error('jurusan_id')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700" for="kelas_id">Kelas</label>
                        <select name="kelas_id" id="kelas_id" required x-model="selectedKelasId"
                            class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                            <option value="">Pilih kelas</option>
                            @foreach ($kelasList as $kelas)
                                <option value="{{ $kelas->id }}" @selected(old('kelas_id') == $kelas->id)>
                                    {{ $kelas->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700" for="tahun_ajar_id">Tahun
                            Ajar</label>
                        <select name="tahun_ajar_id" id="tahun_ajar_id" required
                            class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                            <option value="">Pilih tahun ajar</option>
                            @foreach ($tahunAjars as $tahunAjar)
                                <option value="{{ $tahunAjar->id }}" @selected(old('tahun_ajar_id') == $tahunAjar->id)>
                                    {{ $tahunAjar->kode_tahun_ajar }} - {{ $tahunAjar->nama_tahun_ajar }}
                                </option>
                            @endforeach
                        </select>
                        @error('tahun_ajar_id')
                            <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="alamat">Alamat</label>
                    <textarea rows="3" name="alamat" id="alamat" placeholder="Alamat lengkap"
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">{{ old('alamat') }}</textarea>
                    @error('alamat')
                        <p class="mt-1 text-sm text-rose-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-end">
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 hover:border-brand-300 hover:text-brand-700"
                        @click="closeAddModal()">Batal</button>
                    <button type="submit" class="btn-brand inline-flex items-center gap-2 px-5 py-3">
                        <i class="fa-solid fa-plus"></i>
                        Simpan Siswa
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

@once
    @push('scripts')
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('kelasForm', () => ({
                    selectedKelasId: @json(old('kelas_id')),
                    selectedJurusanId: @json(old('jurusan_id')),
                    selectedJurusanName: @json($oldJurusanName),
                    kelasJurusanMap: @json($kelasJurusanMap),
                    fotoPreview: null,
                    init() {
                        this.syncJurusan(this.selectedKelasId);
                        this.$watch('selectedKelasId', (val) => this.syncJurusan(val));
                    },
                    syncJurusan(val) {
                        const data = this.kelasJurusanMap && this.kelasJurusanMap[val];
                        this.selectedJurusanId = data ? data.jurusan_id : null;
                        this.selectedJurusanName = data ? data.jurusan : '';
                    },
                    handleFotoChange(event) {
                        const file = event?.target?.files?.[0];
                        if (this.fotoPreview) {
                            URL.revokeObjectURL(this.fotoPreview);
                        }
                        this.fotoPreview = file ? URL.createObjectURL(file) : null;
                    },
                    clearFoto() {
                        if (this.fotoPreview) {
                            URL.revokeObjectURL(this.fotoPreview);
                        }
                        this.fotoPreview = null;
                        if (this.$refs.fotoInput) {
                            this.$refs.fotoInput.value = '';
                        }
                    },
                }));
            });
        </script>
    @endpush
@endonce
