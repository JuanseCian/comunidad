<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Persona;

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
        $personas = Persona::with('personaPrograma.programa')->get();

        foreach ($personas as $persona) {
            $persona->evaluarProgramasPorEdad();
        }
    }
}
