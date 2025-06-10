<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ImageService
{
    protected $targetSize = 1048576; // 1MB in bytes
    protected $maxDimension = 2000;
    protected $minQuality = 30;
    protected $maxQuality = 90;

    public function compressAndSaveImage($file, $path)
    {
        // Get image info
        $info = getimagesize($file->getPathname());
        if ($info === false) {
            throw new \Exception('Invalid image file');
        }

        // Create image resource based on file type
        switch ($info[2]) {
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($file->getPathname());
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($file->getPathname());
                break;
            default:
                throw new \Exception('Unsupported image type');
        }

        // Calculate new dimensions if needed
        $width = $info[0];
        $height = $info[1];
        
        if ($width > $this->maxDimension || $height > $this->maxDimension) {
            if ($width > $height) {
                $newWidth = $this->maxDimension;
                $newHeight = intval($height * ($this->maxDimension / $width));
            } else {
                $newHeight = $this->maxDimension;
                $newWidth = intval($width * ($this->maxDimension / $height));
            }

            // Create new image with new dimensions
            $newImage = imagecreatetruecolor($newWidth, $newHeight);
            
            // Handle transparency for PNG
            if ($info[2] === IMAGETYPE_PNG) {
                imagealphablending($newImage, false);
                imagesavealpha($newImage, true);
                $transparent = imagecolorallocatealpha($newImage, 255, 255, 255, 127);
                imagefilledrectangle($newImage, 0, 0, $newWidth, $newHeight, $transparent);
            }

            imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            $image = $newImage;
        }

        // Generate hashed name
        $hashedName = $file->hashName();
        $fullPath = public_path($path . '/' . $hashedName);

        // Ensure directory exists
        if (!file_exists(dirname($fullPath))) {
            mkdir(dirname($fullPath), 0777, true);
        }

        // Find optimal quality
        $quality = $this->findOptimalQuality($image, $info[2]);

        // Save the image
        if ($info[2] === IMAGETYPE_JPEG) {
            imagejpeg($image, $fullPath, $quality);
        } else {
            // For PNG, quality is from 0-9, so we need to map it
            $pngQuality = intval(9 - (($quality / 100) * 9));
            imagepng($image, $fullPath, $pngQuality);
        }

        // Free memory
        imagedestroy($image);

        return [
            'original_name' => $file->getClientOriginalName(),
            'hashed_name' => $hashedName
        ];
    }

    protected function findOptimalQuality($image, $type)
    {
        $low = $this->minQuality;
        $high = $this->maxQuality;
        $lastSize = 0;
        $lastQuality = 0;

        while ($low <= $high) {
            $mid = (int)(($low + $high) / 2);
            
            // Create temporary file
            $tempPath = tempnam(sys_get_temp_dir(), 'img');
            
            // Save with current quality
            if ($type === IMAGETYPE_JPEG) {
                imagejpeg($image, $tempPath, $mid);
            } else {
                $pngQuality = intval(9 - (($mid / 100) * 9));
                imagepng($image, $tempPath, $pngQuality);
            }
            
            $size = filesize($tempPath);
            unlink($tempPath);

            // If size is within 50KB of target, use this quality
            if (abs($size - $this->targetSize) < 51200) {
                return $mid;
            }

            // Save best quality that produces file under target size
            if ($size < $this->targetSize && $size > $lastSize) {
                $lastSize = $size;
                $lastQuality = $mid;
            }

            if ($size > $this->targetSize) {
                $high = $mid - 1;
            } else {
                $low = $mid + 1;
            }
        }

        return $lastQuality > 0 ? $lastQuality : $this->minQuality;
    }
} 