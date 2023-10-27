@extends('master')
@section('title','Ajouter Admin')
    
@section('content')
<div id="container">
    <div id="AjouterAbsence" >
        <h1 id="" style="">Ajouter Admin</h1>
    </div>
    <form id="formAbs" action="{{route('Profile.store')}}" method="post" enctype="multipart/form-data">
        @csrf

        <div id="ImgProfile">
            <input type="file" id="profile-image" accept="image/*" name="profileIimage" hidden>
            <label for="profile-image" id="profile-image-label">
            <img src="{{asset('assets/images/customer01.jpg')}}" alt="profile-image" id="profile-image-preview">
            <span>Ajouter Profile Image</span>
            </label>
            @error('profile-image')
                <p id="error-msg">{{$message}}</p>
            @enderror 
        </div>
        <div id="form-row">
            <div id="form-group">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" value="{{old('nom')}}"
                class="@error('nom') invalid-input @enderror">
                @error('nom')
                    <p id="error-msg">{{$message}}</p>
                @enderror 
        
            </div>
            <div id="form-group">
                <label for="prenom">Prenom:</label>
                <input type="text" id="prenom" name="prenom" value="{{old('prenom')}}"
                class="@error('prenom') invalid-input @enderror">
                @error('prenom')
                    <p id="error-msg">{{$message}}</p>
                @enderror 
            </div>
            
        </div>
        <div id="form-row">
            <div id="form-group">
                <label for="cin">Cin:</label>
                <input type="text" id="cin" name="cin" value="{{old('cin')}}"
                class="@error('cin') invalid-input @enderror">
                @error('cin')
                    <p id="error-msg">{{$message}}</p>
                @enderror
            </div>
            <div id="form-group">
                <label for="tele">Tele:</label>
                <input type="text" id="tele" name="tele" value="{{old('tele')}}"
                class="@error('tele') invalid-input @enderror">
                @error('tele')
                    <p id="error-msg">{{$message}}</p>
                @enderror
            </div>
        </div>
        <div id="form-row">
            <div id="form-group">
                <label for="email">email:</label>
                <input type="text" id="email" name="email" value="{{old('email')}}"
                class="@error('email') invalid-input @enderror">
                @error('email')
                    <p id="error-msg">{{$message}}</p>
                @enderror
            </div>
            <div id="form-group">
                <label for="adresse">adresse:</label>
                <input type="text" id="adresse" name="adresse" value="{{old('adresse')}}"
                class="@error('adresse') invalid-input @enderror">
                @error('adresse')
                    <p id="error-msg">{{$message}}</p>
                @enderror
            </div>
        </div>
        <div id="form-row">
            <div id="form-group">
                <label for="password">password:</label>
                <input type="password" id="password" name="password" value="{{old('password')}}"
                class="@error('password') invalid-input @enderror">
                @error('password')
                    <p id="error-msg">{{$message}}</p>
                @enderror
            </div>
            <div id="form-group">
                <label for="password_confirmation">verify password:</label>
                <input type="password" id="password_confirmation" name="password_confirmation" value="{{old('password_confirmation')}}"
                class="@error('password_confirmation') invalid-input @enderror">
                @error('password_confirmation')
                    <p id="error-msg">{{$message}}</p>
                @enderror
            </div>
        </div>
        <div id="form-row">
            <div id="form-group">
                <label for="role">role</label>
                <select id="role" name="role">
                  <option value="" selected>select role</option>
                  @foreach ($roles as $item)
                    <option value="{{$item->id}}" {{$item->id === old('role')? 'selected' : ''}}>{{$item->libelle}}</option>
                  @endforeach
                </select>
                @error('role')
                    <p id="error-msg">{{$message}}</p>
                @enderror

            </div>
        </div>
        <div id="form-row">
            <div id="form-group">
            <button type="submit">Ajouter</button>
            <button type="reset" id="annulerBtn">Annuler</button>
            </div>
        </div>
    </form>
      
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