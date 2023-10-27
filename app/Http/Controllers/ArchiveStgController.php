<?php

namespace App\Http\Controllers;

use App\Models\archive_stagaire;
use App\Models\absence;
use App\Models\filiere;
use App\Models\formateur;
use App\Models\justification;
use App\Models\module;
use App\Models\nature_sanction;
use App\Models\section;
use App\Models\stagaire;
use App\Models\abs_jstf_sanc;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ArchiveStgController extends Controller
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

        $stagaires = archive_stagaire
            ::select(
                'archive_stagaire.*',
                'archive_stagaire.id as idStg',
                'sec.codeSection',
                'fil.nomFiliere',

            )
            ->Join('section as sec', 'sec.id', 'archive_stagaire.Section_id')
            ->leftjoin('filiere as fil', 'fil.id', 'sec.Filiere_id')

            ->when($searchPerSection, function ($query) use ($searchPerSection) {
                return $query->where('sec.id', $searchPerSection);
            })
            ->when($searchPerFiliere, function ($query) use ($searchPerFiliere) {
                return $query->where('fil.id', $searchPerFiliere);
            })
            ->whereYear('archive_stagaire.created_at', $currentYear)
            ->orderBy('archive_stagaire.created_at', 'DESC')
            ->get();


        // dd($stagaires);
        return view('ArchStg.ArchiveStagiaire', compact('stagaires', 'allFilieres', 'allSections'));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $archive_stagaire)
    {
        $findStg = archive_stagaire::where('archive_stagaire.id', $archive_stagaire)
            ->select(
                'archive_stagaire.*',
                'archive_stagaire.id as idStg',
                'sec.codeSection',
                'fil.nomFiliere',

            )
            ->Join('section as sec', 'sec.id', 'archive_stagaire.section_id')
            ->leftjoin('filiere as fil', 'fil.id', 'sec.Filiere_id')

            ->first();
        // dd($findStg);
        return view('ArchStg.AfficherArch', compact('findStg'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $archive_stagaire)
    {
        $findStg = archive_stagaire::where('archive_stagaire.id', $archive_stagaire)->first();
        $imagePath = trim($findStg->photo); // Trim the image path

        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        $findStg->delete();
        return redirect()->route('ArchStg.index')->with('success', 'Stagiaire deleted successfully');
    }

    public function export()
    {
        $currentYear = Carbon::now()->year;

        $data = archive_stagaire
            ::select(
                'archive_stagaire.*',
                'sec.codeSection',
                'fil.nomFiliere',

            )
            ->Join('section as sec', 'sec.id', 'archive_stagaire.section_id')
            ->leftjoin('filiere as fil', 'fil.id', 'sec.Filiere_id')
            ->whereYear('archive_stagaire.created_at', $currentYear)
            ->orderBy('archive_stagaire.created_at', 'DESC')
            ->get();


        // Set the CSV headers
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="StagiairesArchive.csv"',
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
            'date archive',

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
                $row->created_at,

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
            'Content-Disposition' => 'attachment; filename="StagiairesArchive.csv"',
        ];

        // Return the CSV file as a download response
        return response($fileContents, 200, $headers);
    }
}
