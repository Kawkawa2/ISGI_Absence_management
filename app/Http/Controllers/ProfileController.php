<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Mail;
use App\Mail\loginMail;



class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = user::all();
        return view('profile.profile', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = role::all();

        return view('profile.AjouterProfile', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = Validator::make($request->all(), [
            'profileIimage' => 'image|max:1050',
            'email' => 'required|email:rfc,dns',
            'nom' => 'required|string|max:30',
            'prenom' => 'required|string|max:55',
            'adresse' => 'required|string|max:70',
            'cin' => 'required|string|max:7|unique:user,cin',
            'tele' => 'required|string|max:10|min:10|unique:user,tele',
            'password' => 'required|string|min:8|max:30|confirmed',
            'role' => 'required'


        ]);

        $chemin_img = null; // Initialize the variable
        if ($validatedData->fails()) {
            return redirect()->route('Profile.create')->withErrors($validatedData)->withInput();
        }
        if ($request->profileIimage) {
            $chemin_img = $request->file('profileIimage')->store('users', 'public');
        }
        $nom = Auth()->user()->nom;
        $sender = Auth()->user()->email; // Assign the sender's email
        $reciever = $request->email;
        $password = $request->password;
        $email = $request->email;

        Mail::to($request->email)->send(new loginMail($nom, $sender, $reciever, $email, $password));


        $user = new user();
        $user->nom = $request->nom;
        $user->prenom = $request->prenom;
        $user->cin = $request->cin;
        $user->email = $request->email;
        $user->adresse = $request->adresse;
        $user->tele = $request->tele;
        $user->photo = $chemin_img;
        $user->password = Hash::make($request->password);
        $user->role_id = $request->role;
        $user->save();




        // Redirect to a success page or perform other actions as needed
        return redirect()->route('Dash.index')->with('success', 'Admin added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $user)
    {
        $findProfile = user::where('user.id', $user)
            ->select(
                'user.*',
                'user.id as idU',
                'r.libelle',
                'r.id as idRole'
            )
            ->join('role as r', 'r.id', 'user.role_id')
            ->first();
        $roles = role::all();
        // dd($findProfile);
        return view('profile.AfficherProfile', compact('findProfile', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, int $user)
    {
        $findUser = user::where('user.id', $user)->first();

        $validatedData = Validator::make($request->all(), [
            'profileIimage' => 'image|max:1050',
            'email' => 'email:rfc,dns',
            'nom' => 'string|max:30',
            'prenom' => 'string|max:55',
            'adresse' => 'string|max:70',
            'cin' => 'string|max:7|unique:user,cin,' . $findUser->id,
            'tele' => 'string|max:10|min:10|unique:user,tele,' . $findUser->id,
            'password' => 'string|min:8|max:30|confirmed',
            'role' => ''
        ]);

        if ($validatedData->fails()) {
            return back()->withErrors($validatedData)->withInput();
        }
        $chemin_img = $findUser->photo; // Initialize the variable

        if ($request->hasFile('profileIimage')) {
            if (isset($chemin_img)) {
                if (Storage::disk('public')->exists($chemin_img)) {
                    try {
                        Storage::disk('public')->delete($chemin_img);
                    } catch (\Exception $e) {
                        // Log the error message for debugging
                        Log::error($e->getMessage());
                    }
                }
            }
            $chemin_img = $request->file('profileIimage')->store('users', 'public');
        }


        $findUser->nom = $request->nom ?: $findUser->nom;
        $findUser->prenom = $request->prenom ?: $findUser->prenom;
        $findUser->cin = $request->cin ?: $findUser->cin;
        $findUser->email = $request->email ?: $findUser->email;
        $findUser->adresse = $request->adresse ?: $findUser->adresse;
        $findUser->tele = $request->tele ?: $findUser->tele;
        $findUser->photo = $chemin_img;
        if (!empty($request->password)) {
            $findUser->password = Hash::make($request->password);
        }

        $findUser->role_id = $request->role ?: $findUser->role_id;
        $findUser->save();

        // Redirect to a success page or perform other actions as needed
        return redirect()->route('Dash.index')->with('success', 'Admin modified successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $user)
    {
        $findAdmin = user::where('user.id', $user)->first();

        if ($findAdmin->role_id == 1) {
            return redirect()->route('Profile.index')->with('fails', ' can not delete an Admin with all privilage');
        }
        $imagePath = trim($findAdmin->photo); // Trim the image path

        if (Storage::disk('public')->exists($imagePath)) {
            Storage::disk('public')->delete($imagePath);
        }

        $findAdmin->delete();
        return redirect()->route('Profile.index')->with('success', 'Admin deleted successfully');
    }

    public function editAdmin(int $user)
    {
        $findProfile = user::where('user.id', $user)
            ->select(
                'user.*',
                'user.id as idU',
                'r.libelle',
                'r.id as idRole'
            )
            ->join('role as r', 'r.id', 'user.role_id')
            ->first();
        $roles = role::all();
        // dd($findProfile);
        return view('profile.editAdmin', compact('findProfile', 'roles'));
    }

    public function updateAdmin(Request $request, int $user)
    {
        $findUser = user::where('user.id', $user)->first();

        $validatedData = Validator::make($request->all(), [
            'profileIimage' => 'image|max:1050',
            'email' => 'email:rfc,dns',
            'nom' => 'string|max:30',
            'prenom' => 'string|max:55',
            'adresse' => 'string|max:70',
            'cin' => 'string|max:7|unique:user,cin,' . $findUser->id,
            'tele' => 'string|max:10|min:10|unique:user,tele,' . $findUser->id,
            'password' => 'string|min:8|max:30|confirmed',
            'role' => ''
        ]);

        if ($validatedData->fails()) {
            return back()->withErrors($validatedData)->withInput();
        }
        $chemin_img = $findUser->photo; // Initialize the variable

        if ($request->hasFile('profileIimage')) {
            if (isset($chemin_img)) {
                if (Storage::disk('public')->exists($chemin_img)) {
                    try {
                        Storage::disk('public')->delete($chemin_img);
                    } catch (\Exception $e) {
                        // Log the error message for debugging
                        Log::error($e->getMessage());
                    }
                }
            }
            $chemin_img = $request->file('profileIimage')->store('users', 'public');
        }


        $findUser->nom = $request->nom ?: $findUser->nom;
        $findUser->prenom = $request->prenom ?: $findUser->prenom;
        $findUser->cin = $request->cin ?: $findUser->cin;
        $findUser->email = $request->email ?: $findUser->email;
        $findUser->adresse = $request->adresse ?: $findUser->adresse;
        $findUser->tele = $request->tele ?: $findUser->tele;
        $findUser->photo = $chemin_img;
        if (!empty($request->password)) {
            $findUser->password = Hash::make($request->password);
        }

        $findUser->role_id = $request->role ?: $findUser->role_id;
        $findUser->save();

        // Redirect to a success page or perform other actions as needed
        return redirect()->route('Profile.index')->with('success', 'Admin modified successfully');
    }
}
