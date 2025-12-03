<div x-cloak x-show="showEditModal" class="fixed inset-0 z-[96] flex items-center justify-center px-4" role="dialog"
    aria-modal="true">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" @click="closeEditModal()"></div>

    <form x-show="showEditModal" x-transition x-ref="editFormEl" method="POST"
        :action="`${updateActionBase}/${editForm.id}`" enctype="multipart/form-data"
        class="relative w-full max-w-4xl rounded-2xl bg-white max-h-[95vh] overflow-y-auto p-6 shadow-2xl ring-1 ring-slate-200">
        @csrf
        @method('PUT')

        <button type="button"
            class="absolute right-6 top-6 z-20 flex items-center rounded-xl border p-3 border-slate-200 text-slate-700 hover:border-brand-300 hover:text-brand-700"
            @click="closeEditModal()">
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="flex flex-col gap-6 md:grid md:grid-cols-[18rem,1fr] md:items-stretch h-full">
            <div class="flex justify-center md:justify-start h-full">
                <div
                    class="h-full w-72 bg-gradient-to-br from-gray-50 to-slate-200 overflow-hidden ring-1 ring-slate-200 rounded-xl flex flex-col">
                    <div class="relative flex-1 overflow-hidden rounded-xl ring-1 ring-slate-200 bg-white">
                        <template x-if="editForm.fotoPreview">
                            <img :src="editForm.fotoPreview" alt="Preview foto" class="h-full w-full object-cover">
                        </template>
                        <template x-if="!editForm.fotoPreview">
                            <div class="h-full w-full flex items-center justify-center bg-slate-50">
                                <span
                                    class="inline-flex h-16 w-16 items-center justify-center rounded-full bg-white/70 text-slate-400 ring-1 ring-slate-200">
                                    <i class="fa-regular fa-user text-2xl"></i>
                                </span>
                            </div>
                        </template>

                        <button type="button"
                            class="absolute bottom-2 right-2 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-white text-slate-700 shadow ring-1 ring-slate-200 hover:text-brand-700 hover:ring-brand-200"
                            @click="$refs.editFotoInput.click()">
                            <i class="fa-solid fa-upload text-sm"></i>
                        </button>
                        <template x-if="editForm.fotoPreview">
                            <button type="button"
                                class="absolute bottom-2 left-2 inline-flex h-10 items-center justify-center rounded-lg bg-white px-3 text-rose-600 shadow ring-1 ring-slate-200 hover:text-rose-700 hover:ring-rose-200"
                                @click="clearEditFoto()">
                                <i class="fa-solid fa-trash-can text-sm"></i>
                            </button>
                        </template>
                        <template x-if="!editForm.fotoPreview">
                            <div class="mt-3 text-left absolute bottom-2 left-2">
                                <p class="font-semibold text-slate-700">Foto Siswa</p>
                                <p class="text-xs text-slate-500">Opsional. Maks 2 MB.</p>
                            </div>
                        </template>
                    </div>
                    <input type="file" name="foto" class="hidden" accept="image/*" x-ref="editFotoInput"
                        @change="handleEditFotoChange">
                    <input type="hidden" name="remove_foto" :value="editForm.remove_foto ? 1 : 0">
                </div>
            </div>

            <div class="flex-1 space-y-6">
                <div class="space-y-1">
                    <p class="text-xl font-bold text-slate-900">Edit Siswa</p>
                    <p class="text-sm text-slate-600">Perbarui data siswa, kelas aktif, dan tahun ajar berjalan.</p>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700" for="edit_nama">Nama Lengkap</label>
                        <input type="text" name="nama" id="edit_nama" x-ref="editNamaInput"
                            x-model="editForm.nama" placeholder="Nama siswa" required
                            class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700" for="edit_nisn">NISN</label>
                        <input type="text" name="nisn" id="edit_nisn" x-model="editForm.nisn"
                            placeholder="Masukkan NISN" required
                            class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700">Jenis Kelamin</label>
                        <div class="mt-2 flex gap-2">
                            <label
                                class="flex-1 cursor-pointer rounded-xl border border-slate-200 bg-white px-2 py-3 text-sm font-semibold text-slate-800 hover:border-brand-300">
                                <input type="radio" name="jenis_kelamin" value="L" class="mr-2 align-middle"
                                    required x-model="editForm.jenis_kelamin">
                                Laki-laki
                            </label>
                            <label
                                class="flex-1 cursor-pointer rounded-xl border border-slate-200 bg-white px-2 py-3 text-sm font-semibold text-slate-800 hover:border-brand-300">
                                <input type="radio" name="jenis_kelamin" value="P" class="mr-2 align-middle"
                                    required x-model="editForm.jenis_kelamin">
                                Perempuan
                            </label>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700" for="edit_tanggal_lahir">Tanggal
                            Lahir</label>
                        <input type="date" name="tanggal_lahir" id="edit_tanggal_lahir"
                            x-model="editForm.tanggal_lahir"
                            class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                    <div>
                        <label class="block text-sm font-semibold text-slate-700"
                            for="edit_jurusan_display">Jurusan</label>
                        <input type="hidden" name="jurusan_id" :value="editForm.jurusan_id || ''">
                        <input type="text" id="edit_jurusan_display" readonly :value="editForm.jurusan_name || ''"
                            class="mt-2 block w-full rounded-xl border-slate-200 bg-slate-50 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700" for="edit_kelas_id">Kelas</label>
                        <select name="kelas_id" id="edit_kelas_id" required x-model="editForm.kelas_id"
                            @change="syncEditJurusan(editForm.kelas_id)"
                            class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                            <option value="">Pilih kelas</option>
                            @foreach ($kelasList as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama_kelas }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-slate-700" for="edit_tahun_ajar_id">Tahun
                            Ajar</label>
                        <select name="tahun_ajar_id" id="edit_tahun_ajar_id" required
                            x-model="editForm.tahun_ajar_id"
                            class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200">
                            <option value="">Pilih tahun ajar</option>
                            @foreach ($tahunAjars as $tahunAjar)
                            <option value="{{ $tahunAjar->id }}">{{ $tahunAjar->kode_tahun_ajar }} -
                                {{ $tahunAjar->nama_tahun_ajar }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-slate-700" for="edit_alamat">Alamat</label>
                    <textarea rows="3" name="alamat" id="edit_alamat" placeholder="Alamat lengkap" x-model="editForm.alamat"
                        class="mt-2 block w-full rounded-xl border-slate-200 text-slate-800 shadow-sm focus:border-brand-400 focus:ring-brand-200"></textarea>
                </div>

                <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-end">
                    <button type="button"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 hover:border-brand-300 hover:text-brand-700"
                        @click="closeEditModal()">Batal</button>
                    <button type="submit" class="btn-brand inline-flex items-center gap-2 px-5 py-3">
                        <i class="fa-solid fa-floppy-disk"></i>
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
