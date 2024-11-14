<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class ContactUsMail extends Mailable
{
    public $data;

    public function __construct($data)
    {
        $this->data = $data;  // Asegúrate de que los datos estén bien asignados
    }

    public function build()
    {
        return $this->subject('Nuevo mensaje de Contacto')
                    ->view('emails.contact')  // Asegúrate de que este nombre coincida con la vista
                    ->with('data', $this->data);  // Pasa los datos a la vista
    }
}


