<?php

namespace App\Http\Controllers\Puppy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        sleep(2);
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'trait' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg|max:5120'],
        ]);

        $imageUrl = null;

        if ($request->hasFile('image')) {
            // Image optimization
            $image = Image::read($request->file('image'));
            // Scale down only
            if ($image->width() > 1000) {
                $image->scale(width: 1000);
            }

            // Encode to Webp
            $webpEncoded = $image->toWebp(quality: 95)->toString();

            $fileName = Str::random() . '.webp';
            $path = "puppies/{$fileName}";

            $stored = Storage::disk('public')->put($path, $webpEncoded);

            if (!$stored) {
                return back()->withErrors(['image' => 'Failed to upload image.']);
            }

            $imageUrl = Storage::url($path);
        }

        $request->user()->puppies()->create([
            'name' => $request->get('name'),
            'trait' => $request->get('trait'),
            'image_url' => $imageUrl,
        ]);

        return back()->with('success', 'Puppy created successfully!');
    }
}
