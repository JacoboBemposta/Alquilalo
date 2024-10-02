<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Caracteristica;
use Carbon\Carbon;

class UpdateNovedadesCommand extends Command
{
    protected $signature = 'novedades:update';

    protected $description = 'Actualizar el campo novedad de las características de los productos.';

    public function handle()
    {
        // Obtener las características que cumplen con el criterio
        $caracteristicas = Caracteristica::where('novedad', 1)
            ->where('created_at', '<=', Carbon::now()->subMonth())
            ->get();

        // Actualizar el campo novedad a 0
        foreach ($caracteristicas as $caracteristica) {
            $caracteristica->novedad = 0;
            $caracteristica->save();
        }

        $this->info('Campo novedad actualizado correctamente.');
    }
}

