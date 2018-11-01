<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\AboutExpiracion;
use App\About;

class SendAboutExpiracionEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiracion:about';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar correos listando los documentos de About que estan por Expirar';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $about = About::find(1);
      $documentos = [];

      if(isset($about->rif_expiracion) && $this->checkDiff($about->rif_expiracion)){
        $documentos[] = ['titulo' => 'Rif: ','fecha' => $about->rif_expiracion];
      }

      if(isset($about->registro_mercantil_expiracion) && $this->checkDiff($about->registro_mercantil_expiracion)){
        $documentos[] = ['titulo' => 'Registro Mercantil', 'fecha' => $about->registro_mercantil_expiracion];
      }

      if(isset($about->patente_industria_expiracion) && $this->checkDiff($about->patente_industria_expiracion)){
        $documentos[] =  ['titulo' => 'Patente de Industria', 'fecha' => $about->patente_industria_expiracion];
      }

      if(isset($about->racda_expiracion) && $this->checkDiff($about->racda_expiracion)){
        $documentos[] =  ['titulo' => 'Racda', 'fecha' => $about->racda_expiracion];
      }

      if(isset($about->solvencia_ss_expiracion) && $this->checkDiff($about->solvencia_ss_expiracion)){
        $documentos[] =  ['titulo' => 'Solvencia de Seguro Social', 'fecha' => $about->solvencia_ss_expiracion];
      }

      if(isset($about->solvencia_ince_expiracion) && $this->checkDiff($about->solvencia_ince_expiracion)){
        $documentos[] =  ['titulo' => 'Solvencia Ince', 'fecha' => $about->solvencia_ince_expiracion];
      }

      $count = count($documentos);

      if($count > 0){

        $this->line($about->email);
        $this->info("Total de documentos por expirar: {$count}");
        $this->line('Enviando correo...');

        Mail::to($about->email)->send(new AboutExpiracion($documentos));
        $this->line('El correo ha sido enviado.');
      }else{
        $this->line('No hay documentos por expirar.');
      }
      
    }

    protected function checkDiff($expiracion)
    {
      $today = date('d-m-Y');
      $date = date_diff(date_create($expiracion), date_create($today));

      return $date->format('%a') < 31;
    }
}
