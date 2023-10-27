@extends('master')
@section('title','Modifier Absence')
    
@section('content')
<div id="container">
    <div id="AjouterAbsence" >
        <h1 id="" style="">Modifier Absence</h1>
    </div>

    <form id="formAbs" action="{{ route('Abs.update',$findAbs->idAbs) }}" method="Post">
      @csrf
      @method('PUT')
        <div id="form-row">
            
            <div id="form-group">
              <label for="stagiaireId">Stagiaire</label>
              <select id="stagiaireId" name="stagiaireId"  
              class="@error('stagiaireId') invalid-input @enderror">
                  <option value="stagiaire" disabled selected >{{$findAbs->nomStg}} {{$findAbs->prenomStg}}</option>
              </select> 
              @error('stagiaireId')
                    <p id="error-msg">{{$message}}</p>
              @enderror          
          </div>

          <div id="form-group">
            <label for="dateAbs">Date Absence:</label>
            <input type="date" id="dateAbs" name="dateAbs" 
            class="@error('dateAbs') invalid-input @enderror"

            value='{{$findAbs->dateAbs}}'>
            @error('dateAbs')
                <p id="error-msg">{{$message}}</p>
            @enderror    
          </div>
          
        </div>

        <div id="form-row">
                <div id="form-group">
                    <label for="FormateurId">Formateur</label>
                    <select id="FormateurId" name="FormateurId" 
                    class="@error('FormateurId') invalid-input @enderror" value='{{old('FormateurId')}}'>

                    <option value="{{$findAbs->idFrm}}" disabled selected>{{$findAbs->nomFrm}} {{$findAbs->prenomFrm}}</option>
                    @foreach ($allFormateur as $frm)
                      <option value="{{$frm->id}}">{{$frm->nom}} {{$frm->prenom}}</option>
                      @endforeach

                    </select>
                    @error('FormateurId')
                      <p id="error-msg">{{$message}}</p>
                    @enderror  

                </div>            

                <div id="form-group">
                  <label for="moduleId">module</label>
                  <select id="moduleId" name="moduleId" 
                  class="@error('moduleId') invalid-input @enderror"
                  value='{{old('moduleId')}}'>

                  <option value="{{$findAbs->idMld}}" disabled selected>{{$findAbs->libelleModule}}</option>
                  @foreach ($allmodules as $mld)
                    <option value="{{$mld->id}}">{{$mld->libelleModule}}</option>
                     @endforeach
                  </select>    
                  @error('moduleId')
                      <p id="error-msg">{{$message}}</p>
                  @enderror       
                </div>

        </div>


        <div id="form-row">
            <div id="form-group">
              <label for="seance">Seance:</label>
              <select id="seance" name="seance" 
                class="@error('seance') invalid-input @enderror"
                value='{{old('seance')}}'>

                <option value="{{$findAbs->seance}}" selected disabled>seance {{$findAbs->seance}}</option>
                <option value="1">Seance 1</option>
                <option value="2">Seance 2</option>
                <option value="3">Seance 3</option>
                <option value="4">Seance 4</option>

              </select>
              @error('seance')
                    <p id="error-msg">{{$message}}</p>
              @enderror 
            </div>

            <div id="form-group">
                <label for="typeSeance">Type Seance:</label>
                <select id="typeSeance" name="typeSeance" 
                class="@error('typeSeance') invalid-input @enderror"
                value='{{old('typeSeance')}}'>

                  <option value="{{$findAbs->typeSeance}}" selected disabled>
                    {{$findAbs->typeSeance=='P'?'Presentielle':'distentielle'}}</option>

                  <option value="P">presentielle</option>
                  <option value="D">distentielle</option>
                </select>
                @error('typeSeance')
                      <p id="error-msg">{{$message}}</p>
                @enderror 

              </div>
        </div>

        <div id="form-row">
          <div id="form-group">
            <label for="typeJustif">Type justif:</label>
                <select id="typeJustif" name="typeJustif" 
                  class="@error('typeJustif') invalid-input @enderror"
                  value='{{old('typeJustif')}}'>

                  <option value="{{$findAbs->idJ}}" selected disabled>{{$findAbs->libelleJsf ?:'select type justif'}}</option>

                  @foreach ($allTypeJustif as $jsf)
                    
                  <option value="{{$jsf->id}}">{{$jsf->libelleJsf}}</option>
                  @endforeach
                </select>
                @error('typeJustif')
                      <p id="error-msg">{{$message}}</p>
                @enderror 

          </div>

          <div id="form-group">
            <label for="sanctionId">naature sanction</label>
                <select id="sanctionId" name="sanctionId" 
                  class="@error('sanctionId') invalid-input @enderror"
                  value='{{old('sanctionId')}}'>

                  <option value="{{$findAbs->idN}}" selected disabled>{{$findAbs->libelleSanc ?:'select type sanction'}}</option>
                  @foreach ($allSanction as $sanc)
                    
                  <option value="{{$sanc->id}}">{{$sanc->libelleSanc}}</option>
                  @endforeach
                </select> 
                
                @error('sanctionId')
                      <p id="error-msg">{{$message}}</p>
                @enderror 

          </div>
      </div>
    
        <div id="form-row">
              <div id="form-group">
                <label for="dateJsf">Date Justif:</label>
                <input type="date" id="dateJsf" name="dateJsf" 
                class="@error('dateJsf') invalid-input @enderror"
                value='{{$findAbs->dateJsf}}'>
                
                @error('dateJsf')
                      <p id="error-msg">{{$message}}</p>
                @enderror 
              </div>

            <div id="form-group">
              <label for="nbJoursJsf">Nb Jours Justif:</label>
              <input type="number" id="nbJoursJsf" name="nbJoursJsf" placeholder="Enter number of JSF days" 
              class="@error('nbJoursJsf') invalid-input @enderror"
              value='{{$findAbs->nbJoursJsf}}'>

              @error('nbJoursJsf')
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
    // Disable stagiaire select initially
    $('#stagiaireId').prop('disabled', true);
  
  });

  // Event listener for "Annuler" button click
  $('#annulerBtn').click(function() {
    // Reset the form
    $('#formAbs')[0].reset();
  });

  // Disable fields initially
$('#dateJsf').prop('disabled', true);
$('#nbJoursJsf').prop('disabled', true);
$('#sanctionId').prop('disabled', true);

// Event listener for type justification select change
$('#typeJustif').change(function() {
  var typeJustifId = $(this).val();

  // Enable dateJsf and nbJoursJsf based on type justification selection
  if (typeJustifId) {
    $('#dateJsf').prop('disabled', false);
    $('#nbJoursJsf').prop('disabled', false);
  }

  // Enable sanctionId if type justification is 3
  if (typeJustifId == 3) {
    $('#sanctionId').prop('disabled', false);
  } else {
    $('#sanctionId').prop('disabled', true);
  }
});

// Event listener for "Annuler" button click
$('#annulerBtn').click(function() {
  // Reset the form
  $('#formAbs')[0].reset();
});




</script> 

@endsection