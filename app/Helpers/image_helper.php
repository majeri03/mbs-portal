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