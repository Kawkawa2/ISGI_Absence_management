@extends('master')
@section('title','Modifier Stagaiaire')
    
@section('content')
<div id="container">
    <div id="AjouterAbsence" >
        <h1 id="" style="">Modifier Stagiaire</h1>
    </div>

    <form id="formAbs" action="{{ route('Stg.update',$findStg->idStg) }}" method="Post" enctype="multipart/form-data">
      @csrf
      @method('PUT')
        <div id="form-row">
            <div id="form-group">
              <label for="nom">Nom</label>
              <input type="text" id="nom" name="nom" 
              placeholder="Enter le nom "  
              class="@error('nom') invalid-input @enderror"
              value='{{$findStg->nom}}'>

              @error('nom')
                  <p id="error-msg">{{$message}}</p>
              @enderror  
            </div>
        
            <div id="form-group">
              <label for="prenom">Prenom</label>
              <input type="text" id="prenom" name="prenom" 
              placeholder="Enter le prenom " 
              class="@error('prenom') invalid-input @enderror"
              value='{{$findStg->prenom}}'>


              @error('prenom')
                  <p id="error-msg">{{$message}}</p>
              @enderror 
            </div>

        </div>
        <div id="form-row">
          <div id="form-group">
            <label for="genre">genre</label>
            <select id="genre" name="genre" 
            class="@error('genre') invalid-input @enderror">
              <option value="genre" selected disabled>select genre</option>
              <option value="F" {{ $findStg->genre == 'F' ? 'selected' : '' }}>Femme</option>
              <option value="H" {{ $findStg->genre == 'H' ? 'selected' : '' }}>Homme</option>
          </select>
            @error('genre')
                  <p id="error-msg">{{$message}}</p>
            @enderror 
          </div>
      
          <div id="form-group">
            <label for="cin">Cin</label>
            <input type="text" id="cin" name="cin" placeholder="Enter le CIN " 
            class="@error('cin') invalid-input @enderror"
            value='{{$findStg->cin}}'>

            @error('cin')
                  <p id="error-msg">{{$message}}</p>
            @enderror 
          </div>

        </div>
        <div id="form-row">
          <div id="form-group">
            <label for="email">email</label>
            <input type="text" id="email" name="email" placeholder="Enter l'email " 
            class="@error('email') invalid-input @enderror"
            value='{{$findStg->email}}'>

            @error('email')
                  <p id="error-msg">{{$message}}</p>
            @enderror 
          </div>
      
          <div id="form-group">
            <label for="tele">Telephone</label>
            <input type="number" id="tele" name="tele" placeholder="Enter le 
            class="@error('tele') invalid-input @enderror"
            value='{{$findStg->tele}}'>

            @error('tele')
                  <p id="error-msg">{{$message}}</p>
            @enderror 
          </div>

        </div>
        <div id="form-row">
          <div id="form-group">
            <label for="adresse">Adresse</label>
            <input type="text" id="adresse" name="adresse" 
            placeholder="Enter l'adress " 
            class="@error('adresse') invalid-input @enderror"
            value='{{$findStg->adresse}}'>

            @error('adresse')
                  <p id="error-msg">{{$message}}</p>
            @enderror 
          </div>
      
          <div id="form-group">
            <label for="photo">photo</label>
            <input type="file" id="photo" name="photo" placeholder="Enter la photo "
            class="@error('photo') invalid-input @enderror"
            value='{{$findStg->photo}}'>

            @error('photo')
                  <p id="error-msg">{{$message}}</p>
            @enderror 
          </div>

        </div>

        <div id="form-row">
            <div id="form-group">
                <label for="dateN">Date Naissance:</label>
                <input type="date" id="dateN" name="dateN"
                class="@error('dateN') invalid-input @enderror"
                value='{{$findStg->dateNaissance}}'>

                @error('dateN')
                  <p id="error-msg">{{$message}}</p>
              @enderror 
            </div>
            <div id="form-group">
              <label for="dateIn">Date inscription:</label>
              <input type="text" id="dateIn" name="dateIn"
              class="@error('dateIn') invalid-input @enderror"
              value='{{$findStg->dateInscription}}'>

              @error('dateIn')
                  <p id="error-msg">{{$message}}</p>
              @enderror 
          </div>
            
        </div>
        <div id="form-row">
          <div id="form-group">
              <label for="dateBac">Annee bac:</label>
              <input type="text" id="dateBac" name="dateBac"
              class="@error('dateBac') invalid-input @enderror"
              value='{{$findStg->anneeBac}}'>

              @error('dateBac')
                  <p id="error-msg">{{$message}}</p>
              @enderror 
          </div>
          <div id="form-group">
            <label for="noteBac">Note Bac:</label>
            <input type="number" id="noteBac" name="noteBac" placeholder="enter la note du bac"
            class="@error('noteBac') invalid-input @enderror"
            value='{{$findStg->moyenBac}}'>

            @error('noteBac')
                  <p id="error-msg">{{$message}}</p>
            @enderror 
          </div>
  
      </div>

        <div id="form-row">
            <div id="form-group">
              <label for="mention">mention Bac:</label>
              <input type="text" id="mention" name="mention" required placeholder="enter la mention du bac"
              class="@error('mention') invalid-input @enderror"
              value='{{$findStg->mentionBac}}'>

              @error('mention')
                  <p id="error-msg">{{$message}}</p>
              @enderror 
            </div>
            <div id="form-group">
                <label for="SectionId">Section</label>
                <select id="SectionId" name="SectionId" 
                  class="@error('SectionId') invalid-input @enderror">
                  <option value="{{$findStg->idSec}}" disabled selected>{{$findStg->codeSection}} </option>
                  @foreach ($allSections as $sec)
                  <option value="{{$sec->id}}">{{$sec->codeSection}}</option>
                  @endforeach
          
                </select>
                @error('SectionId')
                  <p id="error-msg">{{$message}}</p>
                @enderror  
            </div>
        </div>

       
        
        <div id="form-row">
            <div id="form-group">
            <button type="submit">Modifier</button>
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

@endsection