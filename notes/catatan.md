Tentu, ini adalah rancangan terstruktur dalam bentuk tabel yang sangat rinci untuk **Muhammadiyah Boarding School (MBS)**.

Sesuai permintaan:
1.  Fokus pada kejelasan dan struktur.
2.  **Halaman Utama** memuat 4 pilar utama (Berita, Acara, Galeri, Pengumuman).
3.  **Halaman Jenjang** (MTs, MA, SMK) juga memuat 4 pilar yang sama namun spesifik untuk jenjang tersebut.

---

### 1. STRUKTUR HALAMAN UTAMA (LANDING PAGE MBS)
*Konsep: "The Hub" - Gerbang utama yang merangkum semua kegiatan pondok.*

| Bagian (Section) | Komponen / Fitur | Detail Konten & Tampilan (Gaya Temasek) |
| :--- | :--- | :--- |
| **1. Header & Navigasi** | Menu Global | Logo MBS Besar, Menu (Profil, Pendidikan, Asrama, Pendaftaran), Pencarian, Bahasa. |
| **2. Hero Section** | Fullscreen Slider | Foto/Video Drone kawasan pondok kualitas tinggi. Teks: "Membangun Generasi Qur'ani Berkemajuan". Tombol "Jelajahi Kami". |
| **3. Navigasi Jenjang** | **3 Kartu Utama** | 3 Kotak Besar (Cards) dengan foto siswa masing-masing jenjang:<br>1. **MTs** (Klik lari ke halaman MTs)<br>2. **MA** (Klik lari ke halaman MA)<br>3. **SMK** (Klik lari ke halaman SMK) |
| **4. PENGUMUMAN (Pilar 1)** | Running Text / Alert | Baris notifikasi di atas atau bawah slider. <br>*Contoh: "Penerimaan Santri Baru Gelombang 1 Dibuka s/d 30 Desember."* |
| **5. BERITA TERBARU (Pilar 2)** | Grid Layout (Gabungan) | Menampilkan berita dari **SEMUA** jenjang (MTs+MA+SMK).<br>- Foto Thumbnail<br>- Label (Misal: "Berita SMK")<br>- Judul & Tanggal. |
| **6. AGENDA/ACARA (Pilar 3)** | Kalender / Timeline | Daftar agenda gabungan pondok.<br>*Contoh:* "Kajian Ahad Pagi (Umum)", "Wisuda Akbar (Gabungan)", "Libur Ramadhan". |
| **7. GALERI KEGIATAN (Pilar 4)** | Masonry / Slider | Foto-foto terbaik (Highlight) dari kegiatan pondok secara umum.<br>*Contoh:* Foto Sholat berjamaah, Makan bersama, Olahraga. |
| **8. Profil Singkat** | Text & Video | Sambutan Direktur MBS + Video Profil Pondok (Embed YouTube). |
| **9. Footer** | Informasi Statis | Alamat Lengkap, Peta Google Maps, Link Sosmed (IG, FB, YT), Hak Cipta. |

---

### 2. STRUKTUR HALAMAN PER JENJANG (KHUSUS MTs / MA / SMK)
*Konsep: "The Satellites" - Halaman spesifik yang lebih mendalam.*

| Bagian (Section) | Komponen / Fitur | Detail Konten Spesifik |
| :--- | :--- | :--- |
| **1. Header Sekolah** | Identitas Khusus | Logo Sekolah Spesifik (Misal: Logo SMK MBS). Menu berubah menjadi: Profil SMK, Jurusan, Guru, Kesiswaan. |
| **2. Banner Sekolah** | Foto Hero | Foto kegiatan belajar mengajar spesifik jenjang tersebut. |
| **3. PENGUMUMAN (Pilar 1)** | Papan Informasi | Pengumuman khusus jenjang ini.<br>*Contoh di SMK:* "Jadwal Ujian Kompetensi Keahlian (UKK) TKJ". |
| **4. Profil & Jurusan** | Info Akademik | **MTs:** Program Tahfidz & Reguler.<br>**MA:** Jurusan IPA / IPS / Keagamaan.<br>**SMK:** Jurusan TKJ / TSM / Farmasi (disertai ikon). |
| **5. BERITA SEKOLAH (Pilar 2)** | Filtered News | Hanya menampilkan berita jenjang ini saja.<br>*Contoh:* "Siswa SMK MBS Juara 1 LKS Provinsi". |
| **6. AGENDA SEKOLAH (Pilar 3)** | Filtered Events | Hanya menampilkan agenda jenjang ini.<br>*Contoh:* "Kunjungan Industri SMK", "Munaqosah Tahfidz MTs". |
| **7. Data Guru & Staff** | **Flexible Profile** | Foto Guru, Nama, Mapel. **Fitur Link:** Tombol ke Blog Guru, YouTube Guru, LinkedIn Guru (Bisa ditambah sesuka hati). |
| **8. GALERI SEKOLAH (Pilar 4)** | Album Foto | Dokumentasi kegiatan khusus jenjang ini (Praktik Lab, Kelas, Ekskul). |
| **9. Kurikulum** | Tabel & Download | Struktur kurikulum yang dipakai dan link download kalender akademik per sekolah. |
| **10. Call to Action** | Tombol Daftar | Tombol besar: "Daftar ke [Nama Jenjang] Sekarang". |

---

### 3. RANCANGAN DATABASE UNTUK MENGATUR "4 PILAR"
*Agar admin tidak kerja 2 kali (input sekali, muncul sesuai tempatnya).*

| Nama Tabel | Kolom Penting (Fields) | Fungsi Logika Sistem |
| :--- | :--- | :--- |
| `posts` (Berita) | `title`, `content`, `image`, `category_id` | `category_id` menentukan berita ini milik siapa (1=Umum, 2=MTs, 3=MA, 4=SMK). |
| `events` (Acara) | `event_name`, `date`, `location`, `school_id` | Jika `school_id` = MTs, hanya muncul di web MTs. Jika `school_id` = ALL, muncul di halaman utama. |
| `announcements` | `message`, `type`, `target_audience` | `target_audience` bisa dipilih: "Publik", "Wali Santri", "Internal Guru". |
| `galleries` | `photo_url`, `caption`, `tag` | Tag digunakan untuk memfilter galeri (misal: #pramuka, #smk, #asrama). |
| `teachers` | `name`, `photo`, `biodata`, **`custom_links`** | Kolom `custom_links` menyimpan data JSON agar guru bisa tempel banyak link sesuka hati. |

---

### 4. FITUR ADMIN (CMS GURU)
*Bagaimana Guru/Admin mengelola website dengan mudah.*

| Fitur | Kemampuan Admin | Contoh Penggunaan |
| :--- | :--- | :--- |
| **Post Manager** | Tambah Berita/Acara | Admin memilih kategori saat posting: "Ini berita untuk SMK". Maka otomatis tampil di Halaman Utama (sebagai gabungan) DAN Halaman SMK. |
| **Teacher Builder** | **Custom Fields** | Admin menambah kolom baru di profil guru.<br>*Contoh:* Tambah kolom "Judul Skripsi", "Hobi", atau "Link Google Scholar". |
| **Layout Manager** | Drag & Drop | Admin bisa mengatur urutan: "Saya mau Galeri di atas Berita" atau sebaliknya. |
| **Menu Manager** | Edit Menu Navigasi | Admin bisa menambah menu baru di navbar, misal: "Info PPDB" tanpa coding. |

Apakah struktur tabel ini sudah cukup jelas dan mudah dibaca untukmu? Jika sudah pas, kita bisa kunci konsep ini.