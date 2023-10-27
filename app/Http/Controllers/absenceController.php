<?php

namespace App\Http\Controllers;

use App\Models\absence;
use App\Models\filiere;
use App\Models\formateur;
use App\Models\justification;
use App\Models\module;
use App\Models\nature_sanction;
use App\Models\section;
use App\Models\stagaire;
use App\Models\abs_jstf_sanc;


use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Carbon\Carbon;

class absenceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentYear = Carbon::now()->year;

        $searchPerFiliere = $request->input('searchPerFiliere');
        $searchPerSection = $request->input('searchPerSection');
        $searchPerDate = $request->input('searchPerDate');

        $allFilieres = filiere::whereYear('created_at', $currentYear)
            ->select('nomFiliere', 'id','option')
            ->distinct()
            ->get();
        $allSections = section::whereYear('created_at', $currentYear)
            ->select('codeSection', 'id')
            ->distinct()
            ->get();

        // dd($allFilieres);
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
            ->when($searchPerDate, function ($query) use ($searchPerDate) {
                return $query->whereDate('absence.dateAbs', $searchPerDate);
            })
            ->when($searchPerSection, function ($query) use ($searchPerSection) {
                return $query->where('sec.id', $searchPerSection);
            })
            ->when($searchPerFiliere, function ($query) use ($searchPerFiliere) {
                return $query->where('fil.id', $searchPerFiliere);
            })
            ->whereYear('absence.created_at', $currentYear)
            ->orderBy('absence.created_at', 'DESC')
            ->get();


        // dd($absences);
        return view('Abs.absence', compact('absences', 'allFilieres', 'allSections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentYear = Carbon::now()->year;

        $allFormateur = formateur::select('nom', 'prenom', 'id')->get();
        $allmodules = module::select('libelleModule', 'id')->get();

        $allSections = section::whereYear('created_at', $currentYear)
            ->select('codeSection', 'id')->get();
        $allTypeJustif = justification::select('libelleJsf', 'id')->get();

        $allSanction = nature_sanction::select('libelleSanc', 'id')
            ->where('sanction', 'like', 'exclusion%')->get();

        return view('Abs.AjouterAbs', compact('allFormateur', 'allmodules', 'allSections', 'allTypeJustif', 'allSanction'));
    }

    /**
     * get some Stagiaires
     */

    public function getStagiaires(Request $request)
    {
        $groupId = $request->input('section');
        $stagiaires = stagaire::where('section_id', $groupId)->select('nom', 'prenom', 'id')->get(); // Fetch stagiaires for the selected group
        return response()->json(['stagiaires' => $stagiaires]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Check if a justification is provided
        if ($request->has('typeJustif')) {
            // Validate the form data for both absence and justification

            $validatedData1 = Validator::make($request->all(), [
                'stagiaireId' => 'required',
                'FormateurId' => 'required',
                'moduleId' => 'required',
                'dateAbs' => 'required|date',
                'seance' => 'required',
                'typeSeance' => 'required',
                'dateJsf' => 'required|date',
                'nbJoursJsf' => 'required|integer',
                'typeJustif' => 'required',
                // 'sanctionId' => '',
            ]);
            if ($validatedData1->fails()) {
                return back()->withErrors($validatedData1)->withInput();
            }
            // Create a new Absence instance
            $absence = new Absence();
            $absence->stagaire_id = $request->input('stagiaireId');
            $absence->formateur_id = $request->input('FormateurId');
            $absence->module_id = $request->input('moduleId');
            $absence->dateAbs = $request->input('dateAbs');
            $absence->seance = $request->input('seance');
            $absence->typeSeance = $request->input('typeSeance');
            $absence->dateJsf = $request->input('dateJsf');
            $absence->nbJoursJsf = $request->input('nbJoursJsf');


            // Save the absence
            $absence->save();
            // Create a new Abs_Jsf_Sanc instance

            $absJsfSanc = new abs_jstf_sanc();
            $absJsfSanc->absence_id = $absence->id;
            $absJsfSanc->justification_id = $request->input('typeJustif');
            $absJsfSanc->sanction_id = $request->input('sanctionId') ?: null;

            // Save the Abs_Jsf_Sanc
            $absJsfSanc->save();
        } else {
            // Validate the form data for absence
            $validatedData1 = Validator::make($request->all(), [
                'stagiaireId' => 'required',
                'FormateurId' => 'required',
                'moduleId' => 'required',
                'dateAbs' => 'required|date',
                'seance' => 'required',
                'typeSeance' => 'required',
            ]);
            if ($validatedData1->fails()) {
                return back()->withErrors($validatedData1)->withInput();
            }
            // Create a new Absence instance
            $absence = new Absence();
            $absence->stagaire_id = $request->input('stagiaireId');
            $absence->formateur_id = $request->input('FormateurId');
            $absence->module_id = $request->input('moduleId');
            $absence->dateAbs = $request->input('dateAbs');
            $absence->seance = $request->input('seance');
            $absence->typeSeance = $request->input('typeSeance');


            // Save the absence
            $absence->save();
        }

        // Redirect to a success page or perform other actions as needed
        return redirect()->route('Abs.index')->with('success', 'Absence added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $absence)
    {
        $findAbs = absence::where('absence.id', $absence)
            ->select(
                'absence.*',
                'j.*',
                'n.*',

                'stg.nom as nomStg',
                'frm.prenom as prenomFrm',
                'frm.nom as nomFrm',
                'stg.prenom as prenomStg',
                'sec.codeSection',
                'mld.libelleModule',
            )
            ->join('stagaire as stg', 'stg.id', 'absence.stagaire_id')
            ->leftJoin('section as sec', 'sec.id', 'stg.section_id')
            ->leftjoin('filiere as fil', 'fil.id', 'sec.Filiere_id')
            ->join('Formateur as frm', 'frm.id', 'absence.formateur_id')
            ->join('Module as mld', 'mld.id', 'absence.module_id')
            ->leftJoin('abs_jstf_sancs', 'abs_jstf_sancs.absence_id', '=', 'absence.id')
            ->leftJoin('justification as j', 'j.id', '=', 'abs_jstf_sancs.justification_id')
            ->leftJoin('nature_sanction as n', 'n.id', '=', 'abs_jstf_sancs.sanction_id')

            ->first();
        return view('Abs.AfficherAbs', compact('findAbs'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $absence)
    {

        $currentYear = Carbon::now()->year;

        $allFormateur = formateur::select('nom', 'prenom', 'id')->get();
        $allmodules = module::select('libelleModule', 'id')->get();

        $allSections = section::whereYear('created_at', $currentYear)
            ->select('codeSection', 'id')->get();
        $allTypeJustif = justification::select('libelleJsf', 'id')->get();

        $allSanction = nature_sanction::select('libelleSanc', 'id')
            ->where('sanction', 'like', 'exclusion%')->get();

        $findAbs = absence::where('absence.id', $absence)
            ->select(
                'absence.*',
                'absence.id as idAbs',
                'j.*',
                'j.id as idJ',

                'n.*',
                'n.id as idN',

                'stg.nom as nomStg',
                'stg.id as idStg',

                'frm.prenom as prenomFrm',
                'frm.nom as nomFrm',
                'frm.id as idFrm',

                'stg.prenom as prenomStg',
                'sec.codeSection',
                'mld.libelleModule',
                'mld.id as idMld',

            )
            ->join('stagaire as stg', 'stg.id', 'absence.stagaire_id')
            ->leftJoin('section as sec', 'sec.id', 'stg.section_id')
            ->leftjoin('filiere as fil', 'fil.id', 'sec.Filiere_id')
            ->join('Formateur as frm', 'frm.id', 'absence.formateur_id')
            ->join('Module as mld', 'mld.id', 'absence.module_id')
            ->leftJoin('abs_jstf_sancs', 'abs_jstf_sancs.absence_id', '=', 'absence.id')
            ->leftJoin('justification as j', 'j.id', '=', 'abs_jstf_sancs.justification_id')
            ->leftJoin('nature_sanction as n', 'n.id', '=', 'abs_jstf_sancs.sanction_id')

            ->first();

        // dd($findAbs);


        return view('Abs.ModifierAbs', compact('findAbs', 'allFormateur', 'allmodules', 'allSections', 'allTypeJustif', 'allSanction'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $absence)
    {
        $findAbs = absence::where('absence.id', $absence)
            ->select(
                'absence.*',
                'absence.id as idAbs',
                'j.*',
                'j.id as idJ',

                'n.*',
                'n.id as idN',

                'stg.nom as nomStg',
                'stg.id as idStg',

                'frm.prenom as prenomFrm',
                'frm.nom as nomFrm',
                'frm.id as idFrm',

                'stg.prenom as prenomStg',
                'sec.codeSection',
                'mld.libelleModule',
                'mld.id as idMld',

            )
            ->join('stagaire as stg', 'stg.id', 'absence.stagaire_id')
            ->leftJoin('section as sec', 'sec.id', 'stg.section_id')
            ->leftjoin('filiere as fil', 'fil.id', 'sec.Filiere_id')
            ->join('Formateur as frm', 'frm.id', 'absence.formateur_id')
            ->join('Module as mld', 'mld.id', 'absence.module_id')
            ->leftJoin('abs_jstf_sancs', 'abs_jstf_sancs.absence_id', '=', 'absence.id')
            ->leftJoin('justification as j', 'j.id', '=', 'abs_jstf_sancs.justification_id')
            ->leftJoin('nature_sanction as n', 'n.id', '=', 'abs_jstf_sancs.sanction_id')
            ->first();

        $justificationId = $request->input('typeJustif');
        $sanctionId = $request->input('sanctionId');
        $dateJsf = $request->input('dateJsf');
        $nbJoursJsf = $request->input('nbJoursJsf');

        //validate data

        $validatedData = Validator::make($request->all(), [
            'dateAbs' => 'date',
            'dateJsf' => 'date',
            'nbJoursJsf' => 'integer',
        ]);

        if ($validatedData->fails()) {
            return back()->withErrors($validatedData)->withInput();
        }



        // Check if absence ID exists in abs_jus_sanc table
        $absJstfSanc = abs_jstf_sanc::where('absence_id', $findAbs->idAbs)->first();

        if ($absJstfSanc) {

            // Absence ID exists in abs_jus_sanc table, perform normal update

            // Update the absence record with the validated form data
            $findAbs->Stagaire_id = $findAbs->Stagaire_id;
            $findAbs->formateur_id = $request->input('FormateurId') ?: $findAbs->formateur_id;
            $findAbs->module_id = $request->input('moduleId') ?: $findAbs->module_id;
            $findAbs->dateAbs = $request->input('dateAbs') ?: $findAbs->dateAbs;
            $findAbs->seance = $request->input('seance') ?: $findAbs->seance;
            $findAbs->typeSeance = $request->input('typeSeance') ?: $findAbs->typeSeance;
            $findAbs->dateJsf = $request->input('dateJsf') ?: $findAbs->dateJsf;
            $findAbs->nbJoursJsf = $request->input('nbJoursJsf') ?: $findAbs->nbJoursJsf;
            $findAbs->save();


            // Update the abs_jus_sanc record
            $absJstfSanc->justification_id = $request->input('typeJustif') ?: $absJstfSanc->justification_id;
            $absJstfSanc->sanction_id = $sanctionId ? $sanctionId : null;
            $absJstfSanc->save();

            // Redirect to a success page or perform other actions as needed
            return redirect()->route('Abs.index')->with('success', 'Absence modified successfully');
        } else {
            // Absence ID does not exist in abs_jus_sanc table

            // Check if the user provided justification, date, and number of days
            if ($justificationId && $dateJsf && $nbJoursJsf) {
                // User provided justification, date, and number of days

                // Update the absence record with the validated form data
                $findAbs->Stagaire_id = $findAbs->Stagaire_id;
                $findAbs->formateur_id = $request->input('FormateurId') ?: $findAbs->formateur_id;
                $findAbs->module_id = $request->input('moduleId') ?: $findAbs->module_id;
                $findAbs->dateAbs = $request->input('dateAbs') ?: $findAbs->dateAbs;
                $findAbs->seance = $request->input('seance') ?: $findAbs->seance;
                $findAbs->typeSeance = $request->input('typeSeance') ?: $findAbs->typeSeance;
                $findAbs->dateJsf = $dateJsf;
                $findAbs->nbJoursJsf = $nbJoursJsf;
                $findAbs->save();

                // Create a new abs_jus_sanc record
                $absJstfSanc = new abs_jstf_sanc();
                $absJstfSanc->absence_id = $findAbs->idAbs;
                $absJstfSanc->justification_id = $justificationId;
                $absJstfSanc->sanction_id = $sanctionId ?: null;
                $absJstfSanc->save();
                // Redirect to a success page or perform other actions as needed
                return redirect()->route('Abs.index')->with('success', 'Absence modified successfully');
            } else {
                // User did not provide justification, date, and number of days
                // Only update the absence record with the validated form data
                $findAbs->Stagaire_id = $findAbs->Stagaire_id;
                $findAbs->formateur_id = $request->input('FormateurId') ?: $findAbs->formateur_id;
                $findAbs->module_id = $request->input('moduleId') ?: $findAbs->module_id;
                $findAbs->dateAbs = $request->input('dateAbs') ?: $findAbs->dateAbs;
                $findAbs->seance = $request->input('seance') ?: $findAbs->seance;
                $findAbs->typeSeance = $request->input('typeSeance') ?: $findAbs->typeSeance;
                $findAbs->save();
                // Redirect to a success page or perform other actions as needed
                return redirect()->route('Abs.index')->with('success', 'Absence modified successfully');
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $absence)
    {
        $findAbs = absence::where('absence.id', $absence)->first();
        $findJsf = abs_jstf_sanc::where('absence_id', $findAbs->id)->first();
        if ($findJsf) {
            $findJsf->delete();
            $findAbs->delete();
            return redirect()->route('Abs.index')->with('success', 'Absence deleted successfully');
        }
        return redirect()->route('Abs.index')->with('fails', 'Can not delete not justified absence');
    }
    public function export()
    {
        $currentYear = Carbon::now()->year;

        $data = absence
            ::select(
                'absence.*',
                'j.*',
                'n.*',

                'stg.nom as nomStg',
                'frm.prenom as prenomFrm',
                'frm.nom as nomFrm',
                'stg.prenom as prenomStg',
                'sec.codeSection',
                'mld.libelleModule',
            )
            ->join('stagaire as stg', 'stg.id', 'absence.stagaire_id')
            ->leftJoin('section as sec', 'sec.id', 'stg.section_id')
            ->leftjoin('filiere as fil', 'fil.id', 'sec.Filiere_id')
            ->join('Formateur as frm', 'frm.id', 'absence.formateur_id')
            ->join('Module as mld', 'mld.id', 'absence.module_id')
            ->leftJoin('abs_jstf_sancs', 'abs_jstf_sancs.absence_id', '=', 'absence.id')
            ->leftJoin('justification as j', 'j.id', '=', 'abs_jstf_sancs.justification_id')
            ->leftJoin('nature_sanction as n', 'n.id', '=', 'abs_jstf_sancs.sanction_id')

            ->whereYear('absence.created_at', $currentYear)
            ->orderBy('absence.dateAbs', 'DESC')
            ->get();



        // Set the CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="absences.csv"',
        ];

        // Create a CSV file stream
        $output = fopen('php://temp', 'w');

        // Add headers to the CSV file
        fputcsv($output, [
            'type',
            'seance',
            'typeSeance',
            'codeSection',
            'dateAbs',
            'dateJsf',
            'nbJoursJsf',
            'nomStg',
            'prenomStg',
            'prenomFrm',
            'nomFrm',
            'libelleModule',
            'libelleJsf',
            'libelleSanc',
            'sanction'
        ]);

        // Add data rows to the CSV file
        foreach ($data as $row) {
            fputcsv($output, [
                $row->type,
                $row->seance,
                $row->typeSeance,
                $row->codeSection,
                $row->dateAbs,
                $row->dateJsf,
                $row->nbJoursJsf,
                $row->nomStg,
                $row->prenomStg,
                $row->prenomFrm,
                $row->nomFrm,
                $row->libelleModule,
                $row->libelleJsf,
                $row->libelleSanc,
                $row->sanction
            ]);
        }

        // Rewind the file stream
        rewind($output);

        // Get the contents of the file stream
        $fileContents = stream_get_contents($output);

        // Close the file stream
        fclose($output);

        // Set the CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="absences.csv"',
        ];

        // Return the CSV file as a download response
        return response($fileContents, 200, $headers);
    }
}
