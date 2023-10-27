@extends('master')
@section('title','Afficher Filiere')
    
@section('content')
<div id="container">
    <div id="card">
        <div id="card-header">
          <h3>Information sur la filiere :{{$findFil->nomFiliere}}-{{$findFil->option}}</h3>
        </div>

        <div id="card-body">
          <table>
            <tr>
              <td>Nom:</td>
              <td>Valeur:</td>
            </tr>
            <tr>
              <td>code filiere</td>
              <td>{{$findFil->codeFiliere}}</td>
            </tr>
            <tr>
              <td>nom filieree</td>
              <td>{{$findFil->nomFiliere}}</td>
            </tr>
            <tr>
              <td>Option</td>
              <td>{{$findFil->option}}</td>
            </tr>
            <tr>
              <td>type formation</td>
              <td>{{$findFil->typeFormation}}</td>
            </tr>
            <tr>
              <td>niveau</td>
              <td>{{$findFil->niveau}}</td>
            </tr>
            <tr>
              <td>duree</td>
              <td>{{$findFil->duree}}</td>
            </tr>
            <tr>
              <td>modules</td>
              <td>{{$findFil->moduleCount}}</td>
            </tr>
            <tr>
              <td>modules</td>
              <td>{{$findFil->codeSection}}</td>
            </tr>
            <tr>
              <td>date creation</td>
              <td>{{$findFil->created_at}}</td>
            </tr>
          </table>
        </div>
        
        <div id="card-footer">
            <a href="{{route('Fil.index')}}">Retourner</a>
        </div>
    </div>
      
      

      
</div>

@endsection