<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        // Ejecutar el comando novedades:update mensualmente
        $schedule->command('novedades:update')->monthly();
    }
    

    protected function commands(){
        $this->load(__DIR__.'/Commands');
    
        // Registrar el comando personalizado
        $this->commands([
            Commands\UpdateNovedadesCommand::class,
        ]);
    }
}
