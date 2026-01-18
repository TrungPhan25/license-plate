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
    protected $signature = 'uploads:clean-temp 
                            {--hours=24 : Delete files older than this many hours}
                            {--all : Delete all temporary files regardless of age}';

    /**
     * The console command description.
     */
    protected $description = 'Delete temporary uploaded files older than specified hours';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $deleteAll = $this->option('all');
        $hours = (int) $this->option('hours');
        $cutoff = Carbon::now()->subHours($hours);
        $deleted = 0;

        $files = Storage::disk('public')->files('tmp');

        if (count($files) === 0) {
            $this->info('Không có file nào trong thư mục tmp.');
            return Command::SUCCESS;
        }

        $this->info('Tìm thấy ' . count($files) . ' file trong tmp/');

        foreach ($files as $file) {
            // Skip .gitkeep
            if (basename($file) === '.gitkeep') {
                continue;
            }

            $lastModified = Carbon::createFromTimestamp(
                Storage::disk('public')->lastModified($file)
            );

            // Delete if --all flag or older than cutoff
            if ($deleteAll || $lastModified->lt($cutoff)) {
                Storage::disk('public')->delete($file);
                $deleted++;
                $this->line("Đã xóa: {$file}");
            } else {
                $this->line("Bỏ qua (chưa đủ {$hours}h): {$file}");
            }
        }

        $this->info("Đã dọn dẹp {$deleted} file tạm.");

        return Command::SUCCESS;
    }
}
