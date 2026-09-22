# Activity Manager (Modul 3 — Laravel Basic)

Aplikasi manajemen kegiatan harian berbasis web yang dibangun menggunakan **Laravel 13**, basis data **SQLite**, dan menerapkan prinsip arsitektur *Separation of Concerns* (Form Request, Service Layer, dan Eloquent Local Scope).

Proyek ini disusun untuk memenuhi lembar kerja praktikum **Modul 3: Laravel Basic**, Program Studi D3 Teknik Informatika.

---

## Prasyarat Sistem

* **PHP:** ^8.2 (diuji pada PHP 8.4)
* **Composer:** ^2.0
* **Ekstensi PHP:** `pdo_sqlite`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`
* **Git**

---

## Panduan Instalasi dan Menjalankan Proyek

Ikuti langkah-langkah berikut untuk menjalankan proyek dari repositori ini:

### 1. Klon Repositori
git clone https://github.com/FirdausSinau/Laravel-Basic---Modul-3.git
cd Laravel-Basic---Modul-3

### 2. Pasang Dependensi Composer
composer install

### 3. Konfigurasi Lingkungan (.env)
Salin berkas konfigurasi template:
cp .env.example .env

Pastikan konfigurasi koneksi basis data di berkas `.env` menggunakan SQLite:
DB_CONNECTION=sqlite

Generate kunci aplikasi:
php artisan key:generate

### 4. Migrasi dan Seeding Basis Data
Jalankan migrasi skema tabel beserta seeder untuk memuat data awal pengujian:
php artisan migrate:fresh --seed

*Perintah ini akan membuat tabel `activities` dan mengisi lima data dummy kegiatan awal melalui `ActivitySeeder`.*

### 5. Jalankan Server Pengembangan
php artisan serve

Akses aplikasi melalui peramban di: **http://127.0.0.1:8000/activities**

---

## Fitur Utama dan Arsitektur

1. **CRUD Kegiatan Lengkap & Route Model Binding:**
   * Pengelolaan data kegiatan (`Planned`, `Ongoing`, `Done`) dengan penanganan otomatis `404 Not Found` jika entitas tidak ditemukan.
2. **Validasi Formulir Berlapis (Form Request):**
   * Menggunakan `StoreActivityRequest` dan `UpdateActivityRequest` untuk menegakkan aturan BR-01 (judul 5–100 karakter), BR-02 (tanggal wajib diisi), dan BR-03 (whitelist status).
3. **Pemisahan Logika Bisnis (Service Layer):**
   * Transisi status dikendalikan oleh `ActivityService`. Status hanya dapat bergerak maju (`Planned` → `Ongoing` → `Done`) dan menolak transisi mundur menggunakan exception khusus domain.
4. **Penyaringan Data Cerdas (Local Query Scope):**
   * Fitur filter status via query string URL (`/activities?status=Planned`) diekstrak ke dalam local scope `scopeFilterStatus` pada Model `Activity`.
5. **Clean Code & Reusable Template:**
   * Formulir input disatukan menggunakan partial `resources/views/activities/_form.blade.php`.
   * Atribut `activity_date` dikonversi otomatis melalui method `casts(): array` pada model menjadi instance Carbon `date`.

---

## Daftar Endpoint Rute (Resource Routes)

| Metode HTTP | Endpoint URI | Nama Rute | Deskripsi |
| :--- | :--- | :--- | :--- |
| `GET` | `/activities` | `activities.index` | Daftar kegiatan (mendukung query filter `?status=...`) |
| `GET` | `/activities/create` | `activities.create` | Formulir tambah kegiatan baru |
| `POST` | `/activities` | `activities.store` | Menyimpan kegiatan baru ke basis data |
| `GET` | `/activities/{activity}` | `activities.show` | Rincian detail kegiatan tertentu |
| `GET` | `/activities/{activity}/edit` | `activities.edit` | Formulir ubah data dan transisi status |
| `PUT/PATCH` | `/activities/{activity}` | `activities.update` | Memperbarui kegiatan via `ActivityService` |
| `DELETE` | `/activities/{activity}` | `activities.destroy` | Menghapus satu data kegiatan |

---

## Penjaminan Mutu Kode (Code Quality & Static Analysis)

* **Code Styling (Laravel Pint):**
  Dijalankan untuk menjaga kepatuhan gaya kode:
  ./vendor/bin/pint

* **Static Analysis (SonarQube):**
  Dikonfigurasi melalui `sonar-project.properties` dengan `sonar.projectKey=activity-manager` untuk memantau *Maintainability Rating* (Grade A) dan mencegah *Cognitive Complexity* pada controller.