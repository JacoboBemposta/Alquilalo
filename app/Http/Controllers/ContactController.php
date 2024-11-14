<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function sendContactEmail(Request $request)
    {
        // Validar los datos recibidos del formulario
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        // Obtener los datos del formulario
        $data = $request->all();

        // Enviar correo al administrador usando el Mailable
        Mail::to('jacobo.bemposta@gmail.com')->send(new ContactUsMail($data));

        // Retornar con un mensaje de éxito
        return back()->with('status', 'Mensaje enviado correctamente!');
    }
}
