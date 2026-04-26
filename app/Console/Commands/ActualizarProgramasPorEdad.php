<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ActualizarProgramasPorEdad extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:actualizar-programas-por-edad';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $personas = Persona::all();

        foreach ($personas as $persona) {
            $edad = $persona->edad;

            foreach ($persona->programas as $programa) {

                if ($programa->nombre == 'Guarderia' && $edad >= 6) {
                    $persona->programas()->updateExistingPivot($programa->id, [
                        'fecha_egreso' => now()
                    ]);
                }

                if ($programa->nombre == 'UDI' && $edad >= 12) {
                    $persona->programas()->updateExistingPivot($programa->id, [
                        'fecha_egreso' => now()
                    ]);
                }

            }
        }
    }
}
