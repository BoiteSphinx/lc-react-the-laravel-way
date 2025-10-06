<?php

namespace App\Http\Controllers\Puppy;

use App\Http\Controllers\Controller;
use App\Models\Puppy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DeleteController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Puppy $puppy)
    {
        $imagePath = str($puppy->image_url)->replace('/storage/', '')->value();

        if ($request->user()->cannot('delete', $puppy)) {
            return back()->withErrors(['error' => 'You do not have permission to delete this puppy.']);
        }

        $puppy->delete();

        if ($imagePath && Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        return redirect()
            ->route('home')
            ->with('success', 'Puppy deleted successfully!');
    }
}
