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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;


class stagaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $currentYear = Carbon::now()->year;

        $searchPerFiliere = $request->input('searchPerFiliere');
        $searchPerSection = $request->input('searchPerSection');

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

            ->when($searchPerSection, function ($query) use ($searchPerSection) {
                return $query->where('sec.id', $searchPerSection);
            })
            ->when($searchPerFiliere, function ($query) use ($searchPerFiliere) {
                return $query->where('fil.id', $searchPerFiliere);
            })
            ->whereYear('stagaire.created_at', $currentYear)
            ->orderBy('stagaire.created_at', 'DESC')
            ->get();


        // dd($stagaires);
        return view('Stg.Stagaire', compact('stagaires', 'allFilieres', 'allSections'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $currentYear = Carbon::now()->year;

        $allSections = section::whereYear('created_at', $currentYear)
            ->select('codeSection', 'id')->get();


        return view('Stg.AjouterStg', compact('allSections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'email' => 'required|email:rfc,dns',
            'nom' => 'required|string|min:3|max:20',
            'prenom' => 'required|string|min:3|max:25',
            'adresse' => 'required|string|max:50',
            'dateN' => 'required|date',
            'dateIn' => 'required|date_format:Y',
            'dateBac' => 'date_format:Y',
            'mention' => 'string',
            'SectionId' => 'required|integer',
            'cin' => 'required|string|max:7|unique:stagaire,cin',
            'genre' => 'required',
            'tele' => 'required|string|max:10|min:10',
            'photo' => 'file|image|max:1024',

        ]);

        if ($validatedData->fails()) {
            return back()->withErrors($validatedData)->withInput();
        }
        // dd($request->photo);
        if ($request->photo) {
            $chemin_img = $request->file('photo')->store('stagiaire', 'public');
        }
        $stagaire = new stagaire();
        $stagaire->nom = $request->nom;
        $stagaire->Section_id = $request->SectionId;
        $stagaire->prenom = $request->prenom;
        $stagaire->cin = $request->cin;
        $stagaire->email = $request->email;
        $stagaire->adresse = $request->adresse;
        $stagaire->tele = $request->tele;
        $stagaire->genre = $request->genre;
        $stagaire->dateNaissance = $request->dateN;
        $stagaire->dateInscription = $request->dateIn;
        $stagaire->photo = $chemin_img ?: null;
        $stagaire->anneeBac = $request->dateBac ?: null;
        $stagaire->moyenBac = $request->noteBac ?: null;
        $stagaire->mentionBac = $request->mention ?: null;
        $stagaire->save();

        // Redirect to a success page or perform other actions as needed
        return redirect()->route('Stg.index')->with('success', 'Stagiaire added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(int $stagaire)
    {

        $findStg = stagaire::where('stagaire.id', $stagaire)
            ->select(
                'stagaire.*',
                'stagaire.id as idStg',
                'sec.codeSection',
                'fil.nomFiliere',

            )
            ->Join('section as sec', 'sec.id', 'stagaire.section_id')
            ->leftjoin('filiere as fil', 'fil.id', 'sec.Filiere_id')

            ->first();
        // dd($findStg);
        return view('Stg.AfficherStg', compact('findStg'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $stagaire)
    {

        $currentYear = Carbon::now()->year;

        $allSections = section::whereYear('created_at', $currentYear)
            ->select('codeSection', 'id')->get();

        $findStg = stagaire::where('stagaire.id', $stagaire)
            ->select(
                'stagaire.*',
                'stagaire.id as idStg',
                'sec.codeSection',
                'sec.id as idSec',

                'fil.nomFiliere',

            )
            ->Join('section as sec', 'sec.id', 'stagaire.section_id')
            ->leftjoin('filiere as fil', 'fil.id', 'sec.Filiere_id')

            ->first();

        return view('Stg.ModifierStg', compact('findStg', 'allSections'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $stagaire)
    {
        $findStg = stagaire::where('stagaire.id', $stagaire)
            ->select(
                'stagaire.*',
                'stagaire.id as idStg',
                'sec.codeSection',
                'sec.id as idSec',
                'fil.nomFiliere',
            )
            ->Join('section as sec', 'sec.id', 'stagaire.section_id')
            ->leftjoin('filiere as fil', 'fil.id', 'sec.Filiere_id')
            ->first();

        $validatedData = $request->validate([
            'email' => 'email:rfc,dns',
            'nom' => 'string|min:3|max:20',
            'prenom' => 'string|min:3|max:25',
            'adresse' => 'string|max:50',
            'dateN' => 'date',
            'dateIn' => 'date_format:Y',
            'dateBac' => 'date_format:Y',
            'mention' => 'string',
            'SectionId' => 'integer',
            'cin' => [
                'string',
                'max:7',
                function ($attribute, $value, $fail) use ($findStg) {
                    $existingRecord = stagaire::where('cin', $value)
                        ->where('id', '<>', $findStg->idStg)
                        ->first();

                    if ($existingRecord) {
                        $fail('The ' . $attribute . ' has already been taken.');
                    }
                },
            ],            'genre' => 'required',
            'tele' => 'string|max:10|min:10',
            'photo' => 'file|image|max:1024',
        ]);

        $chemin_img = $findStg->photo;
        if ($request->hasFile('photo')) {
            if (Storage::disk('public')->exists($chemin_img)) {
                try {
                    Storage::disk('public')->delete($chemin_img);
                } catch (\Exception $e) {
                    // Log the error message for debugging
                    Log::error($e->getMessage());
                }
            }
            $chemin_img = $request->file('photo')->store('stagiaire', 'public');
        }



        // Update the attributes with the validated data
        $findStg->fill($validatedData);
        $findStg->photo = $chemin_img;
        $findStg->save();

        return redirect()->route('Stg.index')->with('success', 'Stagiaire modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $stagaire)
    {
        $findStg = stagaire::where('stagaire.id', $stagaire)->first();
        $imagePath = trim($findStg->photo);

        if (Storage::disk('public')->exists($imagePath)) {
            // Get the original filename and extension
            $filename = pathinfo($imagePath, PATHINFO_FILENAME);
            $extension = pathinfo($imagePath, PATHINFO_EXTENSION);

            // Set the desired filename for the archived image
            $archivedFilename = 'archive/' . $filename . '.' . $extension;

            // Move the image to the archive path with the desired filename
            Storage::disk('public')->move($imagePath, $archivedFilename);

            // Update the photo field in the database with the new path
            $findStg->photo = $archivedFilename;
            $findStg->save();
            // dd( $findStg->photo);
        }



        // Find the associated absence records for the stagaire
        $absences = absence::where('Stagaire_id', $findStg->id)->get();
        $retards = retard::where('Stagaire_id', $findStg->id)->get();


        // Delete each absence record and its associated abs_jus_sanc records
        foreach ($absences as $absence) {
            // Delete the associated abs_jus_sanc records
            $absence->abs_jstf_sanc()->delete();

            // Delete the absence record
            $absence->delete();
        }
        foreach ($retards as $retard) {

            // Delete the retard record
            $retard->delete();
        }


        $findStg->delete();
        return redirect()->route('Stg.index')->with('success', 'Stagiaire archived successfully');
    }


    public function export()
    {
        $currentYear = Carbon::now()->year;

        $data = stagaire
            ::select(
                'stagaire.*',
                'sec.codeSection',
                'fil.nomFiliere',

            )
            ->Join('section as sec', 'sec.id', 'stagaire.section_id')
            ->leftjoin('filiere as fil', 'fil.id', 'sec.Filiere_id')
            ->whereYear('stagaire.created_at', $currentYear)
            ->orderBy('stagaire.created_at', 'DESC')
            ->get();


        // Set the CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="Stagiaires.csv"',
        ];

        // Create a CSV file stream
        $output = fopen('php://temp', 'w');

        // Add headers to the CSV file
        fputcsv($output, [
            'nom',
            'prenom',
            'genre',
            'email',
            'adresse',
            'telephone',
            'date naissance',
            'nomFiliere',
            'codeSection',
            'date inscription',
            'anneeBac',
            'moyenBac',
            'mentionBac',
            'autreDiplome',
        ]);

        // Add data rows to the CSV file
        foreach ($data as $row) {
            fputcsv($output, [
                $row->nom,
                $row->prenom,
                $row->genre,
                $row->email,
                $row->adresse,
                $row->tele,
                $row->dateNaissance,
                $row->nomFiliere,
                $row->codeSection,
                $row->dateInscription,
                $row->anneeBac,
                $row->moyenBac,
                $row->mentionBac,
                $row->autreDiplome,

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
            'Content-Disposition' => 'attachment; filename="Stagiaires.csv"',
        ];

        // Return the CSV file as a download response
        return response($fileContents, 200, $headers);
    }
}
