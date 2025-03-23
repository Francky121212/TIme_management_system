<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Schedule;
    
class Schedule extends Model
{
    protected $fillable = [
        'day',
        'start_time',
        'end_time',
        'subject',
    ];

    /**
     * Convertit le chiffre du jour en nom de jour.
     */
    public function getDayNameAttribute()
    {
        $days = [
            1 => 'Lundi',
            2 => 'Mardi',
            3 => 'Mercredi',
            4 => 'Jeudi',
            5 => 'Vendredi',
            6 => 'Samedi',
        ];

        return $days[$this->day] ?? 'Inconnu'; // Retourne 'Inconnu' si le jour n'existe pas
    }
}
    
    
   