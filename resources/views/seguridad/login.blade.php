<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Mesa de Partes Virtual SJL</title>
    <meta content="Mesa de partes virtual San Juan de Lurigancho" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <div class="container-fluid">
        <div class="row vh-100">
            <div class="col-12">
                <div class="card-body p-0">
                    <div class="row d-flex align-items-center">
                        <div class="col-md-6 col-xl-3 col-lg-4">
                            <div class="card mb-0 border-0">
                                <div class="card-body p-0">
                                    {{-- <div class="alert alert-danger alert-dismissible fade show" role="alert" id="mensaje" style="display: none;">
                                        <i class="mdi mdi-block-helper mr-2"></i>
                                        Ups!, verifiqué sus datos de acceso!
                                    </div> --}}

                                    <div class="text-center p-3">
                                        <a href="#" class="logo logo-admin">
                                            <img src="images/logo.png" height="80" alt="logo" >
                                        </a>
                                        <h4 class="mt-3 mb-1 font-22 fw-bold">Mesa de Partes Virtual MSJL</h4>
                                        <br>
                                        <p class="text-muted  mb-0">Iniciar Sesión</p>
                                    </div>
                                </div>

                                <div class="card-body pt-0">
                                    @if (session('error'))
                                        <script>
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: "top-end",
                                                showConfirmButton: false,
                                                timer: 2000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    // toast.onmouseenter = Swal.stopTimer;
                                                    toast.onmouseleave = Swal.resumeTimer;
                                                }
                                            });
                                            Toast.fire({
                                                icon: 'error',
                                                title: '{{ session('error') }}'
                                            });
                                        </script>
                                    @endif
                                    @if (session('ok'))
                                        <script>
                                            const Toast = Swal.mixin({
                                                toast: true,
                                                position: "top-end",
                                                showConfirmButton: false,
                                                timer: 2000,
                                                timerProgressBar: true,
                                                didOpen: (toast) => {
                                                    toast.onmouseleave = Swal.resumeTimer;
                                                }
                                            });
                                            Toast.fire({
                                                icon: 'success',
                                                title: '{{ session('ok') }}'
                                            });
                                        </script>
                                    @endif

                                    <form class="form-parsley" action="{{ route('login.submit') }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-2 ">
                                            <label class="form-label">Tipo de Persona</label>
                                            <select name="P_TIPO_PERSONA" class="form-select" id="P_TIPO_PERSONA"
                                                required>
                                                <option value="1" selected="">Persona Natural</option>
                                                <option value="2">Persona Jurídica</option>
                                            </select>
                                        </div>
                                        <div class="form-group mb-2 " id="GROUP-RUC" style="display: none;">
                                            <label class="form-label" for="P_RUC">RUC de la Empresa</label>
                                            <div class="input-group">
                                                <input type="text" maxlength="11" class="form-control" name="P_RUC"
                                                    id="P_RUC" placeholder="Ingrese el RUC"
                                                    oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                            </div>
                                        </div>
                                        <div class="col-md-12" id="GROUP-TIPO-DOC">
                                            <div class="form-group mt-2 ">
                                                <label class="form-label">Tipo Documento de Identidad</label>
                                                <select name="P_TIPO_DOCUMENTO" class="form-select"
                                                    id="P_TIPO_DOCUMENTO">
                                                    <option value="1" selected="">Documento Nacional de
                                                        Identidad</option>
                                                    <option value="2">Carné de Extranjería</option>
                                                    <option value="3">Pasaporte</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row" id="GROUP-NRO_DOC">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="form-label" for="P_NRO_DOCUMENTO">Número de
                                                        Documento</label>
                                                    <input type="text" class="form-control" name="P_NRO_DOCUMENTO"
                                                        id="P_NRO_DOCUMENTO" placeholder="Ingrese el numero" required
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label class="form-label" for="P_CLAVE">Contraseña</label>
                                                <input type="password" id="P_CLAVE" name="P_CLAVE"
                                                    class="form-control"  required aria-describedby="password-addon" />
                                            </div>
                                        </div>
                                        <div class="form-group row my-3">
                                            <div class="col-md-6">
                                                <div class="custom-control custom-switch switch-success">
                                                    <input type="checkbox" class="custom-control-input"
                                                        id="P_RECORDAR_CLAVE">
                                                    <label class="form-label text-muted"
                                                        for="P_RECORDAR_CLAVE">Recordar Contraseña</label>
                                                </div>
                                            </div><!--end col-->
                                            <div class="col-sm-6 text-end">
                                                <a href="auth-recover-pw.html" class="text-muted font-13"><i
                                                        class="dripicons-lock"></i> ¿Olvidaste la clave?</a>
                                            </div><!--end col-->
                                        </div>

                                        <div class="form-group mb-0 d-flex justify-content-center aling-item-center">
                                            <div class="col-6 ">
                                                <button class="btn btn-danger w-100 waves-effect waves-light"
                                                    type="submit">Iniciar Sesión <i
                                                        class="fas fa-sign-in-alt ms-1"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="m-3 text-center text-muted">
                                        <p class="mb-0">No tienes una cuenta? <a
                                                href="{{ route('seguridad.registrar') }}"
                                                class="text-info ms-2">¡Regístrate ahora!</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 col-xl-9 col-lg-8  p-0 vh-100 d-flex justify-content-center auth-bg">
                            <div class="accountbg d-flex align-items-center">
                                <div class="account-title text-center text-white">
                                    <div class="row justify-content-center">
                                        <div class="col-md-4">
                                            <h4 class="mt-3 text-white font-22 fw-bold">Bienvenido a la <span class="text-white">Mesa
                                                    de Partes Virtual SJL</span> </h4>
                                            {{-- <br> --}}
                                            <div class="border w-50 mx-auto border-info"></div> 
                                        </div>
                                    </div>
                                    <div class="row justify-content-center">
                                        <div class="col-md-6">
                                            <p style="text-align: justify;" class="font-14 m-4">
                                                La Municipalidad de San Juan de Lurigancho pone a disposición de sus 
                                                vecinos esta plataforma virtual como un canal moderno para la presentación 
                                                de documentos y solicitudes. A través de este servicio, buscamos facilitar 
                                                la gestión de trámites administrativos y promover una interacción directa 
                                                y eficiente con la comunidad.
                                                <br>
                                                Importante a considerar:<br>
                                            </p>
                                            <ul class="text-start">
                                                <li>Acceso al sistema: Para enviar documentos, asegúrese de ingresar correctamente con sus datos de usuario.</li>
                                                <li>Contenido de los documentos: La información presentada debe ser clara y verificable, dado que tiene carácter de declaración jurada.</li>
                                                <li>Formato y legibilidad: Suba archivos que sean legibles y en formatos aceptados por el sistema para evitar inconvenientes.</li>
                                                <li>Cumplimiento de requisitos: Es indispensable cumplir con las condiciones establecidas en las normativas aplicables, como el TUO de la Ley N° 27444.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <style>
        .auth-bg {
            background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
            url('images/fondo2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }
    </style>


    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/js_general.js') }}"></script>
    <script src="{{ asset('assets/pages/jquery.validation.init.js') }}"></script>
    <script src="{{ asset('assets/plugins/parsleyjs/parsley.min.js') }}"></script>
    <script>
        document.getElementById("P_TIPO_PERSONA").addEventListener("change", function() {
            var grupo_ruc = document.getElementById("GROUP-RUC");
            var grupo_nroDoc = document.getElementById("GROUP-NRO_DOC");
            var tipoDoc = document.getElementById("GROUP-TIPO-DOC");
            var rucIn = document.getElementById("P_RUC");
            var nroDoc = document.getElementById("P_NRO_DOCUMENTO");


            // Muestra el campo RUC si la opción seleccionada es "Persona Jurídica" (valor 2)
            if (this.value === "2") {
                grupo_ruc.style.display = "block";
                grupo_nroDoc.style.display = "none";
                tipoDoc.style.display = "none";
                rucIn.required = true;
                nroDoc.required = false;

            } else {
                grupo_ruc.style.display = "none";
                grupo_nroDoc.style.display = "block";
                tipoDoc.style.display = "block";
                // nroDoc.style.display = "none";
                rucIn.required = false;
                nroDoc.required = true;
            }
        });
        // Ejecuta la función al cargar la página para manejar la selección inicial
        document.getElementById("P_TIPO_PERSONA").dispatchEvent(new Event("change"));

        document.getElementById("P_TIPO_DOCUMENTO").addEventListener("change", function() {
            var nuroField = document.getElementById("P_NRO_DOCUMENTO");
            nuroField.value = ''
            if (this.value === "1") { // DNI
                nuroField.maxLength = 8; // Nota: maxLength es en camelCase
            } else if (this.value === "2") { // CARNET
                nuroField.maxLength = 12;
            } else if (this.value === "3") { // PASAPORTE
                nuroField.maxLength = 8;
            } else {
                nuroField.maxLength = ""; // Limpiar el maxlength si no hay selección
            }
        });

        document.getElementById("P_TIPO_DOCUMENTO").dispatchEvent(new Event("change"));
    </script>
</body>

</html>
