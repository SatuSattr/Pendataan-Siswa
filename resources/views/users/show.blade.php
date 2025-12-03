<x-app-layout>
    <x-slot name="header">
        <x-page-header path="/users/show/{{ $user->name }}" title="Detail Pengguna" />
    </x-slot>

    <div class="space-y-6" x-data="userShowView()" @open-user-edit.window="openEditModal($event.detail)">
        <div
            class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-brand-50 via-white to-slate-50 p-6 ring-1 ring-slate-200">
            <div class="absolute -left-10 -top-10 h-40 w-40 rounded-full bg-brand-200/30 blur-2xl"></div>
            <div class="absolute -right-12 -bottom-16 h-48 w-48 rounded-full bg-indigo-100/40 blur-3xl"></div>

            <div class="relative flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
                <div>
                    <p class="text-xs font-semibold uppercase tracking-wide text-brand-700">Detail Pengguna</p>
                    <h1 class="mt-2 text-3xl font-bold text-slate-900">{{ $user->name }}</h1>
                    <p class="mt-1 text-sm text-slate-600">{{ $user->email }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <button type="button" class="btn-brand p-4 absolute right-0 top-0"
                        @click.prevent="$dispatch('open-user-edit', {
                            id: {{ $user->id }},
                            name: @js($user->name),
                            email: @js($user->email),
                            role: @js($user->role),
                        })">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </button>
                </div>
            </div>

            <div class="relative mt-5 flex flex-wrap gap-3">
                <span
                    class="inline-flex items-center gap-2 rounded-full bg-white/70 px-3 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                    <i class="fa-solid fa-envelope text-brand-600"></i> {{ $user->email }}
                </span>
                <span
                    class="inline-flex items-center gap-2 rounded-full bg-white/70 px-3 py-2 text-xs font-semibold text-slate-700 ring-1 ring-slate-200">
                    <i class="fa-solid fa-user-shield text-brand-600"></i> Role: {{ $user->role }}
                </span>
            </div>
        </div>

        <template x-teleport="body">
            @include('users.partials.edit-modal')
        </template>
    </div>

    @push('scripts')
        <script>
            function userShowView() {
                const emptyForm = {
                    id: null,
                    name: '',
                    email: '',
                    role: 'admin',
                };
                return {
                    showEditModal: false,
                    emptyForm,
                    editForm: {
                        ...emptyForm
                    },
                    updateActionBase: `{{ url('/users') }}`,
                    openEditModal(data) {
                        this.editForm = {
                            ...this.emptyForm,
                            ...data
                        };
                        this.showEditModal = true;
                        this.$nextTick(() => this.$refs.editNameInput?.focus());
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
