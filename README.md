# SISMA – Sistem Informasi Siswa & Manajemen Akademik

Web app berbasis Laravel Breeze untuk mengelola data akademik sekolah: tahun ajar, jurusan, kelas, siswa (plus riwayat kelas), dan pengguna. Aplikasi sudah dilengkapi autentikasi, peran admin, upload foto siswa, serta antarmuka modern berbasis Tailwind + Vite.

## Fitur Utama
- **Dashboard ringkas**: ringkasan total siswa, jurusan, kelas, dan pengguna dengan shortcut tindakan cepat.
- **Manajemen Tahun Ajar**: CRUD periode akademik (kode & nama).
- **Manajemen Jurusan**: CRUD jurusan/bidang studi.
- **Manajemen Kelas**: CRUD kelas beserta level, jurusan, dan tahun ajar terkait.
- **Manajemen Siswa**: CRUD siswa lengkap (NISN, biodata, foto, jurusan, tahun ajar aktif, kelas aktif). Riwayat perpindahan kelas tercatat melalui `kelas_details` dengan status `aktif`/`nonaktif`.
- **Manajemen Pengguna**: CRUD user dengan kolom `role`; peran `admin` diperlukan untuk seluruh modul manajemen data.
- **Upload foto siswa**: disimpan di storage publik (`storage/app/public/fotos`).
- **Autentikasi Breeze**: login/register, reset password, proteksi CSRF, dan session bawaan Laravel 12.

## Arsitektur & Tumpukan Teknologi
- **Backend**: PHP 8.2, Laravel 12, Breeze (Blade + Vite).
- **Frontend**: Tailwind CSS, Font Awesome kit, Plus Jakarta Sans (CDN), SweetAlert2 untuk toast.
- **Database**: dukung semua driver Laravel; default menggunakan env Anda. Migrations tersedia untuk seluruh entitas.
- **Build tool**: Vite (lihat `package.json` dan `vite.config.js`).

## Model & Relasi Data
- `TahunAjar` — punya banyak `Kelas`, `Siswa`, `KelasDetail`.
- `Jurusan` — punya banyak `Kelas`, `Siswa`.
- `Kelas` — milik `TahunAjar` & `Jurusan`; punya banyak `KelasDetail`.
- `Siswa` — milik `Jurusan` & `TahunAjar`; punya banyak `KelasDetail` (riwayat kelas). Foto disimpan di `foto_path`.
- `KelasDetail` — pivot riwayat kelas siswa (`siswa_id`, `kelas_id`, `tahun_ajar_id`, `status`).
- `User` — memiliki kolom `role` (default `admin`). Middleware `admin` membatasi akses modul data.

## Alur Akses & Otorisasi
- Semua route berada dalam middleware `auth`. 
- CRUD Tahun Ajar, Jurusan, Kelas, Siswa, dan Pengguna dibatasi `admin` middleware (`role === 'admin'`).
- Jika user non-admin mencoba mengakses, akan diredirect ke dashboard dengan pesan error.

## Instalasi & Persiapan
1) **Kloning & dependensi**
```bash
composer install
npm install
```
2) **Environment**
```bash
cp .env.example .env
php artisan key:generate
```
Atur koneksi DB di `.env` (MySQL/Postgres/SQLite dsb). 

3) **Migrasi & storage link**
```bash
php artisan migrate
php artisan storage:link
```

4) **Build aset**
```bash
npm run dev   # atau npm run build untuk produksi
```

5) **Jalankan aplikasi**
```bash
php artisan serve
```

## Peran & Akun
- Kolom `users.role` default `admin`. Untuk membatasi akses, set nilai role ke `admin` atau role lain sesuai kebutuhan (middleware saat ini hanya mengizinkan `admin`).
- Daftarkan user lewat form register Breeze, lalu perbarui kolom `role` (via seeder/DB) untuk memberi hak admin.

## Pengelolaan Media
- Upload foto siswa disimpan di disk `public` (`storage/app/public/fotos`).
- Pastikan `php artisan storage:link` sudah dijalankan agar foto dapat diakses dari `/storage/fotos/...`.
- Batas ukuran file foto: 2 MB (validasi controller).

## Validasi Penting
- NISN unik pada tabel `siswas`.
- Relasi wajib: `jurusan_id`, `tahun_ajar_id`, `kelas_id` harus valid.
- Perpindahan kelas akan menonaktifkan entri `kelas_details` aktif sebelumnya dan membuat entri baru berstatus `aktif`.

## Perintah Pengembangan Berguna
- **Lint/Pint**: `vendor/bin/pint`
- **Tes**: `php artisan test`
- **Dev stack paralel (opsi di package.json script dev)**: `composer run dev` (menjalankan serve + queue:listen + vite via concurrently).

## Struktur Direktori Penting
- `app/Http/Controllers` — logika CRUD (Dashboard, TahunAjar, Jurusan, Kelas, Siswa, User).
- `app/Models` — definisi model & relasi.
- `resources/views` — Blade + komponen UI (Breeze), dashboard, halaman entitas.
- `database/migrations` — skema tabel & kolom `role` pada users.
- `storage/app/public/fotos` — penyimpanan foto siswa (pastikan symbolic link).

## Catatan UI
- Antarmuka menggunakan tema modern (glass, gradient) dengan Plus Jakarta Sans dan palet biru–cyan. Semua halaman utama (dashboard, list siswa, navigasi) sudah disesuaikan agar responsif dan siap dipakai di perangkat mobile/desktop.

## Lisensi
Proyek ini menggunakan Lisensi MIT (mengikuti lisensi Laravel). Silakan gunakan dan modifikasi sesuai kebutuhan.*** End Patch ***!
