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
use App\Models\retard;
use App\Models\filieres_modules;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class sectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentYear = Carbon::now()->year;

        $searchPerFiliere = $request->input('searchPerFiliere');

        $allFilieres = filiere::whereYear('created_at', $currentYear)
            ->select('nomFiliere', 'id','option')
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
            ->when($searchPerFiliere, function ($query) use ($searchPerFiliere) {
                return $query->where('section.filiere_id', $searchPerFiliere);
            })
            ->orderBy('section.created_at', 'DESC')
            ->get();


        return view('Sec.Section', compact('sections', 'allFilieres'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $filieres = filiere::select('nomFiliere', 'id', 'option')->get();

        return view('Sec.AjouterSec', compact('filieres'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'Filiere' => 'required',
            'codeS' => 'required|string|max:40',
            'nomS' => 'required|string|max:60',
        ]);

        if ($validatedData->fails()) {
            return redirect()->route('Sec.create')->withErrors($validatedData)->withInput();
        }

        $section = new section();
        $section->Filiere_id = $request->Filiere;
        $section->codeSection = $request->codeS;
        $section->nomSection = $request->nomS;

        $section->save();

        // Redirect to a success page or perform other actions as needed
        return redirect()->route('Sec.index')->with('success', 'Section added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $section)
    {
        $findSec = section::where('section.id', $section)
            ->select(
                'section.*',
                'section.id as idSec',
                'fil.nomFiliere',
                'fil.option',

                DB::raw('(SELECT COUNT(id) FROM stagaire WHERE Section_id = section.id  ) AS StgCount')
            )
            ->leftjoin('filiere as fil', 'fil.id', 'section.Filiere_id')
            ->orderBy('section.created_at', 'DESC')
            ->first();
        return view('Sec.AfficherSec', compact('findSec'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $section)
    {
        $filieres = filiere::select('nomFiliere', 'id', 'option')->get();
        

        $findSec = section::where('section.id', $section)
            ->select(
                'section.*',
                'section.id as idSec',
                'fil.nomFiliere',

                'fil.id as idFil',
            )
            ->leftjoin('filiere as fil', 'fil.id', 'section.Filiere_id')
            ->first();

        return view('Sec.ModifierSec', compact('findSec', 'filieres'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $section)
    {
        $findSec = section::where('section.id', $section)->first();

        $validatedData = Validator::make($request->all(), [
            'Filiere',
            'codeS' => 'string|max:40',
            'nomS' => 'string|max:60',
        ]);

        if ($validatedData->fails()) {
            return back()->withErrors($validatedData)->withInput();
        }


        $findSec->Filiere_id = $request->Filiere ?: $findSec->Filiere_id;
        $findSec->codeSection = $request->codeS ?: $findSec->codeSection;
        $findSec->nomSection = $request->nomS ?: $findSec->nomSection;

        $findSec->save();

        // Redirect to a success page or perform other actions as needed
        return redirect()->route('Sec.index')->with('success', 'Section modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $section)
    {
        $findSec = section::where('section.id', $section)->first();
        $findStg = stagaire::where('section_id', $findSec->id);
        if ($findSec) {
            if ($findStg) {
                return redirect()->route('Sec.index')->with('fails', 'can not delete section that still have stagiaires');
            }
            $findSec->delete();
        }


        return redirect()->route('Sec.index')->with('success', 'section deleted successfully');
    }
    public function export()
    {
        $currentYear = Carbon::now()->year;

        $data = section::select(
            'section.*',
            'section.id as idSec',
            'fil.nomFiliere',
            'fil.option',

            DB::raw('(SELECT COUNT(id) FROM stagaire WHERE Section_id = section.id  ) AS StgCount')
        )
            ->leftjoin('filiere as fil', 'fil.id', 'section.Filiere_id')
            ->orderBy('section.created_at', 'DESC')
            ->get();



        // Set the CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="Section.csv"',
        ];

        // Create a CSV file stream
        $output = fopen('php://temp', 'w');

        // Add headers to the CSV file
        fputcsv($output, [
            'nom Filiere',
            'option',
            'nom Section',
            'code Section',
            'nombre stagiaires',
        ]);

        // Add data rows to the CSV file
        foreach ($data as $row) {
            fputcsv($output, [
                $row->nomFiliere,
                $row->option,
                $row->nomSection,
                $row->codeSection,
                $row->StgCount,
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
            'Content-Disposition' => 'attachment; filename="Section.csv"',
        ];

        // Return the CSV file as a download response
        return response($fileContents, 200, $headers);
    }
}
