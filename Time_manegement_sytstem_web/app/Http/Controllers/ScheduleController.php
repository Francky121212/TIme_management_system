<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

    
class ScheduleController extends Controller
{
    /**
     * Affiche la liste des emplois du temps.
     */
    public function index()
    {
        $schedules = Schedule::all();
        return view('dashboard', compact('schedules'));
    }

    /**
     * Enregistre un nouvel emploi du temps.
     */
    public function store(Request $request)
    {
        $data = $request->input('schedule');

        foreach ($data as $heure => $jours) {
            foreach ($jours as $jour => $matiere) {
                if (!empty($matiere)) {
                    Schedule::create([
                        'day' => $jour,
                        'start_time' => $heure . ':00',
                        'end_time' => ($heure + 1) . ':00',
                        'subject' => $matiere,
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Emploi du temps enregistré avec succès.');
    }
    public function generatePdf()
    {
        // Récupère tous les emplois du temps
        $schedules = Schedule::all();
    
        // Génère le PDF
        $pdf = Pdf::loadView('pdf', compact('schedules'));
    
        // Télécharge le fichier PDF
        return $pdf->download('emploi_du_temps.pdf');
    }
}