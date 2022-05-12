<?php

namespace App\Console;

use App\Models\Theme;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Http;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $jsonResumeApi = config('services.jsonresume.api');
            try {
                // $response = Http::get("{$jsonResumeApi}/themes");
                $response = Http::get("{$jsonResumeApi}/themes");
                foreach ($response->json() as $theme) {
                    Theme::firstOrCreate(compact('theme'));
                }
            } catch (\Throwable $th) {
                echo "Error: " . $th->getMessage;
            }
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}