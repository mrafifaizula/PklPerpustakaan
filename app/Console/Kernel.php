<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        $schedule->command('cek:pengembalian')->daily();
        $schedule->call(function () {
            // Panggil fungsi untuk menghitung denda otomatis
            app('App\Http\Controllers\frontend\Pinjambuku')->hitungDendaOtomatis();
        })->daily(); // Bisa diubah sesuai kebutuhan (daily, hourly, etc.)
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
