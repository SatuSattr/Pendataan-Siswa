<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/siswa/{{ $siswa->id }}" title="Detail Siswa" />
    </x-slot>

    @php
        $genderLabel =
            $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : ($siswa->jenis_kelamin === 'P' ? 'Perempuan' : '-');
        $activeKelas = $activeDetail?->kelas?->nama_kelas ?? '-';
        $activeTahun = $activeDetail?->tahunAjar?->kode_tahun_ajar ?? ($siswa->tahunAjar->kode_tahun_ajar ?? '-');
    @endphp

    <div x-data="{
            showEditModal: false,
            updateActionBase: '{{ url('/siswa') }}',
            redirectTo: @js(request()->url()),
            kelasJurusanMap: @js($kelasJurusanMap),
            initialEdit: @js($initialEdit),
            editForm: {},
            init() {
                this.resetEditForm();
                this.syncEditJurusan(this.editForm.kelas_id);
                this.$watch('editForm.kelas_id', (val) => this.syncEditJurusan(val));
            },
            resetEditForm() {
                this.editForm = {
                    ...this.initialEdit,
                    fotoPreview: this.initialEdit.foto_url || null,
                    remove_foto: false,
                };
            },
            openEditModal() {
                this.resetEditForm();
                this.showEditModal = true;
                this.$nextTick(() => this.$refs.editNamaInput?.focus());
            },
            closeEditModal() {
                if (this.editForm.fotoPreview && this.editForm.fotoPreview !== this.editForm.foto_url) {
                    URL.revokeObjectURL(this.editForm.fotoPreview);
                }
                this.showEditModal = false;
            },
            syncEditJurusan(val) {
                const data = this.kelasJurusanMap?.[val];
                this.editForm.jurusan_id = data ? data.jurusan_id : null;
                this.editForm.jurusan_name = data ? data.jurusan : '';
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
        }" class="space-y-6">
        <div
            class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-50 via-white to-slate-50 p-6 ring-1 ring-slate-200">
            <div class="absolute -left-16 top-6 h-36 w-36 rounded-full bg-brand-200/40 blur-3xl"></div>
            <div class="absolute -right-12 bottom-0 h-48 w-48 rounded-full bg-indigo-100/50 blur-3xl"></div>

            <div class="relative flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-brand-700">Profil Siswa</p>
                    <h1 class="mt-1 text-3xl font-bold text-slate-900">{{ $siswa->nama }}</h1>
                </div>
                <button type="button" class="btn-brand p-4 absolute right-0 top-0" @click="openEditModal()">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
            </div>

            <div class="relative mt-6 grid gap-6 md:grid-cols-[18rem,1fr] md:items-stretch">
                <div class="flex justify-center md:justify-start h-full">
                    @if ($fotoUrl)
                        <div
                            class="w-72 h-full overflow-hidden rounded-2xl bg-white/70 ring-1 ring-slate-200 shadow-md">
                            <img src="{{ $fotoUrl }}" alt="Foto {{ $siswa->nama }}"
                                class="h-full w-full object-cover">
                        </div>
                    @else
                        <div
                            class="w-72 h-full min-h-[14rem] rounded-2xl bg-white/70 p-6 ring-1 ring-dashed ring-slate-300 shadow-inner flex items-center justify-center text-slate-400">
                            <div class="flex flex-col items-center gap-2">
                                <i class="fa-regular fa-user text-3xl"></i>
                                <p class="text-xs font-semibold text-slate-500">Belum ada foto</p>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="space-y-4">
                    <div class="flex flex-wrap items-center gap-3">
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 text-xs font-semibold text-brand-800 ring-1 ring-brand-100">
                            <i class="fa-solid fa-id-card"></i>
                            NISN: {{ $siswa->nisn }}
                        </span>
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 text-xs font-semibold text-brand-800 ring-1 ring-brand-100">
                            <i class="fa-solid fa-chalkboard"></i>
                            @if($activeDetail?->kelas)
                                <a href="{{ route('kelas.show', $activeDetail->kelas) }}" class="text-brand-700 hover:text-brand-800 underline decoration-dotted">
                                    {{ $activeKelas }}
                                </a>
                            @else
                                {{ $activeKelas }}
                            @endif
                        </span>
                        <span
                            class="inline-flex items-center gap-2 rounded-full bg-white px-3 py-1 text-xs font-semibold text-brand-800 ring-1 ring-brand-100">
                            <i class="fa-regular fa-calendar"></i>
                            {{ optional($siswa->tanggal_lahir)->format('d M Y') ?? '-' }}
                        </span>
                    </div>

                    <div class="grid gap-3 sm:grid-cols-3">
                        <div class="rounded-xl bg-white p-3 ring-1 ring-slate-200 shadow-sm">
                            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Jenis Kelamin
                            </p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $genderLabel }}</p>
                        </div>
                        <div class="rounded-xl bg-white p-3 ring-1 ring-slate-200 shadow-sm">
                            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Jurusan</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">
                                {{ $siswa->jurusan->nama_jurusan ?? '-' }}</p>
                        </div>
                        <div class="rounded-xl bg-white p-3 ring-1 ring-slate-200 shadow-sm">
                            <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Tahun Ajar Aktif
                            </p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">{{ $activeTahun }}</p>
                        </div>
                    </div>

                    <div class="rounded-xl bg-white p-3 ring-1 ring-slate-200 shadow-sm">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Alamat</p>
                        <p class="mt-1 text-sm font-semibold text-slate-900">{{ $siswa->alamat ?: '-' }}</p>
                    </div>

                    <div class="flex items-center gap-2">
                        <p class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Barcode</p>
                        <button type="button" id="download-barcode"
                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-slate-200 text-slate-600 hover:border-brand-200 hover:text-brand-700"
                            title="Download barcode">
                            <i class="fa-solid fa-download text-xs"></i>
                        </button>
                    </div>
                    <svg id="nisn-barcode" class="h-16 mt-1"></svg>

                </div>
            </div>
        </div>



        <div class="card-surface rounded-2xl p-6 ring-1 ring-slate-200">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Riwayat Kelas</h3>
                </div>
                <span class="text-[11px] font-semibold uppercase tracking-wide text-slate-500">Total:
                    {{ $history->count() }}</span>
            </div>

            @if ($history->isEmpty())
                <div class="flex items-center justify-center rounded-xl bg-slate-50 py-6 text-slate-500">
                    Belum ada riwayat kelas.
                </div>
            @else
                <div class="mt-3 overflow-x-auto max-h-72 overflow-y-auto">
                    <table class="min-w-full table-soft divide-y divide-slate-100">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left">Kelas</th>
                                <th class="px-4 py-3 text-left">Tahun Ajar</th>
                                <th class="px-4 py-3 text-left">Status</th>
                                <th class="px-4 py-3 text-left">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($history as $row)
                                <tr class="transition hover:bg-slate-50/60">
                                    <td class="px-4 py-3 font-semibold text-slate-900">{{ $row['kelas'] }}</td>
                                    <td class="px-4 py-3 text-slate-800">{{ $row['tahun'] }}</td>
                                    <td class="px-4 py-3 text-slate-800">
                                        <span
                                            class="rounded-full px-3 py-1 text-xs font-semibold {{ $row['status'] === 'aktif' ? 'bg-green-100 text-green-700 ring-1 ring-green-200' : 'bg-slate-100 text-slate-700 ring-1 ring-slate-200' }}">
                                            {{ \Illuminate\Support\Str::of($row['status'] ?? '-')->ucfirst() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-800">{{ $row['tanggal'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
    </div>


    <template x-teleport="body">
            @include('siswa.partials.edit-modal')
        </template>


    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const target = document.getElementById('nisn-barcode');
                const downloadBtn = document.getElementById('download-barcode');
                const value = @json($siswa->nisn);

                const renderBarcode = () => {
                    if (window.JsBarcode && target && value) {
                        JsBarcode(target, value, {
                            format: 'CODE128',
                            displayValue: true,
                            fontSize: 16,
                            height: 60,
                            margin: 0,
                        });
                    }
                };

                const downloadBarcode = () => {
                    if (!target || !value) return;
                    const serializer = new XMLSerializer();
                    const svgString = serializer.serializeToString(target);
                    const encoded = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgString)));
                    const bbox = target.getBBox ? target.getBBox() : null;
                    const width = Math.ceil((bbox?.width || target.clientWidth || 320));
                    const height = Math.ceil((bbox?.height || target.clientHeight || 80));

                    const img = new Image();
                    img.onload = () => {
                        const canvas = document.createElement('canvas');
                        canvas.width = width;
                        canvas.height = height;
                        const ctx = canvas.getContext('2d');
                        ctx.fillStyle = '#ffffff';
                        ctx.fillRect(0, 0, width, height);
                        ctx.drawImage(img, 0, 0, width, height);

                        const link = document.createElement('a');
                        link.href = canvas.toDataURL('image/png');
                        link.download = `barcode-${value}.png`;
                        link.click();
                    };
                    img.src = encoded;
                };

                renderBarcode();
                if (downloadBtn) {
                    downloadBtn.addEventListener('click', downloadBarcode);
                }
            });
        </script>
    @endpush

</x-app-layout>
