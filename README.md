# Dokumentasi Proyek

## 1. Pendahuluan

Proyek ini adalah hasil dari tes Junior Programmer untuk mengambil data dari API, menyimpannya ke database, dan menampilkannya dalam bentuk aplikasi web dengan fitur CRUD (Create, Read, Update, Delete). Proyek ini dibangun menggunakan framework **CodeIgniter 4** dan menggunakan database **MySQL**.

## 2. Teknologi yang Digunakan

- **Framework**: Codeigniter 4
- **Database**: MySQL
- **PHP Version**: PHP 8.2.12
- **Libraries/Tools Tambahan**:
  - JQuery (Javascript Library, untuk membantu membuat website yang interaktif)
  - Bootstrap 5 (untuk tampilan)
  - CI4 CURLRequest
  - CI4 SQL ORM (untuk berinteraksi dengan database MySQL)

## 3. Langkah Intsalasi

Panduan untuk menjalankan proyek di mesin lokal.

#### Clone Repository

```bash
git clone <URL_REPOSITORY>
cd <NAMA_FOLDER_PROYEK>
```

#### Import Database

Lakukan import database dengan menggunakan file SQL yang ada di dalam folder root proyek, nama file SQL-nya adalah "fastprint_cyro_dump.sql". Langkah-langkah:

1. Buka phpMyAdmin atau tool database pilihan Anda.
2. Buat database baru, misalnya dengan nama fastprint.
3. Import file "fastprint_cyro_dump.sql" ke dalam database tersebut.

#### Konfigurasi File .env

1. Duplikat file env dan beri nama .env.
2. Sesuaikan konfigurasi database di dalam file .env:

```env
database.default.hostname = <YOUR_LOCALHOST>
database.default.database = <YOUR_DATABASE>
database.default.username = <YOUR_USERNAME>
database.default.password = <YOUR_PASSWORD>
database.default.DBDriver = <YOUR_DBDRIVER>
```

#### Instalasi Dependency

Pastikan Anda telah menginstal Composer. Jalankan perintah berikut:

```bash
composer install
```

#### Menjalankan Proyek

Untuk menjalankan server lokal, gunakan perintah berikut:

```bash
php spark serve
```

Akses aplikasi melalui browser di http://localhost:8080.

## 4. Fitur Aplikasi

- **Pengambilan Data API**: Data produk diambil dari API dan disimpan ke database.
- **Menampilkan Produk**: Menampilkan daftar produk dari database yang memiliki status "Bisa Dijual", "Tidak Bisa Dijual", dan "Semua Status".
- **CRUD Produk**:
  - **Create**: Menambahkan produk baru ke database dengan validasi form.
  - **Update**: Mengedit informasi produk yang sudah ada.
  - **Delete**: Menghapus produk dengan konfirmasi terlebih dahulu.
- **Validasi**: Form validasi memastikan input nama tidak kosong dan harga adalah angka.

## 5. Struktur Database

#### Tabel product

# Dokumentasi Proyek

## 1. Pendahuluan

Proyek ini adalah hasil dari tes Junior Programmer untuk mengambil data dari API, menyimpannya ke database, dan menampilkannya dalam bentuk aplikasi web dengan fitur CRUD (Create, Read, Update, Delete). Proyek ini dibangun menggunakan framework **CodeIgniter 4** dan menggunakan database **MySQL**.

## 2. Teknologi yang Digunakan

- **Framework**: Codeigniter 4
- **Database**: MySQL
- **PHP Version**: PHP 8.2.12
- **Libraries/Tools Tambahan**:
  - JQuery (Javascript Library, untuk membantu membuat website yang interaktif)
  - Bootstrap 5 (untuk tampilan)
  - CI4 CURLRequest
  - CI4 SQL ORM (untuk berinteraksi dengan database MySQL)

## 3. Langkah Intsalasi

Panduan untuk menjalankan proyek di mesin lokal.

#### Clone Repository

```bash
git clone <URL_REPOSITORY>
cd <NAMA_FOLDER_PROYEK>
```

#### Import Database

Lakukan import database dengan menggunakan file SQL yang ada di dalam folder root proyek, nama file SQL-nya adalah "fastprint_cyro_dump.sql". Langkah-langkah:

1. Buka phpMyAdmin atau tool database pilihan Anda.
2. Buat database baru, misalnya dengan nama fastprint.
3. Import file "fastprint_cyro_dump.sql" ke dalam database tersebut.

#### Konfigurasi File .env

1. Duplikat file env dan beri nama .env.
2. Sesuaikan konfigurasi database di dalam file .env:

```env
database.default.hostname = <YOUR_LOCALHOST>
database.default.database = <YOUR_DATABASE>
database.default.username = <YOUR_USERNAME>
database.default.password = <YOUR_PASSWORD>
database.default.DBDriver = <YOUR_DBDRIVER>
```

#### Instalasi Dependency

Pastikan Anda telah menginstal Composer. Jalankan perintah berikut:

```bash
composer install
```

#### Menjalankan Proyek

Untuk menjalankan server lokal, gunakan perintah berikut:

```bash
php spark serve
```

Akses aplikasi melalui browser di http://localhost:8080.

## 4. Fitur Aplikasi

- **Pengambilan Data API**: Data produk diambil dari API dan disimpan ke database.
- **Menampilkan Produk**: Menampilkan daftar produk dari database yang memiliki status "Bisa Dijual", "Tidak Bisa Dijual", dan "Semua Status".
- **CRUD Produk**:
  - **Create**: Menambahkan produk baru ke database dengan validasi form.
  - **Update**: Mengedit informasi produk yang sudah ada.
  - **Delete**: Menghapus produk dengan konfirmasi terlebih dahulu.
- **Validasi**: Form validasi memastikan input nama tidak kosong dan harga adalah angka.

## 5. Struktur Database

#### Tabel product

| Kolom         | Tipe Data       | Keterangan                    |
| ------------- | --------------- | ----------------------------- |
| product_id    | Varchar(40)(PK) | Primary Key                   |
| product_name  | Varchar(255)    | Nama produk (unique key)      |
| product_price | Decimal         | Harga produk                  |
| category_id   | Varchar(40)(FK) | Foreign Key ke tabel Kategori |
| status_id     | Varchar(40)(FK) | Foreign Key ke tabel Status   |

#### Tabel Kategori

| Kolom         | Tipe Data       | Keterangan    |
| ------------- | --------------- | ------------- |
| category_id   | Varchar(40)(PK) | Primary Key   |
| category_name | Varchar(255)    | Nama kategori |

#### Tabel Status

| Kolom       | Tipe Data       | Keterangan  |
| ----------- | --------------- | ----------- |
| status_id   | Varchar(40)(PK) | Primary Key |
| status_name | Varchar(100)    | Nama status |

## 6. Cara Penggunaan

#### Akses Data Produk

1. Buka aplikasi di browser: `http://127.0.0.1:8000`.
2. Data produk yang "bisa dijual" bisa dipilih dengan mengaktifkan filter yang tersedia.

#### Tambah Produk

1. Klik tombol **Tambah Produk**, maka akan muncul modal.
2. Isi form dengan nama produk, harga, kategori, dan status.
3. Klik **Simpan**.

#### Edit Produk

1. Klik tombol **Edit** di baris produk yang ingin diubah.
2. Ubah data di form dan klik **Simpan**.

#### Hapus Produk

1. Klik tombol **Hapus**.
2. Konfirmasi penghapusan di popup yang muncul.

