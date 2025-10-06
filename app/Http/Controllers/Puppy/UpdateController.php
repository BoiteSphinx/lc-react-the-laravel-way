<?php

namespace App\Http\Controllers\Puppy;

use App\Actions\OptimizeImageToWebp;
use App\Http\Controllers\Controller;
use App\Models\Puppy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Puppy $puppy)
    {
        // Validate the data
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'trait' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:5120'],
        ]);

        // If there is a new image
        if ($request->hasFile('image')) {

            $oldImagePath = str_replace('/storage/', '', $puppy->image_url);

            // Optimize and store the new image
            $optimized = (new OptimizeImageToWebp())->handle($request->file('image'));
            $path = 'puppies/' . $optimized['fileName'];

            $stored = Storage::disk('public')->put($path, $optimized['webpString']);

            if (!$stored) {
                return back()->withErrors(['image' => 'Failed to upload image.']);
            }
            $puppy->image_url = Storage::url($path);

            // Delete the old image
            if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                Storage::disk('public')->delete($oldImagePath);
            }
        }

        // Update the puppy values
        $puppy->name = $request->name;
        $puppy->trait = $request->trait;


        // Save the updated puppy
        $puppy->save();

        // Redirect back with success message
        return back()
            ->with('success', 'Puppy updated successfully!');
    }
}
