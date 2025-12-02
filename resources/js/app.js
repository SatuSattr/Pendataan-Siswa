import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

const siswaPanel = ({ options, oldMode, oldForm, hasErrors, routes }) => ({
    options,
    routes,
    panelOpen: false,
    mode: 'create',
    formAction: routes.store,
    form: {
        id: null,
        nama: '',
        nisn: '',
        tanggal_lahir: '',
        jenis_kelamin: '',
        alamat: '',
        jurusan_id: '',
        kelas_id: '',
        tahun_ajar_id: '',
        foto_url: null,
    },
    init() {
        if (hasErrors && oldMode) {
            if (oldMode === 'edit') {
                this.openEdit(oldForm, false);
            } else {
                this.openCreate(false);
                Object.assign(this.form, oldForm);
            }
            this.panelOpen = true;
        }
    },
    handlePanelEvent(detail) {
        if (detail?.mode === 'edit' && detail.data) {
            this.openEdit(detail.data);
        } else {
            this.openCreate();
        }
    },
    openCreate(showPanel = true) {
        this.mode = 'create';
        this.formAction = this.routes.store;
        this.form = {
            id: null,
            nama: '',
            nisn: '',
            tanggal_lahir: '',
            jenis_kelamin: '',
            alamat: '',
            jurusan_id: '',
            kelas_id: '',
            tahun_ajar_id: '',
            foto_url: null,
        };
        if (showPanel) this.panelOpen = true;
    },
    openEdit(data, showPanel = true) {
        this.mode = 'edit';
        this.formAction = `${this.routes.updateBase}/${data.id}`;
        this.form = {
            id: data.id ?? null,
            nama: data.nama ?? '',
            nisn: data.nisn ?? '',
            tanggal_lahir: data.tanggal_lahir ?? '',
            jenis_kelamin: data.jenis_kelamin ?? '',
            alamat: data.alamat ?? '',
            jurusan_id: data.jurusan_id ?? '',
            kelas_id: data.kelas_id ?? '',
            tahun_ajar_id: data.tahun_ajar_id ?? '',
            foto_url: data.foto_url ?? null,
        };
        if (showPanel) this.panelOpen = true;
    },
    closePanel() {
        this.panelOpen = false;
    },
});

Alpine.data('siswaPanel', siswaPanel);

Alpine.start();
