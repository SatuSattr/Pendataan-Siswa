<div x-cloak x-show="showModal" class="fixed inset-0 z-[90] flex items-center  justify-center px-4" role="dialog"
    aria-modal="true">
    <div class="absolute inset-0 bg-slate-900/50 backdrop-blur-sm" @click="closeModal()"></div>

    <div x-show="showModal" x-transition
        class="relative w-full max-w-2xl rounded-2xl bg-white max-h-screen p-6 shadow-2xl ring-1 ring-slate-200">
        <button type="button"
            class="absolute right-6 top-6 z-20 flex items-center rounded-xl border p-3 border-slate-200 text-slate-700 hover:border-brand-300 hover:text-brand-700"
            @click="typeof closeModal === 'function' ? closeModal() : null">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="relative">
            <div class="flex flex-col gap-6 w-full md:flex-row md:items-start md:gap-6">
                <div class="flex justify-center md:justify-start">
                    <template x-if="selected?.foto">
                        <div
                            class="h-96 w-72 bg-gradient-to-br from-gray-50 to-slate-200 overflow-hidden ring-1 ring-slate-200 rounded-xl">
                            <img :src="selected.foto" :alt="'Foto ' + (selected?.nama || '')"
                                class="h-full w-full object-cover">
                        </div>
                    </template>
                    <template x-if="!selected?.foto">
                        <div
                            class="h-96 w-72 p-4 pb-0 bg-gradient-to-br flex items-center justify-center from-gray-50 to-slate-200 overflow-hidden ring-1 ring-slate-200 rounded-xl">
                            <i class="fa-regular fa-user text-2xl text-slate-400 "></i>
                        </div>
                    </template>
                </div>
                <div class="gap-3 flex-col flex md:flex-1">
                    <div class="mb-2 text-center md:text-left">
                        <p class="text-xl font-bold text-slate-900" x-text="selected?.nama || '-'"></p>
                        <span class="font-semibold" x-text="selected?.kelas || '-'"></span>
                    </div>

                    <div class="flex flex-col gap-3">
                        <div>
                            <p class="text-sm font-semibold text-slate-600">Jurusan</p>
                            <p class="font-semibold text-slate-900" x-text="selected?.jurusan || '-'"></p>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-600">Jenis Kelamin</p>
                            <p class="font-semibold text-slate-900"
                                x-text="selected?.jenis_kelamin === 'L' ? 'Laki-laki' : (selected?.jenis_kelamin === 'P' ? 'Perempuan' : '-')">
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-600">Tanggal Lahir</p>
                            <p class="font-semibold text-slate-900" x-text="selected?.tanggal_lahir || '-'">
                            </p>
                        </div>

                        <div>
                            <p class="text-sm font-semibold text-slate-600">Alamat</p>
                            <p class="font-semibold text-slate-900" x-text="selected?.alamat"></p>
                        </div>
                    </div>

                    <div class="flex justify-center md:justify-start">
                        <svg x-ref="barcode" class="h-20 mt-2"></svg>
                    </div>

                </div>
            </div>

            <div class="mt-6 p-6 card-surface rounded-2xl ">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-base font-semibold text-slate-900">Riwayat Kelas</h4>
                </div>
                <div class="overflow-x-auto max-h-28 overflow-y-auto">
                    <table class="table-soft w-full divide-slate-100">
                        <thead>
                            <tr>
                                <th class="px-3 py-2 text-left">Kelas</th>
                                <th class="px-3 py-2 text-left">Tahun Ajar</th>
                                <th class="px-3 py-2 text-left">Status</th>
                                <th class="px-3 py-2 text-left">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <template x-if="selectedHistory.length === 0">
                                <tr>
                                    <td colspan="4" class="px-3 py-4 text-center text-slate-500">Belum ada
                                        riwayat kelas.</td>
                                </tr>
                            </template>
                            <template x-for="(row, index) in selectedHistory" :key="index">
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-3 py-2 font-semibold text-slate-800" x-text="row.kelas">
                                    </td>
                                    <td class="px-3 py-2 text-slate-800" x-text="row.tahun"></td>
                                    <td class="px-3 py-2 text-slate-800">
                                        <span class="px-2 py-1 rounded-full text-xs"
                                            :class="row.status === 'aktif' ? 'bg-green-100 text-green-700' :
                                                'bg-slate-100 text-slate-700'">
                                            <span
                                                x-text="row.status ? row.status.charAt(0).toUpperCase() + row.status.slice(1) : '-'"></span>
                                        </span>
                                    </td>
                                    <td class="px-3 py-2 text-slate-800" x-text="row.tanggal || '-'"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>
    </div>
