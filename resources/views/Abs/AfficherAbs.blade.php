@extends('master')
@section('title','Afficher Absence')
    
@section('content')
<div id="container">
  <div id="card">
      <div id="card-header">
          <h3>Information sur une Absence</h3>
      </div>

      <div id="card-body">
          <table>
              <tr>
                <td>Nom  et Prénom Stagiaire:</td>
                <td>{{ $findAbs->nomStg }} {{ $findAbs->prenomStg }}</td>
              </tr>
              <tr>
                  <td>Nom et Prénom Formateur:</td>
                  <td>{{ $findAbs->nomFrm }} {{ $findAbs->prenomFrm }}</td>
              </tr>

              <tr>
                <td>Code Section:</td>
                <td>{{ $findAbs->codeSection }}</td>
              </tr>
              <tr>
                  <td>Date Absence:</td>
                  <td>{{ $findAbs->dateAbs }}</td>
              </tr>

              <tr>
                  <td>Type:</td>
                  <td>{{ $findAbs->type =='A'?'Absence':'Retard'}}</td>
              </tr>
              <tr>
                  <td>Seance:</td>
                  <td>{{ $findAbs->seance }}</td>
              </tr>
              <tr>
                  <td>Type de seance:</td>
                  <td>{{ $findAbs->typeSeance =='P'?'Presentiel':'Distantiel'}}</td>
              </tr>
              

              <tr>
                  <td>Libellé Module:</td>
                  <td>{{ $findAbs->libelleModule }}</td>
              </tr>

              @if($findAbs->dateJsf)

                <tr>
                    <td>Date JSF:</td>
                    <td>{{ $findAbs->dateJsf }}</td>
                </tr>
              @endif 


              @if($findAbs->nbJoursJsf)

                <tr>
                    <td>Nombre de jours JSF:</td>
                    <td>{{ $findAbs->nbJoursJsf }}</td>
                </tr>

              @endif

              @if($findAbs->libelleJsf)

                <tr>
                  <td>Libellé JSF:</td>
                  <td>{{ $findAbs->libelleJsf == 'M' ? 'Motif' : ($findAbs->libelleJsf == 'Cm' ? 'Certificat' : 'Autorisation') }}</td>
                </tr>
              
              @endif 

              @if($findAbs->libelleSanc)
              <tr>
                  <td>Libellé Sanction:</td>
                  <td>{{ $findAbs->libelleSanc }}</td>
              </tr>
              @endif


              @if($findAbs->sanction)
                <tr>
                    <td>Sanction:</td>
                    <td>{{ $findAbs->sanction }}</td>
                </tr>
              @endif
          </table>
      </div>

      <div id="card-footer">
        <a href="{{ route('Abs.index') }}">Retourner</a>
      </div>
    
  </div>
</div>
    
      

      
</div>

@endsection