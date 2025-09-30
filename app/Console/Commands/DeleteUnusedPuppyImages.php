<?php

namespace App\Console\Commands;

use App\Models\Puppy;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class DeleteUnusedPuppyImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-unused-puppy-images';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up uploaded images that are no longer referenced in the database.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Get all stored images in `puppies` directory
        $storedImages = Storage::disk('public')->files('puppies');
        // Get all images referenced by puppies
        $usedImages = Puppy::query()->pluck('image_url')
            ->map(fn ($url) => str($url)->replace(search: '/storage/', replace: '')->value())
            ->toArray();

        // Compare both arrays
        $unusedImages = array_diff($storedImages, $usedImages);

        $totalCount = count($unusedImages);

        if ($totalCount === 0) {
            $this->components->info('No unused images found!');

            return self::SUCCESS;
        }

        $this->components->info("Found {$totalCount} unused images");
        $firstThree = array_slice($unusedImages, 0, 3);
        foreach ($firstThree as $image) {
            $this->line("- {$image}");
        }
        if ($totalCount > 3) {
            $remaining = $totalCount - 3;
            $this->line("+ {$remaining} more...");
        }

        if ($this->confirm("Do you want to delete these unused images ?")) {
            foreach ($unusedImages as $image) {
                Storage::disk('public')->delete($image);
                $this->components->info("Deleted: {$image}");
            }

            $this->components->info("Unused images deleted successfully.");
        } else {
            $this->components->info("Operation cancelled");
        }

        return self::SUCCESS;
    }
}
