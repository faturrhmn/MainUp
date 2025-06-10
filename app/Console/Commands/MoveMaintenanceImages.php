<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\BeforeImage;
use App\Models\AfterImage;

class MoveMaintenanceImages extends Command
{
    protected $signature = 'maintenance:move-images';
    protected $description = 'Move maintenance images from storage to public directory';

    public function handle()
    {
        $this->info('Moving maintenance images...');

        // Create directories if they don't exist
        File::makeDirectory(public_path('assets/maintenance/before'), 0755, true, true);
        File::makeDirectory(public_path('assets/maintenance/after'), 0755, true, true);

        // Move before images
        $beforeImages = BeforeImage::all();
        foreach ($beforeImages as $image) {
            $sourcePath = storage_path('app/public/maintenance/before/' . $image->hashed_name);
            $destPath = public_path('assets/maintenance/before/' . $image->hashed_name);
            
            if (File::exists($sourcePath)) {
                File::copy($sourcePath, $destPath);
                $this->info("Moved before image: {$image->original_name}");
            } else {
                $this->warn("Source file not found: {$image->original_name}");
            }
        }

        // Move after images
        $afterImages = AfterImage::all();
        foreach ($afterImages as $image) {
            $sourcePath = storage_path('app/public/maintenance/after/' . $image->hashed_name);
            $destPath = public_path('assets/maintenance/after/' . $image->hashed_name);
            
            if (File::exists($sourcePath)) {
                File::copy($sourcePath, $destPath);
                $this->info("Moved after image: {$image->original_name}");
            } else {
                $this->warn("Source file not found: {$image->original_name}");
            }
        }

        $this->info('All images have been moved successfully!');
    }
} 