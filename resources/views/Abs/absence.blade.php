@extends('master')
@section('title','Absence')



    
@section('content')
<div id="container">
    <div id="absenceGrid" >

                <h1 id="" style="margin-right:auto;">Absence</h1>
                
                <div id="AbsgridItem">
                    <a href="{{route('Abs.create')}}" id='btn_danger'>Ajouter</a>
                    <a href="{{ route('export-data') }}" id='btn_outline_danger'>Exporter</a>
                </div>
                
                <div id="AbsgridItem">
                    <form id="searchForm" action="{{ route('Abs.index') }}" method="GET">
                        <!-- Other filters -->
                        <input type="date" name="searchPerDate" id="searchPerDate">

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
                    <td>Section</td>
                    <td>Date</td>
                    <td>Seance</td>
                    <td>Formateur</td>
                    <td>Module</td>
                    <td>Note Discipline</td>
                    <td>Status</td>
                    <td>Operation</td>
                </tr>
            </thead>

            <tbody>
                @foreach ($absences as $Abs)   
                <tr>
                    <td>{{$Abs->nomStg}} {{$Abs->prenomStg}}</td>
                    <td>{{$Abs->codeSection}}</td>
                    <td>{{$Abs->dateAbs}}</td>
                    <td>{{$Abs->seance}}| {{$Abs->typeSeance}}</td>
                    <td>{{$Abs->nomFrm}} {{$Abs->prenomFrm}}</td>
                    <td>{{$Abs->libelleModule}}</td>
                    <td>{{$Abs->noteComportement+$Abs->noteAssiduite}}</td>
                    <td><span id="{{$Abs->absence_id === null? 'nonJustifier': 'justifier'}}">{{$Abs->absence_id === null? 'Non':'Oui'}}</span></td>
                    <td>
                        <span>
                            <a href="{{route('Abs.show',$Abs->idAbs)}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="Blue" class="bi bi-eye" viewBox="0 0 16 16">
                                <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z"/>
                            </svg>
                            </a>
                        </span>
                        <span>
                            
                            <a href="{{route('Abs.edit',$Abs->idAbs)}}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="green" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                            </svg>
                            </a>
                        </span>
                        <span>
                            <form action="{{route('Abs.destroy',$Abs->idAbs)}}" method="POST" @style('display:inline')>
                                @csrf
                                @method('DELETE')
                                <button type="submit"  onclick="return confirm('est ce que vous ete sure vus vouler supprimer cette absence?')" @style("background:none;border:none;padding:0;")>

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
    const searchPerDate = document.getElementById('searchPerDate');

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

   if (searchPerDate) {
        searchPerDate.addEventListener('keydown', function(event) {
            // Prevent form submission if the Enter key is pressed
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });

        searchPerDate.addEventListener('change', function() {
            // Submit the form when the select value changes
            document.getElementById('searchForm').submit();
        });
    }
</script>

@endsection