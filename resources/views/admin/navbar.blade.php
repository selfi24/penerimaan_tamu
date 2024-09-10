<!-- Spinner Start -->

    <!-- Spinner End -->
    

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top p-0">
    <a href="/" class="navbar-brand d-flex align-items-center px-2 px-lg-5">
    <img src="{{asset('img/logo.png')}}" alt="" style="width: 100px; height: auto;;">
        <h2 class="m-0 text-primary ms-0">DISKOMINFO</h2>
    </a>
        <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto p-4 p-lg-0">
                <a href="/" class="nav-item nav-link active">Home</a>
                <a href="{{ route('buku_tamu') }}" class="nav-item nav-link">Buku Tamu</a>
                <a href="{{ route('tamu') }}" class="nav-item nav-link">Entry Tamu</a>
                <a href="{{ route('contact') }}" class="nav-item nav-link">Contact Us</a>
               
            @if (Route::has('login'))
                            
                                @auth
                                
                                <a href="{{ route('tamu') }}" class="nav-item nav-link">TAMU</a>
                                <a href="{{ route('buku_tamu') }}" class="nav-item nav-link">Courses</a>
                                <a href="{{ route('profile.show') }}"class="nav-item nav-link">Profil</a>
                               
                                <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <input class="btn btn-primary py-4 px-lg-5 d-none d-lg-block" type="submit"  value="Logout">
                                @else
                                <a href="{{ route('login') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Login<i class="fa fa-arrow-right ms-3"></i></a>
                                
                                    @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="btn btn-primary py-4 px-lg-5 d-none d-lg-block">Register<i class="fa fa-arrow-right ms-3"></i></a>  

                                    @endif
                                @endauth
                            
                        @endif
                 
        </div>
    </nav>
    <!-- Navbar End -->