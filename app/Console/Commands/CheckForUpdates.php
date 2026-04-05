<?php

namespace App\Console\Commands;

use App\Services\UpdateService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CheckForUpdates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:check-updates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Background job to check for CMS updates via GitHub Releases';

    /**
     * Execute the console command.
     */
    public function handle(UpdateService $updateService)
    {
        $this->info('Checking for NebulaCMS updates...');

        try {
            $result = $updateService->checkForUpdate();

            if (isset($result['available']) && $result['available'] === true) {
                // Cache the full result array for 48 hours so the frontend can display it immediately
                Cache::put(UpdateService::CACHE_KEY, $result, now()->addDays(2));

                $this->info("New update available: v{$result['latest']}");
                Log::info("Background check: New NebulaCMS update available (v{$result['latest']})");
            } else {
                // Clear the cache if up to date
                Cache::forget(UpdateService::CACHE_KEY);
                $this->info('System is up to date.');
            }
        } catch (\Exception $e) {
            $this->error('Failed to check for updates: '.$e->getMessage());
            Log::error('Background check for updates failed: '.$e->getMessage());

            return Command::FAILURE;
        }

        return Command::SUCCESS;
    }
}
