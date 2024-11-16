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
    <div class="container">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="row">
                    <div class="col-lg-5 mx-auto">
                        <div class="card">
                            <div class="row">
                                <div class="text-center pt-2 pt-0 d-flex flex-column align-items-center">
                                    <a href="index.html">
                                        <img src="{{ asset('images/logo.png') }}" height="50" alt="logo"
                                            class="auth-logo">
                                    </a>
                                    <h2 class="fw-semibold text-danger font-24 mt-2 mb-2 p-0 d-inline-block">
                                        <strong>Mesa de Partes Virtual</strong>
                                    </h2>
                                    <p class="nav-link active fw-semibold text-secondary font-15 p-0 m-0"
                                        data-bs-toggle="tab">Iniciar Sesión para comenzar</p>
                                    <div class="border-top border-2 border-danger mx-auto" style="width: 20%;"></div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <div class="tab-content px-5 py-2">
                                    <div class="tab-pane active p-1" id="LogIn_Tab" role="tabpanel">

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

                                        <form class="form-parsley" action="{{ route('login.submit')}}"  method="POST">
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
                                                        class="form-control" placeholder="***********" required />
                                                </div>
                                            </div>
                                            <div class="form-group row my-3">
                                                <div class="col-md-6">
                                                    <div class="custom-control custom-switch switch-success">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="P_RECORDAR_CLAVE">
                                                        <label class="form-label text-muted" for="P_RECORDAR_CLAVE">Recordar
                                                            Contraseña</label>
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
                                            <p class="mb-0">No tienes una cuenta? <a href="{{ route('seguridad.registrar') }}"
                                                    class="text-info ms-2">¡Regístrate ahora!</a></p>
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

    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/js_general.js') }}"></script>
    <script src="{{asset('assets/pages/jquery.validation.init.js')}}"></script>
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
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