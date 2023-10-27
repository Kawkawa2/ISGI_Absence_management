<?php

namespace App\Http\Controllers;

use App\Models\absence;
use App\Models\filiere;
use App\Models\section;
use App\Models\stagaire;
use App\Models\archive_stagaire;
use App\Models\abs_jstf_sanc;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class generalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchQuery = $request->input('searchQuery');
        $url = $request->input('url');

        $currentYear = Carbon::now()->year;


        // Retrieve data based on the current page and search query
        if (Str::contains($url, 'Abs')) {
            // Search logic for Absence model

            $allFilieres = filiere::whereYear('created_at', $currentYear)
                ->select('nomFiliere', 'id', 'option')
                ->distinct()
                ->get();
            $allSections = section::whereYear('created_at', $currentYear)
                ->select('codeSection', 'id')
                ->distinct()
                ->get();

            $absences = absence
                ::select(
                    'absence.dateAbs',
                    'absence.dateJsf',
                    'absence.id as idAbs',
                    'stg.noteComportement',
                    'stg.noteAssiduite',
                    'absence.seance',
                    'absence.typeSeance',
                    'stg.nom as nomStg',
                    'frm.prenom as prenomFrm',
                    'frm.nom as nomFrm',
                    'stg.prenom as prenomStg',
                    'sec.codeSection',
                    'mld.libelleModule',
                    'abs_jstf_sancs.absence_id'
                )
                ->join('stagaire as stg', 'stg.id', 'absence.stagaire_id')
                ->leftJoin('section as sec', 'sec.id', 'stg.section_id')
                ->leftjoin('filiere as fil', 'fil.id', 'sec.Filiere_id')
                ->join('Formateur as frm', 'frm.id', 'absence.formateur_id')
                ->join('Module as mld', 'mld.id', 'absence.module_id')
                ->leftJoin('abs_jstf_sancs', 'abs_jstf_sancs.absence_id', '=', 'absence.id')

                ->whereYear('absence.created_at', $currentYear)
                ->where('stg.nom', 'like', "%$searchQuery%")
                ->orWhere('stg.prenom', 'like', "%$searchQuery%")
                ->orderBy('absence.created_at', 'DESC')
                ->get();

            if ($absences->count() > 0) {
                return view('Abs.absence', compact('absences', 'allFilieres', 'allSections'));
            } else {
                return redirect()->route('Abs.index')->with('fails', 'nothing found !');
            }
        } elseif (Str::contains($url, 'Stg')) {

            $allFilieres = filiere::whereYear('created_at', $currentYear)
                ->select('nomFiliere', 'id', 'option')
                ->distinct()
                ->get();
            $allSections = section::whereYear('created_at', $currentYear)
                ->select('codeSection', 'id')
                ->distinct()
                ->get();

            $stagaires = stagaire
                ::select(
                    'stagaire.*',
                    'stagaire.id as idStg',
                    'sec.codeSection',
                    'fil.nomFiliere',

                )
                ->Join('section as sec', 'sec.id', 'stagaire.section_id')
                ->leftjoin('filiere as fil', 'fil.id', 'sec.Filiere_id')
                ->whereYear('stagaire.created_at', $currentYear)
                ->where('stagaire.nom', 'like', "%$searchQuery%")
                ->orWhere('stagaire.prenom', 'like', "%$searchQuery%")
                ->orWhere('sec.codeSection', 'like', "%$searchQuery%")
                ->orderBy('stagaire.created_at', 'DESC')
                ->get();
            if ($stagaires->count() > 0) {
                return view('Stg.Stagaire', compact('stagaires', 'allFilieres', 'allSections'));
            } else {
                return redirect()->route('Stg.index')->with('fails', 'nothing found !');
            }
        } elseif (Str::contains($url, 'ArchStg')) {

            $allFilieres = filiere::whereYear('created_at', $currentYear)
                ->select('nomFiliere', 'id', 'option')
                ->distinct()
                ->get();
            $allSections = section::whereYear('created_at', $currentYear)
                ->select('codeSection', 'id')
                ->distinct()
                ->get();

            $stagaires = archive_stagaire
                ::select(
                    'archive_stagaire.*',
                    'archive_stagaire.id as idStg',
                    'sec.codeSection',
                    'fil.nomFiliere',

                )
                ->Join('section as sec', 'sec.id', 'archive_stagaire.Section_id')
                ->leftjoin('filiere as fil', 'fil.id', 'sec.Filiere_id')

                ->whereYear('archive_stagaire.created_at', $currentYear)
                ->where('archive_stagaire.nom', 'like', "%$searchQuery%")
                ->orWhere('archive_stagaire.prenom', 'like', "%$searchQuery%")
                ->orWhere('sec.codeSection', 'like', "%$searchQuery%")

                ->orderBy('stagaire.created_at', 'DESC')
                ->get();
            if ($stagaires->count() > 0) {
                return view('ArchStg.ArchiveStagiair', compact('stagaires', 'allFilieres', 'allSections'));
            } else {
                return redirect()->route('ArchStg.index')->with('fails', 'nothing found !');
            }
        } elseif (Str::contains($url, 'Fil')) {

            $allSections = section::whereYear('created_at', $currentYear)
                ->select('codeSection', 'id')
                ->distinct()
                ->get();

            $filieres = filiere::select(
                'filiere.*',
                'filiere.id as idFil',
                'sec.codeSection',
                DB::raw('(SELECT COUNT(id) FROM filieres_modules WHERE filiere_id = filiere.id) AS moduleCount')
            )
                ->leftjoin('section as sec', 'sec.filiere_id', 'filiere.id')
                ->leftJoin('filieres_modules as filM', 'filM.filiere_id', 'filiere.id')

                ->where('filiere.codeFiliere', 'like', "%$searchQuery%")
                ->orWhere('filiere.nomFiliere', 'like', "%$searchQuery%")
                ->orWhere('filiere.typeFormation', 'like', "%$searchQuery%")
                ->orWhere('filiere.option', 'like', "%$searchQuery%")
                ->orWhere('filiere.duree', 'like', "%$searchQuery%")

                ->orderBy('filiere.created_at', 'DESC')
                ->get();

            if ($filieres->count() > 0) {
                return view('Fil.Filiere', compact('filieres', 'allSections'));
            } else {
                return redirect()->route('Fil.index')->with('fails', 'nothing found !');
            }
        } elseif (Str::contains($url, 'Sec')) {

            $allFilieres = filiere::whereYear('created_at', $currentYear)
                ->select('nomFiliere', 'id', 'option')
                ->distinct()
                ->get();

            $sections = section::select(
                'section.*',
                'section.id as idSec',
                'fil.nomFiliere',
                'fil.option',

                DB::raw('(SELECT COUNT(id) FROM stagaire WHERE Section_id = section.id  ) AS StgCount')
            )
                ->leftjoin('filiere as fil', 'fil.id', 'section.Filiere_id')

                ->where('section.codeSection', 'like', "%$searchQuery%")
                ->orWhere('section.nomSection', 'like', "%$searchQuery%")
                ->orWhere('fil.nomFiliere', 'like', "%$searchQuery%")
                ->orWhere('fil.option', 'like', "%$searchQuery%")

                ->orderBy('section.created_at', 'DESC')
                ->get();

            if ($sections->count() > 0) {
                return view('Sec.Section', compact('sections', 'allFilieres'));
            } else {
                return redirect()->route('Sec.index')->with('fails', 'nothing found !');
            }
        } elseif (Str::contains($url, 'Dash')) {
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
                ::select(
                    'absence.dateAbs',
                    'absence.id as idAbs',
                    'absence.seance',
                    'stg.nom as nomStg',
                    'stg.prenom as prenomStg',
                    'sec.codeSection',
                    'abs_jstf_sancs.absence_id'
                )
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
                ->where('stg.nom', 'like', "%$searchQuery%")
                ->orWhere('stg.prenom', 'like', "%$searchQuery%")
                ->orWhere('sec.codeSection', 'like', "%$searchQuery%")

                ->orderBy('absence.dateAbs')
                ->get();


            $recentsPerdiction = archive_stagaire
                ::select('archive_stagaire.*', 'sec.codeSection')
                ->join('section as sec', 'sec.id', 'archive_stagaire.section_id')

                ->whereYear('archive_stagaire.created_at', $currentYear)
                ->where('archive_stagaire.nom', 'like', "%$searchQuery%")
                ->orWhere('archive_stagaire.prenom', 'like', "%$searchQuery%")
                ->orWhere('sec.codeSection', 'like', "%$searchQuery%")

                ->get();

            if ($recentsAbsences->count() > 0 || $recentsPerdiction->count() > 0) {
                return view('Dash.dashboard', compact('totalStagiaires', 'totalNonJustifier', 'totalPerdiction', 'chartData', 'chartData2', 'recentsAbsences', 'recentsPerdiction'));
            } else {
                return redirect()->route('Dash.index')->with('fails', 'nothing found !');
            }
        }
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
