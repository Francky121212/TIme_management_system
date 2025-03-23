<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\Mail_sending;


class MailController extends Controller
{


    public function Send_mail()
    {
      
        $details = [
            'subject' => 'Important - Nouvelle mise à jour',
            'body' => 'Nous avons ajouté de nouvelles fonctionnalités.',
            'url' => '',
        ];

        Mail::to('lol@gmail.com','mdr@gmail.com')->send(new Mail_sending($details));

        return response()->json(['message' => 'E-mail envoyé avec succès.']);
    }




}
