@extends('master')
@section('title','Ajouter Filiere')
    
@section('content')
<div id="container">
    <div id="AjouterAbsence" >
        <h1 id="" style="">Ajouter Filiere</h1>
    </div>

    <form id="formAbs" action="{{ route('Fil.store') }}" method="Post">
      @csrf

        <div id="form-row">
          <div id="form-group">
            <label for="nomF">nom Filiere</label>
            <input type="text" id="nomF" name="nomF" placeholder="Enter le nom de la filiere " 
            class="@error('nomF') invalid-input @enderror"
            value='{{old('nomF')}}'>

            
            @error('nomF')
                  <p id="error-msg">{{$message}}</p>
            @enderror  
          
          </div>

            <div id="form-group">
              <label for="option">code Filiere</label>
              <input type="text" id="codeF" name="codeF" placeholder="Enter le code de la filiere " 
              class="@error('codeF') invalid-input @enderror"
              value='{{old('codeF')}}'>  
              @error('codeF')
                  <p id="error-msg">{{$message}}</p>
              @enderror  
            </div>

        </div>

        <div id="form-row">
          <div id="form-group">
            <label for="option">option</label>
            <input type="text" id="option" name="option" placeholder="Enter l'option " 
            class="@error('option') invalid-input @enderror"
            value='{{old('option')}}'> 
            
            @error('option')
                <p id="error-msg">{{$message}}</p>
            @enderror  
          </div>

            <div id="form-group">
                <label for="typeF">type formation</label>
                <select id="typeF" name="typeF" >
                  <option value="typeF" selected disabled>Select type formation </option>
                  <option value="Initial" {{old('typeF')=='Initial'?'selected':''}}>Initial</option>
                  <option value="qualifiante" {{old('typeF')=='qualifiante'?'selected':''}}>qualifiante</option>
                </select>
                @error('typeF')
                    <p id="error-msg">{{$message}}</p>
                @enderror  
              </div>
        </div>

        <div id="form-row">
          <div id="form-group">
            <label for="duree">duree</label>
            <input type="text" id="duree" name="duree" placeholder="Enter la duree de formation" 
            
            class="@error('duree') invalid-input @enderror"
            value='{{old('duree')}}'> 
            @error('duree')
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