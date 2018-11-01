<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use App\Mail\CpeExpiracion;
use App\Producto;
use App\About;

class SendCpeExpiracionEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expiracion:cpe';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Enviar correos listando los producots con CPE que estan por Expirar';

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
      $productos = Producto::select('nombre', 'codigo_producto', 'cpe_expiracion')->whereNotNull('cpe_expiracion')->whereRaw('now() > date_sub(cpe_expiracion, INTERVAL 1 MONTH)')->get();
      $count = count($productos);
      
      $about = About::select('email')->get()->first();

      if($count > 0){
        $this->info("Total de Productos con CPE por expirar: {$count}");
        $this->line('Enviando correo...');


        Mail::to($about->email)->send(new CpeExpiracion($productos));

        $this->line('El correo ha sido enviado.');
      }else{
        $this->line('No hay productos con CPE por expirar.');
      }
    }
}
