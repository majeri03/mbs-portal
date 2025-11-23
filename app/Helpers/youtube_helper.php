<?php

if (!function_exists('get_youtube_id')) {
    function get_youtube_id($url)
    {
        // Regex untuk mengambil ID dari berbagai format link YouTube
        $pattern = '%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i';
        if (preg_match($pattern, $url, $match)) {
            return $match[1];
        }
        return null;
    }
}

if (!function_exists('get_youtube_embed')) {
    function get_youtube_embed($url)
    {
        $id = get_youtube_id($url);
        if ($id) {
            return "https://www.youtube.com/embed/" . $id;
        }
        return $url; // Kembalikan apa adanya jika gagal parsing
    }
}