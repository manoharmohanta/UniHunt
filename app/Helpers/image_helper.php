<?php

if (!function_exists('upload_and_convert_webp')) {
    /**
     * Uploads an image and converts it to WebP if possible.
     * 
     * @param \CodeIgniter\HTTP\Files\UploadedFile $file The uploaded file object
     * @param string $path Target directory relative to WRITEPATH or public path
     * @param int $quality WebP quality (0-100)
     * @return string|false The path to the new image or false on failure
     */
    function upload_and_convert_webp($file, $path, $quality = 80)
    {
        if (!$file->isValid() || $file->hasMoved()) {
            return false;
        }

        // Ensure directory exists
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        // Generate random name without extension
        $name = pathinfo($file->getRandomName(), PATHINFO_FILENAME);
        $tempPath = $file->getTempName();

        // Check for WebP support
        $gdInfo = gd_info();
        $webpSupport = $gdInfo['WebP Support'] ?? false;

        if ($webpSupport) {
            $newName = $name . '.webp';
            $destination = $path . '/' . $newName;

            try {
                // Using CI4 Image Manipulation
                \Config\Services::image()
                    ->withFile($tempPath)
                    ->convert(IMAGETYPE_WEBP)
                    ->save($destination, $quality);

                return $destination;
            } catch (\Exception $e) {
                // Fallback to normal upload if conversion fails
                $newName = $file->getRandomName();
                $file->move($path, $newName);
                return $path . '/' . $newName;
            }
        } else {
            // No WebP support, move original
            $newName = $file->getRandomName();
            $file->move($path, $newName);
            return $path . '/' . $newName;
        }
    }
}

if (!function_exists('convert_file_to_webp')) {
    /**
     * Converts an existing file to WebP and deletes the original.
     * 
     * @param string $filePath Full path to the file
     * @param int $quality WebP quality
     * @return string The path to the new webp file (or original if failed)
     */
    function convert_file_to_webp($filePath, $quality = 80)
    {
        if (!file_exists($filePath))
            return $filePath;

        $gdInfo = gd_info();
        if (!($gdInfo['WebP Support'] ?? false))
            return $filePath;

        $pathInfo = pathinfo($filePath);
        if (strtolower($pathInfo['extension']) === 'webp')
            return $filePath;

        $newPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '.webp';

        try {
            \Config\Services::image()
                ->withFile($filePath)
                ->convert(IMAGETYPE_WEBP)
                ->save($newPath, $quality);

            // Delete original
            unlink($filePath);
            return $newPath;
        } catch (\Exception $e) {
            return $filePath;
        }
    }
}
