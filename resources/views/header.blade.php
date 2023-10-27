    {{-- ===================================sideBar ======================================= --}}

    <div id="navigation">
        <ul>
            <li>
                <a href="{{route('Dash.index')}}">
                    <span id="icon">
                        <ion-icon name="home-outline"></ion-icon>
                    </span>
                    <span id="logo">
                        <img src="{{asset('assets/images/logo.png')}}" alt="logo" srcset="" @style('width:150px')>
                    </span>
                </a>
            </li>

            <li>
                <a href="{{route('Dash.index')}}">
                    <span id="icon">
                        <ion-icon name="grid-outline"></ion-icon>
                    </span>
                    <span id="title">Dashboard</span>
                </a>
            </li>

            <li>
                
                <a href="{{route('Abs.index')}}">
                    <span id="icon">
                        <ion-icon name="person-add-outline"></ion-icon>                   
                    </span>
                    <span id="title">Absences</span>
                </a>
            </li>

            <li>
                <a href="{{route('Stg.index')}}">
                    <span id="icon">
                        <ion-icon name="person-outline"></ion-icon>
                    </span>
                    <span id="title">Stagiaires</span>
                </a>
            </li>

            <li>
                <a href="{{route('ArchStg.index')}}">
                    <span id="icon">
                        <ion-icon name="person-remove-outline"></ion-icon>
                    </span>
                    <span id="title">Deperdition</span>
                </a>
            </li>
            <li>
                <a href="{{route('Fil.index')}}">
                    <span id="icon">
                        <ion-icon name="library-outline"></ion-icon>                    
                    </span>
                    <span id="title">Filières</span>
                </a>
            </li>
            <li>
                <a href="{{route('Sec.index')}}">
                    <span id="icon">
                        <ion-icon name="people-outline"></ion-icon>  
                    </span>
                    <span id="title">Sections</span>
                </a>
            </li>


            <li>

                <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span id="icon">
                        <ion-icon name="log-out-outline"></ion-icon>
                    </span>
                    <span id="title">Se déconnecter</span>
                </a>
                
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                    @method('POST')
                </form>
                
                
            </li>
        </ul>
    </div>
    {{-- ====================================-navBar ======================================= --}}

    <div id="main">
        <div id="topbar">
            <div id="toggle">
                <ion-icon name="menu-outline"></ion-icon>
            </div> 

            <div id="search">
                <form id="searchForm2" action="{{ route('search') }}" method="GET">
                    <input type="hidden" name="url" value="{{ request()->fullUrl() }}">
                    <label>
                        <input type="text" placeholder="Chercher ici" name="searchQuery">
                        <ion-icon name="search-outline"></ion-icon>
                    </label>
                </form>
                
                
                
                
                
            </div>

            <div id="">   
                <a href="{{route('Profile.edit',Auth::user()->id)}}" id="user">                    
                    <span id="username" @style('text-transform:capitalize')>{{Auth::user()->nom}} {{Auth::user()->prenom}}</span>
                    <img src="{{Auth::user()->photo?asset('storage/' .Auth::user()->photo) : asset('assets/images/customer01.jpg')}}" alt="img profile">
                </a>
                  
              </div>
            

        </div>
        @if(session()->has('success'))
            <div class="alert-success success">
                <span class="closebtn">&times;</span>
                <strong>Success!</strong> {{session('success')}}.
            </div>
        @endif
        @if(session()->has('fails'))
        <div class="alert-danger fails">
            <span class="closebtn">&times;</span>
            <strong>fails!</strong> {{session('fails')}}.
        </div>
    @endif

          
        {{-- content will be displayed heere --}}
        @yield('content')

    
    </div>

    <script>
        // JavaScript code
        var closeBtn = document.getElementsByClassName("closebtn");
        var i;

        for (i = 0; i < closeBtn.length; i++) {
        closeBtn[i].addEventListener("click", function() {
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function() {
            div.style.display = "none";
            }, 600);
        });
        }

        // search functionality
        const search = document.getElementById('searchQuery');

        if (search) {
            search.addEventListener('keydown', function(event) {
            // Prevent form submission if the Enter key is pressed
            if (event.key === 'Enter') {
                event.preventDefault();
            }
        });

        search.addEventListener('change', function() {
            // Submit the form when the select value changes
            document.getElementById('searchForm2').submit();
        });
    }


    </script>


