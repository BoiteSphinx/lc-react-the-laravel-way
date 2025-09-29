<?php

namespace App\Actions;

use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class OptimizeImageToWebp
{
    public function handle(string $input): array
    {
        // Image optimization
        $image = Image::read($input);

        // Scale down only
        if ($image->width() > 1000) {
            $image->scale(width: 1000);
        }

        // Encode to Webp
        $encoded = $image->toWebp(quality: 95)->toString();
        $fileName = Str::random() . '.webp';

        return [
            'webp_string' => $encoded,
            'filename' => $fileName
        ];
    }
}
