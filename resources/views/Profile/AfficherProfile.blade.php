@extends('master')
@section('title','Afficher Profile')
    
@section('content')
<div id="container">
    <div id="FiliereGrid" >

        <h1 id="" style="margin-right:auto;">Profile</h1>
        @if(Auth()->user()->role_id==1)
            <div id="AbsgridItem">
                <a href="{{route('Profile.index')}}" id='btn_danger'>Lister Admin</a>
            </div>
        @endif
    </div>
    
</div>
    <div id="card">
        <form id="
        profile-form" action="{{route('Profile.update',$findProfile->id)}}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PUT')
            <div id="ImgProfile">
                <input type="file" id="profile-image" accept="image/*" name="profileIimage" hidden>
                <label for="profile-image" id="profile-image-label">
                <img src="{{$findProfile->photo? asset('storage/' .$findProfile->photo) :asset('assets/images/customer01.jpg')}}" alt="profile-image" id="profile-image-preview">
                <span>Change Profile Image</span>
                </label>
                @error('profile-image')
                    <p id="error-msg">{{$message}}</p>
                @enderror 
            </div>

            <div id="profile-container">
                    <div id="form-row">
                        <div id="form-group">
                            <label for="nom">Nom:</label>
                            <input type="text" id="nom" name="nom" value="{{$findProfile->nom}}">
                            @error('nom')
                                <p id="error-msg">{{$message}}</p>
                            @enderror 
                        </div>
                        <div id="form-group">
                            <label for="prenom">Prenom:</label>
                            <input type="text" id="prenom" name="prenom" value="{{$findProfile->prenom}}">
                            @error('prenom')
                                <p id="error-msg">{{$message}}</p>
                            @enderror 
                        </div>
                        
                    </div>
                    <div id="form-row">
                        <div id="form-group">
                            <label for="cin">Cin:</label>
                            <input type="text" id="cin" name="cin" value="{{$findProfile->cin}}">
                            @error('cin')
                                <p id="error-msg">{{$message}}</p>
                            @enderror
                        </div>
                        <div id="form-group">
                            <label for="tele">Tele:</label>
                            <input type="text" id="tele" name="tele" value="{{$findProfile->tele}}">
                            @error('tele')
                                <p id="error-msg">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div id="form-row">
                        <div id="form-group">
                            <label for="email">email:</label>
                            <input type="text" id="email" name="email" value="{{$findProfile->email}}">
                            @error('email')
                                <p id="error-msg">{{$message}}</p>
                            @enderror
                        </div>
                        <div id="form-group">
                            <label for="adresse">adresse:</label>
                            <input type="text" id="adresse" name="adresse" value="{{$findProfile->adresse}}">
                            @error('adresse')
                                <p id="error-msg">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div id="form-row">
                        <div id="form-group">
                            <label for="password">password:</label>
                            <input type="password" id="password" name="password" value="">
                            @error('password')
                                <p id="error-msg">{{$message}}</p>
                            @enderror
                        </div>
                        <div id="form-group">
                            <label for="password_confirmation">verify password:</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}">
                            @error('password_confirmation')
                                <p id="error-msg">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                    <div id="form-row">
                        <div id="form-group">
                            <label for="role">role</label>
                            <select id="role" name="role" required>
                            <option value="{{$findProfile->idRole}}" selected>{{$findProfile->libelle}} </option>
                            @foreach ($roles as $item)
                                <option value="{{$item->id}}" {{$item->id===$findProfile->idRole?'selected':''}}>{{$item->libelle}}</option>
                            @endforeach
                            </select>
                            @error('role')
                                <p id="error-msg">{{$message}}</p>
                            @enderror
                        </div>
                    </div>
                
                <!-- Add more fields as needed -->
            
                <button type="submit" @style('background-color:#337ab7')>Modifier</button>
                <button type="reset" id="annulerBtn" @style('background-color:#23527c;border:none;color:white')>Annuler</button>

    </div>
  
    <div id="card-footer">
        <a href="{{route('Dash.index')}}">Retourner</a>
    </div>
</div>
      
      
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

$(document).ready(function() {

// Event listener for "Annuler" button click
$('#annulerBtn').click(function() {
  // Reset the form
  $('#formAbs')[0].reset();
});

});
</script>


@endsection