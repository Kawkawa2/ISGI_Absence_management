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

class filiereController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentYear = Carbon::now()->year;

        $searchPerSection = $request->input('searchPerSection');

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
            ->when($searchPerSection, function ($query) use ($searchPerSection) {
                return $query->where('sec.id', $searchPerSection);
            })
            ->orderBy('filiere.created_at', 'DESC')
            ->get();

        // dd($filieres);
        return view('Fil.Filiere', compact('filieres', 'allSections'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Fil.AjouterFil');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'nomF' => 'required|string|max:50',
            'codeF' => 'required|string|max:20',
            'typeF' => 'required|string|max:30',
            'duree' => 'required|string|max:30',
        ]);

        if ($validatedData->fails()) {
            return redirect()->route('Fil.create')->withErrors($validatedData)->withInput();
        }

        $filiere = new filiere();
        $filiere->nomFiliere = $request->nomF;
        $filiere->codeFiliere = $request->codeF;
        $filiere->option = $request->option;
        $filiere->typeFormation = $request->typeF;
        $filiere->duree = $request->duree;
        $filiere->save();

        // Redirect to a success page or perform other actions as needed
        return redirect()->route('Fil.index')->with('success', 'Filiere added successfully');
    }
    /**
     * Display the specified resource.
     */
    public function show(int $filiere)
    {
        $findFil = filiere::where('filiere.id', $filiere)
            ->select(
                'filiere.*',
                'filiere.id as idFil',
                'sec.codeSection',
                DB::raw('(SELECT COUNT(id) FROM filieres_modules WHERE filiere_id = filiere.id) AS moduleCount')
            )
            ->leftjoin('section as sec', 'sec.filiere_id', 'filiere.id')
            ->leftJoin('filieres_modules as filM', 'filM.filiere_id', 'filiere.id')
            ->orderBy('filiere.created_at', 'DESC')
            ->first();

        // dd($filieres);
        return view('Fil.AfficherFil', compact('findFil'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $filiere)
    {
        $findFil = filiere::where('filiere.id', $filiere)
            ->select(
                'filiere.*',
                'filiere.id as idFil',
                'sec.codeSection',
            )
            ->leftjoin('section as sec', 'sec.filiere_id', 'filiere.id')
            ->orderBy('filiere.created_at', 'DESC')
            ->first();
        return view('Fil.ModifierFil', compact('findFil'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $filiere)
    {
        $findFil = filiere::where('filiere.id', $filiere)->first();

        $validatedData = Validator::make($request->all(), [
            'nomF' => 'string|max:50',
            'codeF' => 'string|max:20',
            'typeF' => 'string|max:30',
            'duree' => 'string|max:30',
        ]);

        if ($validatedData->fails()) {
            return redirect()->route('Fil.edit')->withErrors($validatedData)->withInput();
        }


        $findFil->nomFiliere = $request->nomF ?: $findFil->nomFiliere;
        $findFil->codeFiliere = $request->codeF ?: $findFil->codeFiliere;
        $findFil->option = $request->option ?: $findFil->option;
        $findFil->typeFormation = $request->typeF ?: $findFil->typeFormation;
        $findFil->duree = $request->duree ?: $findFil->duree;
        $findFil->save();

        // Redirect to a success page or perform other actions as needed
        return redirect()->route('Fil.index')->with('success', 'Filiere modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $filiere)
    {
        $findFil = filiere::where('filiere.id', $filiere)->first();

        if ($findFil) {
            filieres_modules::where('filiere_id', $findFil->id)->delete();
            section::where('filiere_id', $findFil->id)->delete();
            $findFil->delete();
        }

        return redirect()->route('Fil.index')->with('success', 'filiere deleted successfully');
    }


    public function export()
    {
        $currentYear = Carbon::now()->year;

        $data = filiere::select(
            'filiere.*',
            'filiere.id as idFil',
            'sec.codeSection',
            DB::raw('(SELECT COUNT(id) FROM filieres_modules WHERE filiere_id = filiere.id) AS moduleCount')
        )
            ->leftjoin('section as sec', 'sec.filiere_id', 'filiere.id')
            ->leftJoin('filieres_modules as filM', 'filM.filiere_id', 'filiere.id')
            ->orderBy('filiere.created_at', 'DESC')
            ->get();


        // Set the CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="filiere.csv"',
        ];

        // Create a CSV file stream
        $output = fopen('php://temp', 'w');

        // Add headers to the CSV file
        fputcsv($output, [
            'codeFiliere',
            'nomFiliere',
            'option',
            'typeFormation',
            'niveau',
            'duree',
            'section',
            'nombreModule',

        ]);

        // Add data rows to the CSV file
        foreach ($data as $row) {
            fputcsv($output, [
                $row->codeFiliere,
                $row->nomFiliere,
                $row->option,
                $row->typeFormation,
                $row->niveau,
                $row->duree,
                $row->codeSection,
                $row->moduleCount,


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
            'Content-Disposition' => 'attachment; filename="filiere.csv"',
        ];

        // Return the CSV file as a download response
        return response($fileContents, 200, $headers);
    }
}
