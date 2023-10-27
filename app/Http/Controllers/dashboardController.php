<?php

namespace App\Http\Controllers;

use App\Models\stagaire;
use App\Models\absence;
use App\Models\abs_jstf_sanc;
use App\Models\archive_stagaire;




use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class dashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // getting all the counts needed

        $currentYear = Carbon::now()->year;

        $totalStagiaires = stagaire::whereYear('created_at', $currentYear)->count();
        $totalNonJustifier = absence::whereYear('created_at', $currentYear)
            ->whereNotIn('id', function ($query) {
                $query->select('absence_id')
                    ->from('abs_jstf_sancs');
            })
            ->count();
        $totalPerdiction = archive_stagaire::whereYear('created_at', $currentYear)->count();

        // getting the chart informations
        $totalJustifier = absence::whereYear('created_at', $currentYear)
            ->whereIn('id', function ($query) {
                $query->select('absence_id')
                    ->from('abs_jstf_sancs');
            })
            ->count();

        $totalJustifMotif = abs_jstf_sanc::whereYear('created_at', $currentYear)
            ->where('justification_id', 3)
            ->count();

        $totalJustifCm = abs_jstf_sanc::whereYear('created_at', $currentYear)
            ->where('justification_id', 1)
            ->count();

        $totalJustifA = abs_jstf_sanc::whereYear('created_at', $currentYear)
            ->where('justification_id', 2)
            ->count();


        $chartData = [$totalJustifier, $totalNonJustifier];
        $chartData2 = [$totalJustifCm, $totalJustifA, $totalJustifMotif];


        // getting the last absences and perdiction

        $endDate = Carbon::today();
        $startDate = $endDate->copy()->subWeeks(2)->startOfWeek();

        $recentsAbsences = absence
            ::select('absence.dateAbs', 'absence.id as idAbs', 'absence.seance', 'stg.nom as nomStg', 'stg.prenom as prenomStg', 'sec.codeSection', 'abs_jstf_sancs.absence_id')
            ->join('stagaire as stg', 'stg.id', 'absence.stagaire_id')
            ->leftJoin('section as sec', 'sec.id', 'stg.section_id')
            ->join('Formateur as frm', 'frm.id', 'absence.formateur_id')
            ->join('Module as mld', 'mld.id', 'absence.module_id')
            ->leftJoin('abs_jstf_sancs', 'abs_jstf_sancs.absence_id', '=', 'absence.id')
            ->whereNotIn('absence.id', function ($query) {
                $query->select('absence_id')
                    ->from('abs_jstf_sancs');
            })
            ->whereBetween('absence.dateAbs', [$startDate, $endDate])
            ->orderBy('absence.dateAbs')
            ->get();


        $recentsPerdiction = archive_stagaire
            ::select('archive_stagaire.*', 'sec.codeSection')
            ->join('section as sec', 'sec.id', 'archive_stagaire.section_id')
            ->whereYear('archive_stagaire.created_at', $currentYear)
            ->get();

        // dd($recentsPerdiction);
        return view('Dash.dashboard', compact('totalStagiaires', 'totalNonJustifier', 'totalPerdiction', 'chartData', 'chartData2', 'recentsAbsences', 'recentsPerdiction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
