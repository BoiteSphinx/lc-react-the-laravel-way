<?php

namespace App\Http\Controllers\Puppy;

use App\Http\Controllers\Controller;
use App\Models\Puppy;
use Illuminate\Http\Request;

class UpdateController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request, Puppy $puppy)
    {
        dd('Hello from the UpdateController!');
    }
}
