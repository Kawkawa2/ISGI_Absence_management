@extends('master')
@section('title','Ajouter Stagiaire')
    
@section('content')
<div id="container">
    <div id="AjouterAbsence" >
        <h1 id="" style="">Ajouter Stagiaire</h1>
    </div>

    <form id="formAbs" action="{{ route('Stg.store') }}" method="Post" enctype="multipart/form-data">
      @csrf
        <div id="form-row">
            <div id="form-group">
              <label for="nom">Nom</label>
              <input type="text" id="nom" name="nom" 
              placeholder="Enter le nom "  
              class="@error('nom') invalid-input @enderror"
              value='{{old('nom')}}'>

              @error('nom')
                  <p id="error-msg">{{$message}}</p>
              @enderror  
            </div>
        
            <div id="form-group">
              <label for="prenom">Prenom</label>
              <input type="text" id="prenom" name="prenom" 
              placeholder="Enter le prenom " 
              class="@error('prenom') invalid-input @enderror"
              value='{{old('prenom')}}'>


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
              <option value="F" {{ old('genre') == 'F' ? 'selected' : '' }}>Femme</option>
              <option value="H" {{ old('genre') == 'H' ? 'selected' : '' }}>Homme</option>
          </select>
          

            @error('genre')
                  <p id="error-msg">{{$message}}</p>
            @enderror 
          </div>
      
          <div id="form-group">
            <label for="cin">Cin</label>
            <input type="text" id="cin" name="cin" placeholder="Enter le CIN " 
            class="@error('cin') invalid-input @enderror"
            value='{{old('cin')}}'>

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
            value='{{old('email')}}'>

            @error('email')
                  <p id="error-msg">{{$message}}</p>
            @enderror 
          </div>
      
          <div id="form-group">
            <label for="tele">Telephone</label>
            <input type="number" id="tele" name="tele" placeholder="Enter numero de tele"
            class="@error('tele') invalid-input @enderror"
            value='{{old('tele')}}'>

            @error('tele')
                  <p id="error-msg">{{$message}}</p>
            @enderror 
          </div>

        </div>
        <div id="form-row">
          <div id="form-group">
            <label for="adresse">Adresse</label>
            <input type="text" id="adresse" name="adresse" placeholder="Enter l'adress" 
            placeholder="Enter l'adress " 
            class="@error('adresse') invalid-input @enderror"
            value='{{old('adresse')}}'>

            @error('adresse')
                  <p id="error-msg">{{$message}}</p>
            @enderror 
          </div>
      
          <div id="form-group">
            <label for="photo">photo</label>
            <input type="file" id="photo" name="photo" placeholder="Enter la photo" 
            class="@error('photo') invalid-input @enderror"
            value='{{old('photo')}}'>

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
                value='{{old('dateN')}}'>

                @error('dateN')
                  <p id="error-msg">{{$message}}</p>
              @enderror 
            </div>
            <div id="form-group">
              <label for="dateIn">Date inscription:</label>
              <input type="text" id="dateIn" name="dateIn" placeholder="Enter le date d'inscription " 
              class="@error('dateIn') invalid-input @enderror"
              value='{{old('dateIn')}}'>


              @error('dateIn')
                  <p id="error-msg">{{$message}}</p>
              @enderror 
          </div>
            
        </div>
        <div id="form-row">
          <div id="form-group">
              <label for="dateBac">Annee bac:</label>
              <input type="text" id="dateBac" name="dateBac"  placeholder="Enter l'annee de Bac"
              class="@error('dateBac') invalid-input @enderror"
              value='{{old('dateBac')}}'>


              @error('dateBac')
                  <p id="error-msg">{{$message}}</p>
              @enderror 
          </div>
          <div id="form-group">
            <label for="noteBac">Note Bac:</label>
            <input type="number" id="noteBac" name="noteBac" placeholder="enter la note du bac"
            class="@error('noteBac') invalid-input @enderror"
            value='{{old('noteBac')}}'>


            @error('noteBac')
                  <p id="error-msg">{{$message}}</p>
            @enderror 
          </div>
  
      </div>

        <div id="form-row">
            <div id="form-group">
              <label for="mention">mention Bac:</label>
              <input type="text" id="mention" name="mention"  placeholder="enter la mention du bac"
              class="@error('mention') invalid-input @enderror"
              value='{{old('mention')}}'>

              @error('mention')
                  <p id="error-msg">{{$message}}</p>
              @enderror 
            </div>
            <div id="form-group">
                <label for="SectionId">Section</label>
                <select id="SectionId" name="SectionId"
                  class="@error('SectionId') invalid-input @enderror">
                  <option value="select section" disabled selected>select section</option>
                  
                  @foreach ($allSections as $sec)
                  <option value="{{$sec->id}}" {{ old('$sec->id') == $sec->id ? 'selected' : '' }}>{{$sec->codeSection}}</option>
                  @endforeach
          
                </select>
                @error('SectionId')
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