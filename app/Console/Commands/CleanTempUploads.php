<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CleanTempUploads extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'uploads:clean-temp {--hours=24 : Delete files older than this many hours}';

    /**
     * The console command description.
     */
    protected $description = 'Delete temporary uploaded files older than specified hours';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $hours = (int) $this->option('hours');
        $cutoff = Carbon::now()->subHours($hours);
        $deleted = 0;

        $files = Storage::disk('public')->files('tmp');

        foreach ($files as $file) {
            $lastModified = Carbon::createFromTimestamp(
                Storage::disk('public')->lastModified($file)
            );

            if ($lastModified->lt($cutoff)) {
                Storage::disk('public')->delete($file);
                $deleted++;
                $this->line("Deleted: {$file}");
            }
        }

        $this->info("Cleaned up {$deleted} temporary files.");

        return Command::SUCCESS;
    }
}
