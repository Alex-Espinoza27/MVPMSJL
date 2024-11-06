<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>{{ $page_title }}</title>
        <meta content="" name="description" />
        <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @include('topcss')
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body class="dark-sidenav navy-sidenav enlarge-menu-all">

        <div class="left-sidenav">
            <div class="brand">
                <a href="{{route('dashboard')}}" class="logo">
                    <span>
                        <img src="{{ asset('images/logo.png') }}" alt="logo-small" class="logo-sm">
                    </span>
                </a>
            </div>
            <div class="menu-content h-100" data-simplebar>
                <ul class="metismenu left-sidenav-menu">
                    @include('navbar')
                </ul>
            </div>
        </div>

        <div class="page-wrapper">
            <div class="topbar">            
                @include('header')
            </div>

            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="page-title-box">
                                <div class="row">
                                    <div class="col">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><a href="javascript:void(0);"><strong>{{ $page_directory }}</strong></a></li>
                                            <li class="breadcrumb-item active">{{ !empty($breadcrumb)?$breadcrumb:$page_directory }}</li>
                                        </ol>
                                    </div>
                                    <div class="col-auto align-self-center">
                                    
                                    </div>
                                </div>                                                       
                            </div>
                        </div>
                    </div>
                    
                    @include($page_directory . '.' . $page_name)
                </div>

                @include('footer')
            </div>
        </div>

        @include('jscripts')
        
    </body>

</html>