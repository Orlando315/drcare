<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\About;

class CpeExpiracion extends Mailable
{
    use Queueable, SerializesModels;

    public $productos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($productos)
    {
      $this->productos = $productos;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      $mailTransport = app()->make('mailer')->getSwiftMailer()->getTransport(); 
      if ($mailTransport instanceof \Swift_SmtpTransport) { 
          /** @var \Swift_SmtpTransport $mailTransport */ 
         $mailTransport->setLocalDomain('localhost'); 
      }
      return $this->from('noreply@drcareautomotriz.com')
                  ->subject('Productos con CPE por expirar - Dr.Care')
                  ->view('productos.email');
    }
}
