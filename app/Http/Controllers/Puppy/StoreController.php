<?php

namespace App\Http\Controllers\Puppy;

use App\Http\Controllers\Controller;
use App\Models\Puppy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'trait' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg|max:5120'],
        ]);

        $imageUrl = null;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('puppies', 'public');

            if (!$path) {
                return back()->withErrors(['image' => 'Failed to upload image.']);
            }

            $imageUrl = Storage::url($path);
        }

        $puppy = $request->user()->puppies()->create([
            'name' => $request->get('name'),
            'trait' => $request->get('trait'),
            'image_url' => $imageUrl,
        ]);

        return back()->with('success', 'Puppy created successfully!');
    }
}
