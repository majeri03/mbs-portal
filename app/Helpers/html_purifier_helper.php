<?php

if (!function_exists('clean_content')) {
    /**
     * Membersihkan HTML dari script berbahaya tapi membolehkan formatting Summernote.
     */
    function clean_content($dirty_html)
    {
        // Daftar tag yang diizinkan (Tag standar Summernote)
        $allowed_tags = '<p><br><b><i><u><strong><em><ul><ol><li><img><a><table><thead><tbody><tr><td><th><blockquote><h1><h2><h3><h4><h5><h6><div><span><hr>';
        
        // 1. Strip tags yang tidak ada di daftar whitelist
        $clean = strip_tags($dirty_html, $allowed_tags);

        // 2. Hapus atribut berbahaya (onmouseover, onclick, javascript:)
        // Ini regex sederhana untuk membuang event handler javascript
        $clean = preg_replace('/(<[^>]+) on[a-z]+="[^"]*"/i', '$1', $clean);
        $clean = preg_replace('/javascript:/i', '', $clean);

        return $clean;
    }
}