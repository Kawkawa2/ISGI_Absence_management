@extends('master')
@section('title','Ajouter Absence')
    
@section('content')
<div id="container">
    <div id="AjouterAbsence" >
        <h1 id="" style="">Ajouter Absence</h1>
    </div>

    <form id="formAbs" action="{{ route('Abs.store') }}" method="Post">
      @csrf
        <div id="form-row">

            <div id="form-group">
                <label for="SectionId">Section</label>
                <select id="SectionId" name="SectionId" 
                  class="@error('stagiaireId') invalid-input @enderror">
                  <option value="Section" disabled selected>Select Section </option>
                  @foreach ($allSections as $sec)
                  <option value="{{$sec->id}}">{{$sec->codeSection}}</option>
                  @endforeach
          
                </select>
                @error('stagiaireId')
                        <p id="error-msg">il faut choisir une section pour choisir un stagiaire</p>
                @enderror  
            </div> 
            
            <div id="form-group">
              <label for="stagiaireId">Stagiaire</label>
              <select id="stagiaireId" name="stagiaireId"  
              class="@error('stagiaireId') invalid-input @enderror"
              value='{{old('stagiaireId')}}'>
                  <option value="stagiaire" disabled selected>Select stagiaire </option>
                  <!-- Dynamic options will be added using JavaScript -->
              </select> 
              @error('stagiaireId')
                    <p id="error-msg">{{$message}}</p>
              @enderror          
          </div>
          
        </div>

        <div id="form-row">
                <div id="form-group">
                    <label for="FormateurId">Formateur</label>
                    <select id="FormateurId" name="FormateurId" 
                    class="@error('FormateurId') invalid-input @enderror"
                    value='{{old('FormateurId')}}'>

                      <option value="">Select Formateur </option>
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

                    <option value="module" disabled selected>Select module </option>
                    @foreach ($allmodules as $mld)
                    <option value="{{$mld->id}}">{{$mld->libelleModule}}</option>
                     @endforeach
                  </select>    
                  @error('moduleId')
                      <p id="error-msg">{{$message}}</p>
                  @enderror       
                </div>

        </div>


        <div id="form-group">
                <label for="dateAbs">Date Absence:</label>
                <input type="date" id="dateAbs" name="dateAbs" 
                class="@error('dateAbs') invalid-input @enderror"
                value='{{old('dateAbs')}}'>
                @error('dateAbs')
                    <p id="error-msg">{{$message}}</p>
                @enderror    
        </div>

        <div id="form-row">
            <div id="form-group">
              <label for="seance">Seance:</label>
              <select id="seance" name="seance" 
                class="@error('seance') invalid-input @enderror"
                value='{{old('seance')}}'>
                <option value="seance" selected disabled>Select seance</option>
                <option value="1">Seance 1</option>
                <option value="2">Seance 2</option>
                <option value="3">Seance 3</option>
                <option value="3">Seance 4</option>

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

                  <option value="">Select type seance</option>
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

                  <option value="typeJustif" selected disabled>Select type Justif</option>
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

                  <option value="sanctionId" selected disabled>naature sanction</option>
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
                value='{{old('dateJsf')}}'>
                
                @error('dateJsf')
                      <p id="error-msg">{{$message}}</p>
                @enderror 
              </div>

            <div id="form-group">
              <label for="nbJoursJsf">Nb Jours Justif:</label>
              <input type="number" id="nbJoursJsf" name="nbJoursJsf" placeholder="Enter number of JSF days" 
              class="@error('nbJoursJsf') invalid-input @enderror"
              value='{{old('nbJoursJsf')}}'>

              @error('nbJoursJsf')
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
  // Disable stagiaire select initially
  $('#stagiaireId').prop('disabled', true);

  // Event listener for section select change
  $('#SectionId').change(function() {
    var sectionId = $(this).val();

    // Clear stagiaire select options
    $('#stagiaireId').empty();

    // If a section is selected, make an AJAX request to fetch the corresponding stagiaires
    if (sectionId) {
      $.ajax({
        url: '/get-stagiaires',
        type: 'GET',
        data: { section: sectionId },
        success: function(response) {
          // Populate stagiaire select with fetched stagiaires
          var stagiaires = response.stagiaires;
          $.each(stagiaires, function(index, stagiaire) {
            $('#stagiaireId').append('<option value="' + stagiaire.id + '">' + stagiaire.nom + ' ' + stagiaire.prenom + '</option>');
          });

          // Enable stagiaire select
          $('#stagiaireId').prop('disabled', false);
        },
        error: function(xhr) {
          console.log(xhr.responseText);
        }
      });
    } else {
      // If no section is selected, disable stagiaire select
      $('#stagiaireId').prop('disabled', true);
    }
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

});
</script>

@endsection