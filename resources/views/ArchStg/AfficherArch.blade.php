@extends('master')
@section('title','Afficher Stagiaire archiver')
    
@section('content')
<div id="container">
    <div id="card">
        <div id="card-header">
          <h3>Information sur Stagiaire archiver </h3>
        </div>

        <div id="StgCard">
          <div id="StgImgCrd">
            <div id="gallery">
              
              <a target="_blank" href="{{$findStg->photo?asset('storage/' .$findStg->photo): asset('assets/images/customer01.jpg')}}">
                <img src="{{$findStg->photo?asset('storage/' .$findStg->photo): asset('assets/images/customer01.jpg')}}" 
                alt="stagiaire" width="600" height="400">
              </a>
              <div id="Nom"> {{$findStg->nom}}.{{$findStg->prenom}} </div>
            </div>
          </div>  
          <div id="StgInfoCrd">
              <ul>
                <li>filiere:
                  <span>{{$findStg->nomFiliere}}</span>
                </li>
                <li>Section: 
                  <span>{{$findStg->codeSection}}</span>
                </li>
                <li>Genre: 
                  <span>{{$findStg->genre=='F'?'Femme':'Homme'}}</span>
                </li>
                <li>Date Naissance : 
                  <span>{{$findStg->dateNaissance}}</span>
                </li>
                <li>Email : 
                  <span>{{$findStg->email}}</span>
                </li>
                <li>Telephone : 
                  <span>{{$findStg->tele}}</span>
                </li>
                <li>Adress : 
                  <span>{{$findStg->adresse}}</span>
                </li>
                <li>Date inscription : 
                  <span>{{$findStg->dateInscription}}</span>
                </li>
                @if($findStg->anneeBac)

                <li>Annee Bac : 
                  <span>{{$findStg->anneeBac}}</span>
                </li>
                @endif
                @if($findStg->mentionBac)

                <li>Montion Bac : 
                  <span>{{$findStg->mentionBac}}</span>
                </li>
                @endif
                @if($findStg->autreDiplome)
                  <li>autre diplome : 
                    <span>{{$findStg->autreDiplome}}</span>
                  </li>
                @endif
                <li>Note Discipline : 
                  <span>{{$findStg->noteComportement+$findStg->noteAssiduite}}</span>
                </li>
                <li>Date d'archive : 
                  <span>{{$findStg->created_at}}</span>
                </li>
              </ul>
          </div>
    </div>
    
        <div id="card-footer">
            <a href="{{route('ArchStg.index')}}">Retourner</a>
        </div>
    </div>
      
      

      
</div>

@endsection