<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\About;

class AboutExpiracion extends Mailable
{
    use Queueable, SerializesModels;

    public $documentos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($documentos)
    {
      $this->documentos = $documentos;
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
         $mailTransport->setLocalDomain('127.0.0.1'); 
      }
      return $this->from('no-reply@project4design.com')
                  ->subject('Documentos que estan por expirar - Dr.Care')
                  ->view('about.email');
    }
}
