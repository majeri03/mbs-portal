<?php
if (!function_exists('upload_and_resize_image')) {
    /**
     * Upload dan resize gambar dengan smart fallback (ImageMagick → GD → Skip)
     */
    function upload_and_resize_image($file, string $uploadPath, int $maxWidth = 1024, int $quality = 80): ?string
    {
        if (!$file->isValid() || $file->hasMoved()) {
            return null;
        }

        $fullPath = FCPATH . $uploadPath;
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0755, true);
        }

        $fileName = $file->getRandomName();
        $file->move($fullPath, $fileName);
        $filePath = $fullPath . $fileName;

        $resized = false;
        
        // Try ImageMagick
        if (extension_loaded('imagick')) {
            try {
                $image = \Config\Services::image('imagick');
                $image->withFile($filePath)
                    ->resize($maxWidth, $maxWidth, true, 'width')
                    ->save($filePath, $quality);
                $resized = true;
                log_message('debug', "Image resized with ImageMagick: {$fileName}");
            } catch (\Exception $e) {
                log_message('warning', 'ImageMagick failed: ' . $e->getMessage());
            }
        }
        
        // Fallback to GD
        if (!$resized && extension_loaded('gd')) {
            try {
                $image = \Config\Services::image('gd');
                $image->withFile($filePath)
                    ->resize($maxWidth, $maxWidth, true, 'width')
                    ->save($filePath, $quality);
                $resized = true;
                log_message('debug', "Image resized with GD: {$fileName}");
            } catch (\Exception $e) {
                log_message('warning', 'GD failed: ' . $e->getMessage());
            }
        }
        
        if (!$resized) {
            log_message('info', "Image uploaded without resize: {$fileName}");
        }

        return $fileName;
    }
}
if (!function_exists('get_image_url')) {
    /**
     * Get proper image URL - handle both external URLs and local paths
     * 
     * @param string|null $path Image path or URL
     * @param string $default Default image URL if path is empty
     * @return string
     */
    function get_image_url(?string $path, string $default = ''): string
    {
        // Jika kosong, return default
        if (empty($path)) {
            return $default;
        }
        
        // Jika sudah URL lengkap (http/https), return langsung
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }
        
        // Jika path lokal, tambahkan base_url()
        return base_url($path);
    }
}