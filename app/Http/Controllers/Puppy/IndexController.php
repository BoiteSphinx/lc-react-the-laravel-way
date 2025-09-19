<?php

namespace App\Http\Controllers\Puppy;

use App\Http\Controllers\Controller;
use App\Http\Resources\PuppyResource;
use App\Models\Puppy;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return Inertia::render('puppies/index', [
            'puppies' => PuppyResource::collection(Puppy::all()->load(['user', 'likedBy'])),
        ]);
    }
}
