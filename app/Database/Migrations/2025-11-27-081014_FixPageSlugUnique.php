<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class FixPageSlugUnique extends Migration
{
    public function up()
    {
        // 1. Hapus Index Unique pada kolom 'slug' yang lama (Global)
        // Kita bungkus try-catch jaga-jaga kalau index namanya beda atau sudah dihapus
        try {
            $this->db->query("ALTER TABLE pages DROP INDEX slug");
        } catch (\Throwable $e) {
            // Lanjut jika index tidak ketemu
        }

        // 2. Buat Index Unique Baru (Kombinasi school_id + slug)
        // Artinya: Slug boleh sama, ASALKAN school_id-nya beda.
        // Contoh: 
        // - 'sejarah' + school_id 1 (MTs) -> OK
        // - 'sejarah' + school_id 2 (MA)  -> OK
        // - 'sejarah' + school_id 1 (MTs) -> ERROR (Duplicate)
        try {
            $this->db->query("ALTER TABLE pages ADD UNIQUE INDEX unique_page_per_school (slug, school_id)");
        } catch (\Throwable $e) {
            // Lanjut
        }
    }

    public function down()
    {
        // Kembalikan ke aturan lama (Hanya slug yang unik)
        try {
            $this->db->query("ALTER TABLE pages DROP INDEX unique_page_per_school");
            $this->db->query("ALTER TABLE pages ADD UNIQUE INDEX slug (slug)");
        } catch (\Throwable $e) {
            // Lanjut
        }
    }
}