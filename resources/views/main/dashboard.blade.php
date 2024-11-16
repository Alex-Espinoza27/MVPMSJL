{{-- 
@if (session('ok'))
<script>
    showMessageSweet('success', 'Registrado!', '{{ session('ok') }}')
</script>
@endif

@if (session('success'))
<script>
    console.log('{{ session('success') }}');
    showMessageSweet('success', 'Registrado!', '{{ session('success') }}')
</script>
@endif

@if (session('error'))
<script>
    console.log('{{ session('error') }}');
    showMessageSweet('error', 'Error!', '{{ session('error') }}')
</script>
@endif --}}


<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-0">
                    <div id="user_map" class="pro-map" style="height: 220px">
                        <img src="{{asset('images/muni-sjl.jpg')}}" alt=""   class="w-100 h-110">
                    </div>

                </div><!--end card-body-->
                <div class="card-body">
                    <div class="dastone-profile">
                        <div class="row">
                            <div class="col-lg-4 align-self-center mb-3 mb-lg-0">
                                <div class="dastone-profile-main">
                                    <div class="dastone-profile-main-pic">
                                        <img src="{{ asset('assets/images/users/user-8.jpg') }}" alt="" height="110"
                                            class="rounded-circle">
                                        <span class="dastone-profile_main-pic-change">
                                            <i class="fas fa-camera"></i>
                                        </span>
                                    </div>  
                                    <div class="dastone-profile_user-detail">
                                        <h5 class="dastone-user-name">{{session('user')->USU_RAZON_SOCIAL}}</h5>
                                        <p class="mb-0 dastone-user-name-post ">{{session('ROL_USER')->ROL_NOMBRE}}</p>
                                    </div>
                                </div>
                            </div><!--end col-->

                            <div class="col-lg-6 ms-auto align-self-center">
                                <ul class="list-unstyled personal-detail mb-0">
                                    <li class=""><i
                                            class="ti ti-mobile me-2 text-secondary font-16 align-middle"></i> <b> Teléfono
                                        </b> {{session('USUARIO_REPRESENTANTE')? 'requesentante : '. session('USUARIO_REPRESENTANTE')->USU_NU_CELULAR : ': ' .session('user')->USU_NU_CELULAR  }}</li>
                                    <li class="mt-2"><i
                                            class="ti ti-email text-secondary font-16 align-middle me-2"></i> <b> Email
                                        </b> {{session('USUARIO_REPRESENTANTE') ? 'requesentante : '. session('USUARIO_REPRESENTANTE')->USU_CORREO : ': ' .session('user')->USU_CORREO  }} </li>
                                     
                                    <li class="mt-2"><i
                                        class="ti ti-world text-secondary font-16 align-middle me-2"></i> <b>
                                        Fecha Ingreso </b> : {{session('FECHA_INGRESO')}}
                                </li>
                                </ul>

                            </div><!--end col-->
                        </div><!--end row-->
                    </div><!--end f_profile-->
                </div><!--end card-body-->
            </div> <!--end card-->
        </div><!--end col-->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="row justify-content-center">
                <div class="col-md-3">
                    <div class="card report-card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col">
                                    <p class="text-dark mb-0 fw-semibold">Documentos Solicitados</p>
                                    <h3 class="m-0">150</h3>
                                    {{-- <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>8.5%</span> Documentos </p> --}}
                                </div>
                                <div class="col-auto align-self-center">
                                    <div class="report-main-icon bg-light-alt">
                                        <i data-feather="users" class="align-self-center text-muted icon-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
                <div class="col-md-3">
                    <div class="card report-card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col">
                                    <p class="text-dark mb-0 fw-semibold">Documentos Observados</p>
                                    <h3 class="m-0">5</h3>
                                    {{-- <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>1.5%</span>Documentos</p> --}}
                                </div>
                                <div class="col-auto align-self-center">
                                    <div class="report-main-icon bg-light-alt">
                                        <i data-feather="clock" class="align-self-center text-muted icon-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
                <div class="col-md-3">
                    <div class="card report-card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col">
                                    <p class="text-dark mb-0 fw-semibold">Documentos Subsanados</p>
                                    <h3 class="m-0">12</h3>
                                    {{-- <p class="mb-0 text-truncate text-muted"><span class="text-danger"><i class="mdi mdi-trending-down"></i>35%</span>Documentos</p> --}}
                                </div>
                                <div class="col-auto align-self-center">
                                    <div class="report-main-icon bg-light-alt">
                                        <i data-feather="activity" class="align-self-center text-muted icon-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
                <div class="col-md-3">
                    <div class="card report-card">
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col">
                                    <p class="text-dark mb-0 fw-semibold">Documentos Validados</p>
                                    <h3 class="m-0">8</h3>
                                    {{-- <p class="mb-0 text-truncate text-muted"><span class="text-success"><i class="mdi mdi-trending-up"></i>10.5%</span>Documentos</p> --}}
                                </div>
                                <div class="col-auto align-self-center">
                                    <div class="report-main-icon bg-light-alt">
                                        <i data-feather="briefcase" class="align-self-center text-muted icon-sm"></i>
                                    </div>
                                </div>
                            </div>
                        </div><!--end card-body-->
                    </div><!--end card-->
                </div> <!--end col-->
            </div><!--end row-->

        </div><!--end col-->

    </div>
</div>
