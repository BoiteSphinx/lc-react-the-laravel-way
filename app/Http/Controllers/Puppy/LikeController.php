<?php

namespace App\Http\Controllers\Puppy;

use App\Http\Controllers\Controller;
use App\Models\Puppy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Puppy $puppy): RedirectResponse
    {
        sleep(2);

        $puppy->likedBy()->toggle($request->user()->id);

        return back();
    }
}
