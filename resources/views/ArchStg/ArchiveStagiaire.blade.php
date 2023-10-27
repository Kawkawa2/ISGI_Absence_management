@extends('master')
@section('title','Stagiaire Archiver')



    
@section('content')
<div id="container">
    <div id="FiliereGrid" >

                <h1 id="" style="margin-right:auto;">Stagiaires archive</h1>
                
                <div id="AbsgridItem">
                    <a href="{{ route('export-Stagiaires-archive') }}" id='btn_outline_danger'>Exporter</a>
                </div>
                
                <div id="AbsgridItem">
                    <form id="searchForm" action="{{ route('ArchStg.index') }}" method="GET">

                        <select name="searchPerFiliere" id="searchPerFiliere">
                            <option value="" selected disabled>Filières</option>
                            @foreach ($allFilieres as $fil)
                                <option value="{{ $fil->id }}">{{ $fil->nomFiliere }} - {{$fil->option}}</option>
                            @endforeach
                        </select>

                        <select name="searchPerSection" id="searchPerSection">
                            <option value="Section" selected disabled>Sections</option>
                            @foreach ($allSections as $sec)
                                <option value="{{$sec->id}}">{{$sec->codeSection}}</option>
                            @endforeach
                        </select>
                    </form>
                </div>
            </div>
            
    </div>
    <div id="absenceTableGrid">    
        <table>
            <thead>
                <tr>
                    <td>Nom et Prenom</td>
                    <td>filiere</td>
                    <td>Section</td>
                    <td>Genre</td>
                    <td>Email</td>
                    <td>Telephone</td>
                    <td>Adress</td>
                    <td>Note Discipline</td>
                    <td>date Archive</td>

                    <td>Operation</td>
                </tr>
            </thead>

            <tbody>
                @foreach($stagaires as $Stg)
                <tr>
                    <td>{{$Stg->nom}} {{$Stg->prenom}}</td>
                    <td>{{$Stg->nomFiliere}}</td>
                    <td>{{$Stg->codeSection}}</td>
                    <td>{{$Stg->genre}}</td>
                    <td style="word-wrap: break-word; max-width:130px">{{$Stg->email}}</td>
                    <td>{{$Stg->tele}}</td>
                    <td>{{$Stg->adresse}}</td>
                    <td>{{$Stg->noteComportement+$Stg->noteAssiduite}}</td>
                    <td>{{$Stg->created_at}}</td>
                    <td>
                        <span>
                            <a href="{{route('ArchStg.show',$Stg->idStg)}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="Blue" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                            </a>
                        </span>
                        <span>
                            <form action="{{route('ArchStg.destroy',$Stg->idStg)}}" method="POST" @style('display:inline')>
                                @csrf
                                @method('DELETE')
                                <button type="submit"  onclick="return confirm('est ce que vous ete sure vus vouler supprimer ce stagiaire?')" @style("background:none;border:none;padding:0;")>

                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-trash3" viewBox="0 0 16 16">
                                        <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5ZM11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H2.506a.58.58 0 0 0-.01 0H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1h-.995a.59.59 0 0 0-.01 0H11Zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5h9.916Zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47ZM8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5Z"/>
                                    </svg>
                                </button>
                            </form>
                        </span>
                    </td>

                </tr>
                @endforeach



            </tbody>
        </table>


    </div>

</div>

<script>
    // Get the select elements
    const searchPerFiliere = document.getElementById('searchPerFiliere');
    const searchPerSection = document.getElementById('searchPerSection');

    // Add event listeners for the change event
    if (searchPerFiliere) {
        searchPerFiliere.addEventListener('change', function() {
            // Submit the form when the select value changes
            document.getElementById('searchForm').submit();
        });
    }

    if (searchPerSection) {
        searchPerSection.addEventListener('change', function() {
            // Submit the form when the select value changes
            document.getElementById('searchForm').submit();
        });
    }

   
</script>

@endsection