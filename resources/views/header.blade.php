<script type='text/javascript'> 
    var urljs = '@php echo URL('/').'/'; @endphp'
</script>

<style>

    @media (max-width: 1024px){
        .topbar .brand {
            width: 127px !important;
        }
    }
</style>


<nav class="navbar-custom p-10">    
    <ul class="list-unstyled topbar-nav float-end mb-0 ">                    

        <li class="dropdown">
            <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-bs-toggle="dropdown" href="#" role="button"
                aria-haspopup="false" aria-expanded="false">
                <span class="ms-1 nav-user-name hidden-sm">{{session('user')->USU_RAZON_SOCIAL}}</span>
                <img src="{{ asset('assets/images/users/user-8.jpg') }}" alt="profile-user" class="rounded-circle thumb-xs" />                                 
            </a>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="{{route('perfil')}}"><i data-feather="user" class="align-self-center icon-xs icon-dual me-1">
                    </i> Perfil</a>
                {{-- <a class="dropdown-item" href="{{route('cambiarClave')}}"><i data-feather="key" class="align-self-center icon-xs icon-dual me-1"></i> Cambiar clave</a> --}}

                <div class="dropdown-divider mb-0"></div>
                <a class="dropdown-item" href="{{route('logout')}}"><i data-feather="power" class="align-self-center icon-xs icon-dual me-1"></i> Salir</a>
            </div>
        </li>
    </ul><!--end topbar-nav-->

    <ul class="list-unstyled topbar-nav mb-0">                        
        <li>
            <button class="nav-link button-menu-mobile">
                <i data-feather="menu" class="align-self-center topbar-icon"></i>
            </button>
        </li> 
    </ul>
</nav>
