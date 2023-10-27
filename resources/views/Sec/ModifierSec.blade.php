@extends('master')
@section('title','Modifier Section')
    
@section('content')
<div id="container">
    <div id="AjouterAbsence" >
        <h1 id="" style="">Modifier Absence</h1>
    </div>

    <form id="formAbs" action="{{ route('Sec.update',$findSec->idSec) }}" method="Post">
      @csrf
      @method('PUT')
      <div id="form-row">
        <div id="form-group">
            <label for="Filiere">Filiere</label>
            <select id="Filiere" name="Filiere" class="@error('Filiere') invalid-input @enderror">
                <option value="" disabled selected>Select Filiere</option>
                @foreach($filieres as $fil)
                    <option value="{{$fil->id}}" {{ null !== old('Filiere') && old('Filiere') == $fil->id ? 'selected' : '' }}>{{$fil->nomFiliere}} - {{$fil->option}}</option>
                @endforeach
            </select>
            @error('Filiere')
                <p id="error-msg">{{$message}}</p>
            @enderror  
        </div>
    </div>
    
    

      <div id="form-row">
          <div id="form-group">
            <label for="codeS">code Section</label>
            <input type="text" id="codeS" name="codeS" placeholder="Enter le code de section " 
            class="@error('codeS') invalid-input @enderror"
            value='{{$findSec->codeSection}}'>

            @error('codeS')
                <p id="error-msg">{{$message}}</p>
            @enderror  
          </div>
      
          <div id="form-group">
            <label for="nomS">Nom Section</label>
            <input type="text" id="nomS" name="nomS" placeholder="Enter le nom de section " 
            class="@error('nomS') invalid-input @enderror"
            value='{{$findSec->nomSection}}'>

            @error('nomS')
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