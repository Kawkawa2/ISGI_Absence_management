@extends('master')
@section('title','Afficher Section')
    
@section('content')
<div id="container">
    <div id="card">
        <div id="card-header">
          <h3>Information sur la Section: {{$findSec->nomSection}} </h3>
        </div>

        <div id="card-body">
          <table>
            <tr>
              <td>Nom:</td>
              <td>Valeur:</td>
            </tr>
            <tr>
              <td>Filiere</td>
              <td>{{$findSec->nomSection}}</td>
            </tr>
            <tr>
              <td>Option</td>
              <td>{{$findSec->option}}</td>
            </tr>
            <tr>
              <td>nom Section</td>
              <td>{{$findSec->nomSection}}</td>
            </tr>
            <tr>
              <td>code Section</td>
              <td>{{$findSec->codeSection}}</td>
            </tr>
            <tr>
              <td>Nombre Stagiaire</td>
              <td>{{$findSec->StgCount}}</td>
            </tr>
            <tr>
              <td>date creation</td>
              <td>{{$findSec->created_at}}</td>
            </tr>
          </table>
        </div>
        
        <div id="card-footer">
            <a href="{{route('Sec.index')}}">Retourner</a>
        </div>
    </div>
      
      

      
</div>

@endsection