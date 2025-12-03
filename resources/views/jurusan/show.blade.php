<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/jurusan/show/{{ $jurusan->nama_jurusan }}" title="Detail Jurusan" />
    </x-slot>

    <div class="space-y-6" x-data="jurusanShowView()" @open-jurusan-edit.window="openEditModal($event.detail)">
        <div
            class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-50 via-white to-slate-50 p-6 ring-1 ring-slate-200">
            <div class="absolute -left-10 -top-10 h-40 w-40 rounded-full bg-brand-200/30 blur-2xl"></div>
            <div class="absolute -right-12 -bottom-16 h-48 w-48 rounded-full bg-indigo-100/40 blur-3xl"></div>

            <div class="relative flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-brand-700">Detail Jurusan</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $jurusan->nama_jurusan }}</h1>
                    <p class="mt-1 text-sm text-slate-600">Informasi kode jurusan dan ringkasan kelas terkait.</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" class="btn-brand p-4 absolute right-0 top-0"
                        @click.prevent="$dispatch('open-jurusan-edit', {
                            id: {{ $jurusan->id }},
                            kode_jurusan: @js($jurusan->kode_jurusan),
                            nama_jurusan: @js($jurusan->nama_jurusan),
                        })">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                </div>
            </div>

            <div class="relative mt-5 flex flex-wrap gap-3">
                <span
                    class="inline-flex items-center gap-2 rounded-full bg-white/70 px-3 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                    <i class="fa-solid fa-diagram-project text-brand-600"></i> Kode: {{ $jurusan->kode_jurusan }}
                </span>
                <span
                    class="inline-flex items-center gap-2 rounded-full bg-white/70 px-3 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                    <i class="fa-solid fa-layer-group text-brand-600"></i> {{ $jurusan->kelas()->count() }} kelas
                </span>
            </div>
        </div>

        <div class="card-surface rounded-2xl p-6 ring-1 ring-slate-100">
            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h3 class="text-lg font-semibold text-slate-900">Kelas di Jurusan Ini</h3>
                    <p class="text-sm text-slate-500">Daftar kelas terkait jurusan beserta jumlah siswa aktif.</p>
                </div>
            </div>
            @php
                $kelasList = $jurusan
                    ->kelas()
                    ->with('tahunAjar')
                    ->withCount([
                        'kelasDetails as siswa_aktif_count' => function ($q) {
                            $q->where('status', 'aktif');
                        },
                    ])
                    ->orderBy('nama_kelas')
                    ->get();
            @endphp
            @if ($kelasList->isEmpty())
                <div
                    class="mt-4 rounded-xl border border-dashed border-slate-200 bg-slate-50/60 px-4 py-6 text-center text-sm text-slate-500">
                    Belum ada kelas pada jurusan ini.
                </div>
            @else
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full table-soft divide-y divide-slate-100">
                        <thead>
                            <tr>
                                <th class="px-4 py-3 text-left">Nama Kelas</th>
                                <th class="px-4 py-3 text-left">Level</th>
                                <th class="px-4 py-3 text-left">Tahun Ajar</th>
                                <th class="px-4 py-3 text-left">Siswa Aktif</th>
                                <th class="px-4 py-3 text-left">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach ($kelasList as $kelasItem)
                                <tr class="transition hover:bg-slate-50/60">
                                    <td class="px-4 py-3 font-semibold text-slate-800">{{ $kelasItem->nama_kelas }}</td>
                                    <td class="px-4 py-3 text-slate-800">{{ $kelasItem->level_kelas }}</td>
                                    <td class="px-4 py-3 text-slate-800">
                                        {{ $kelasItem->tahunAjar->kode_tahun_ajar ?? '-' }}</td>
                                    <td class="px-4 py-3 text-slate-800">
                                        <span
                                            class="inline-flex min-w-[3ch] justify-start font-semibold text-slate-900">
                                            {{ $kelasItem->siswa_aktif_count }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-800">
                                        <div class="flex items-center gap-3">
                                            <a href="{{ route('kelas.show', $kelasItem) }}"
                                                class="text-brand-600 hover:text-brand-700" title="Detail">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('kelas.edit', $kelasItem) }}"
                                                class="text-sky-600 hover:text-sky-700" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form action="{{ route('kelas.destroy', $kelasItem) }}" method="POST"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-rose-600 hover:text-rose-700"
                                                    onclick="return confirm('Hapus kelas ini?')" title="Hapus">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <template x-teleport="body">
            @include('jurusan.partials.edit-modal')
        </template>
    </div>

    @push('scripts')
        <script>
            function jurusanShowView() {
                const emptyForm = {
                    id: null,
                    kode_jurusan: '',
                    nama_jurusan: '',
                };

                return {
                    showEditModal: false,
                    emptyForm,
                    editForm: {
                        ...emptyForm
                    },
                    updateActionBase: `{{ url('/jurusan') }}`,
                    openEditModal(data) {
                        this.editForm = {
                            ...this.emptyForm,
                            ...data
                        };
                        this.showEditModal = true;
                        this.$nextTick(() => this.$refs.editKodeInput?.focus());
                    },
                    closeEditModal() {
                        this.showEditModal = false;
                        setTimeout(() => {
                            this.editForm = {
                                ...this.emptyForm
                            };
                        }, 200);
                    },
                };
            }
        </script>
    @endpush
</x-app-layout>
