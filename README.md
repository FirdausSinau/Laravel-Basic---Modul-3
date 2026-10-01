# Activity Manager

Aplikasi manajemen kegiatan berbasis web menggunakan **Laravel 13** dan **SQLite**, dengan pemisahan tanggung jawab antara Form Request, Service Layer, Controller, dan Model.

Proyek ini merupakan kelanjutan **Modul 3: Laravel Basic** ke **Modul 3 Special Challenge: Advanced CRUD dan Data Integrity**.

---

## Prasyarat

* PHP ^8.2 (diuji pada PHP 8.4)
* Composer ^2.0
* Ekstensi: `pdo_sqlite`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`

---

## Instalasi

```bash
git clone https://github.com/FirdausSinau/Laravel-Basic---Modul-3.git
cd Laravel-Basic---Modul-3
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Akses aplikasi di **http://127.0.0.1:8000/activities**.

Seeding mengisi **4 kategori** dan **16 kegiatan** dengan tiga status, termasuk beberapa data yang disiapkan khusus sebagai fixture pengujian (kegiatan tanpa lokasi, kegiatan berkapasitas kecil, dan kegiatan yang sudah dimulai).

> Seeder kegiatan tidak idempoten. Gunakan `migrate:fresh --seed`, bukan `db:seed` berulang.

---

## Fitur Utama

**Relational CRUD**
Kegiatan terhubung ke kategori melalui foreign key. Kategori yang masih dipakai tidak dapat dihapus, dijaga dua lapis: pemeriksaan di aplikasi dan `restrictOnDelete()` di database.

**Business Rule dan Transisi Status**
Status hanya bergerak satu arah: `Draft → Published → Completed`. Perubahan status tidak tersedia di form edit umum, melainkan melalui aksi terpisah yang memanggil `ActivityService`. Publikasi hanya berhasil bila seluruh field wajib telah lengkap.

**Search, Filter, Sort, dan Pagination**
Pencarian berdasarkan kode atau judul, filter kategori dan status, pengurutan berdasarkan tanggal, serta pagination yang mempertahankan parameter aktif melalui `withQueryString()`.

**Data Lifecycle**
Penghapusan kegiatan menggunakan soft delete. Halaman **Data Terhapus** menyediakan aksi pulihkan tanpa kehilangan data relasi maupun poster.

**Atomic Registration**
Pendaftaran peserta hanya untuk kegiatan `Published` yang belum dimulai dan kapasitasnya masih tersedia. Email unik per kegiatan, dijaga validasi dan unique index. Pembuatan pendaftaran dan penambahan `registered_count` dijalankan dalam satu transaction.

**Poster Kegiatan**
Poster opsional (maks. 2 MB) disimpan melalui Laravel Storage; yang tersimpan di database hanya path-nya. Saat poster diganti, file lama dihapus setelah file baru berhasil tersimpan.

---

## Daftar Rute

| Metode | URI | Nama | Keterangan |
| :--- | :--- | :--- | :--- |
| `GET` | `/activities` | `activities.index` | Daftar kegiatan + search, filter, sort, pagination |
| `GET` | `/activities/create` | `activities.create` | Formulir tambah kegiatan |
| `POST` | `/activities` | `activities.store` | Simpan kegiatan baru |
| `GET` | `/activities/trash` | `activities.trash` | Daftar kegiatan terhapus |
| `GET` | `/activities/{activity}` | `activities.show` | Detail kegiatan + form pendaftaran |
| `GET` | `/activities/{activity}/edit` | `activities.edit` | Formulir ubah kegiatan |
| `PUT/PATCH` | `/activities/{activity}` | `activities.update` | Perbarui kegiatan |
| `DELETE` | `/activities/{activity}` | `activities.destroy` | Soft delete kegiatan |
| `PATCH` | `/activities/{activity}/publish` | `activities.publish` | Ubah status Draft → Published |
| `PATCH` | `/activities/{activity}/complete` | `activities.complete` | Ubah status Published → Completed |
| `PATCH` | `/activities/{id}/restore` | `activities.restore` | Pulihkan kegiatan terhapus |
| `POST` | `/activities/{activity}/registrations` | `registrations.store` | Daftarkan peserta |
| `GET` | `/categories` | `categories.index` | Daftar kategori + jumlah kegiatan |
| `DELETE` | `/categories/{category}` | `categories.destroy` | Hapus kategori kosong |

---

## Checkpoint

| Checkpoint | Tag |
| :--- | :--- |
| CRUD dasar | `modul3-crud-baseline` |
| Task 1 — Relational CRUD dan Integrity | `modul3-special-task1` |
| Task 2 — Business Rule dan Query Experience | `modul3-special-task2` |
| Task 3 — Data Lifecycle dan Query Quality | `modul3-special-task3` |
| Add-On — Poster Storage | `modul3-special-final` |

---

## Kualitas Kode

```bash
./vendor/bin/pint          # gaya kode
./vendor/bin/pint --test   # periksa tanpa mengubah
```

Analisis statis dikonfigurasi melalui `sonar-project.properties` (`sonar.projectKey=activity-manager`). Catatan temuan dan refaktorisasi ada pada worksheet.
