<?php

namespace App\Http\Controllers\Puppy;

use App\Http\Controllers\Controller;
use App\Http\Resources\PuppyResource;
use App\Models\Puppy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Inertia\Inertia;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $search = $request->get('search');

        return Inertia::render('puppies/index', [
            'puppies' => PuppyResource::collection(
                Puppy::query()
                    ->when($search, (function (Builder $query, string $search) {
                        $query->where('name', 'like', "%{$search}%")
                            ->orWhere('trait', 'like', "%{$search}%");
                    }))
                    ->with(['user', 'likedBy'])
                    ->latest()
                    ->paginate(9)
                    ->withQueryString()
            ),
            'likedPuppies' => $request->user() ?
                PuppyResource::collection($request->user()->likedPuppies)
                : [],
            'filters' => [
                'search' => $search
            ]
        ]);
    }
}
