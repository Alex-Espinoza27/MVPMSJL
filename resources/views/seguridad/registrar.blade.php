<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registar Mesa de Partes Virtual SJL</title>
    <meta content="Mesa de partes virtual San Juan de Lurigancho" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <script type='text/javascript'> 
        var urljs = '@php echo URL('/').'/'; @endphp'
    </script>

</head>
<body>
    <div class="container">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-9 align-self-center">
                <div class="row">
                    <div class="col-lg-9 mx-auto">
                        <div class="card mt-4">
                            <div class="row">
                                <div class="text-center pt-2 pt-5 d-flex flex-column align-items-center">
                                    <a href="index.html">
                                        <img src="{{ asset('images/logo.png') }}" height="50" alt="logo"
                                            class="auth-logo">
                                    </a>
                                    <h2 class="fw-semibold text-danger font-24 mt-2 mb-2 p-0 d-inline-block">
                                        <strong>Crear una nueva cuenta</strong>
                                    </h2>
                                    <p class="nav-link active fw-semibold text-secondary font-15 p-0 m-0"
                                        data-bs-toggle="tab">Ingrese los datos correctamente</p>
                                    <div class="border-top border-2 border-danger mx-auto" style="width: 20%;"></div>
                                </div>
                            </div>
                            <div class="card-body p-0">
                                <!-- Tab panes -->
                                <div class="tab-content px-5 py-1">
                                    <div class="tab-pane active p-3" id="Persona-Natural" role="tabpanel">

                                        @if (session('error'))
                                            <script>
                                                const Toast = Swal.mixin({
                                                    toast: true,
                                                    position: "top-end",
                                                    showConfirmButton: false,
                                                    timer: 3000,
                                                    timerProgressBar: true,
                                                    didOpen: (toast) => {
                                                        toast.onmouseenter = Swal.stopTimer;
                                                        toast.onmouseleave = Swal.resumeTimer;
                                                    }
                                                });
                                                Toast.fire({
                                                    icon: 'error',
                                                    title: '{{ session('error') }}'
                                                });
                                            </script>
                                        @endif
                                        @if (session('success'))
                                            <script>
                                                const Toast = Swal.mixin({
                                                    toast: true,
                                                    position: "top-end",
                                                    showConfirmButton: false,
                                                    timer: 3000,
                                                    timerProgressBar: true,
                                                    didOpen: (toast) => {
                                                        toast.onmouseenter = Swal.stopTimer;
                                                        toast.onmouseleave = Swal.resumeTimer;
                                                    }
                                                });
                                                Toast.fire({
                                                    icon: 'success',
                                                    title: '{{ session('success') }}'
                                                });
                                            </script>
                                        @endif
                                        <form class="form-parsley" action="{{route('login.registrar')}}" method="POST">
                                            @csrf

                                            <div class="form-group mb-4 ">
                                                <label class="form-label">Tipo de Persona</label>
                                                <select name="P_TIPO_PERSONA" class="form-select" id="P_TIPO_PERSONA">
                                                    <option value="1" selected="">Persona Natural</option>
                                                    <option value="2">Persona Jurídica</option>
                                                </select>
                                            </div>

                                            <div id="GRUPO-PER-JURIDICA" style="display: none;">
                                                <strong>Datos de la empresa</strong>
                                                <div class="col-md-12">
                                                    <div class="form-group mb-2 " id="GROUP-RUC">
                                                        <label class="form-label" for="P_RUC">RUC de la Empresa</label>
                                                        <input type="text" maxlength="11" class="form-control"
                                                            name="P_RUC" id="P_RUC" placeholder="Ingrese el RUC"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group mb-0 " id="GROUP-RA_ZO">
                                                        <label class="form-label" for="P_RAZON_SOCIAL">Razón Social</label>
                                                        <input type="text" class="form-control" name="P_RAZON_SOCIAL"
                                                            id="P_RAZON_SOCIAL" placeholder="Razón Social">
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group mb-4" id="GROUP-DIREC_EM">
                                                        <label class="form-label" for="P_DIRECCION_EMPRESA">Dirección de la
                                                            Empresa</label>
                                                        <input type="text" class="form-control"
                                                            name="P_DIRECCION_EMPRESA" id="P_DIRECCION_EMPRESA"
                                                            placeholder="Ingrese la dirección de la empresa">
                                                    </div>
                                                </div>

                                                <strong>Datos del representante</strong>
                                            </div>

                                            {{-- <br> --}}

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2 ">
                                                        <label class="form-label"> Tipo de Documento </label>
                                                        <select name="P_TIPO_DOCUMENTO" class="form-select"
                                                            id="P_TIPO_DOCUMENTO">
                                                            <option value="1" selected="">Documento Nacional de
                                                                Identidad </option>
                                                            <option value="2">Carné de Extranjería</option>
                                                            <option value="3">Pasaporte</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label class="form-label" for="P_NRO_DOCUMENTO">Número de
                                                            Documento</label>
                                                        <input type="text" class="form-control" name="P_NRO_DOCUMENTO"
                                                            id="P_NRO_DOCUMENTO" placeholder="Ingrese el numero"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label class="form-label" for="P_APELLIDO_PARTERNO">Apellido
                                                            Paterno</label>
                                                        <input type="text" class="form-control"
                                                            name="P_APELLIDO_PARTERNO" id="P_APELLIDO_PARTERNO"
                                                            placeholder="Ingrese el apellido paterno" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label class="form-label" for="P_APELLIDO_MATERNO">Apellido
                                                            Materno</label>
                                                        <input type="text" class="form-control"
                                                            name="P_APELLIDO_MATERNO" id="P_APELLIDO_MATERNO"
                                                            placeholder="Ingrese el apellido materno" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group mb-2">
                                                    <label class="form-label" for="P_NOMBRES">Nombres</label>
                                                    <input type="text" class="form-control" name="P_NOMBRES"
                                                        id="P_NOMBRES" placeholder="Nombre" required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group mb-2">
                                                    <label class="form-label" for="P_DIRECCION_PERSONA">Dirección</label>
                                                    <input type="text" class="form-control" name="P_DIRECCION_PERSONA"
                                                        id="P_DIRECCION_PERSONA" placeholder="Ingrese la dirección"
                                                        required>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group ">
                                                        <label class="form-label"> Departamento</label>
                                                        <select name="P_DEPARTAMENTO" class="form-select"
                                                            id="P_DEPARTAMENTO" required>
                                                            <option value="" selected="">
                                                                ---------Seleccione---------</option>
                                                            @foreach ($departamentos as $departamento)
                                                                <option value="{{ $departamento->UBDEP }}">
                                                                    {{ $departamento->NODEP }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group ">
                                                        <label class="form-label">Provincia</label>
                                                        <select name="P_PROVINCIA" class="form-select" id="P_PROVINCIA"
                                                            required disabled>
                                                            {{-- <option value="0" selected=""> ---------Seleccione---------</option>  --}}
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group ">
                                                        <label class="form-label"> Distrito</label>
                                                        <select name="P_DISTRITO" class="form-select" id="P_DISTRITO"
                                                            required disabled>
                                                            {{-- <option value="0" selected="">---------Seleccione---------</option> --}}
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label class="form-label" for="P_CELULAR">Celular</label>
                                                        <input type="text" maxlength="9" minlength="9"
                                                            class="form-control" name="P_CELULAR" id="P_CELULAR"
                                                            placeholder="celular"
                                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group mb-2 ">
                                                        <label class="form-label">Correo Electrónico</label>
                                                        <input type="email" id="P_CORREO" class="form-control"
                                                            name="P_CORREO" placeholder="Correo electrónico" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2 ">
                                                        <label class="form-label" for="P_CLAVE">Contraseña</label>
                                                        <input type="password" id="P_CLAVE" name="P_CLAVE"
                                                            class="form-control" placeholder="Correo Contraseña"
                                                            required />
                                                        {{-- pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" --}}
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-2">
                                                        <label class="form-label">Confirmar Contraseña</label>
                                                        <input type="password" id="P_CLAVE_CONFIRM"
                                                            name="P_CLAVE_CONFIRM" class="form-control"
                                                            data-parsley-equalto="#P_CLAVE"
                                                            placeholder="Confirmar Contraseña" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="checkbox checkbox-info">
                                                    <input type="checkbox" id="ACEPTA_TERMINO" name="ACEPTA_TERMINO"
                                                        required>
                                                    <label for="ACEPTA_TERMINO" class="text-info"> He leído y acepto los
                                                        términos y condiciones de uso; asimismo, autorizo ser notificado al
                                                        correo electrónico proporcionado. <a href="#">Ver
                                                            Terminos</a></label>
                                                </div>
                                            </div>
                                            <div
                                                class="form-group mb-0 d-flex justify-content-center aling-item-center mt-3">
                                                <div class="col-6 ">
                                                    <button class="btn btn-success w-100 waves-effect waves-light"
                                                        type="submit">
                                                        Regitrar
                                                        <i class="fas fa-sign-in-alt ms-1"></i></button>
                                                </div><!--end col-->
                                            </div> <!--end form-group-->
                                        </form>
                                        <div class="m-3 text-center text-muted">
                                            <p class="mb-0">Comenzar <a href="{{ route('seguridad.login') }}"
                                                    class="text-info ms-2">Iniciar Sesión!!</a></p>
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
    <script src="{{asset('assets/pages/jquery.validation.init.js')}}"></script>
    <script src="{{asset('assets/plugins/parsleyjs/parsley.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/js_general.js') }}"></script>

    <script>
        document.getElementById("P_TIPO_PERSONA").addEventListener("change", function() {
            var rucField = document.getElementById("GROUP-RUC");
            var razField = document.getElementById("GROUP-RA_ZO");
            var direcField = document.getElementById("GROUP-DIREC_EM");
            var GrupoPerJuField = document.getElementById("GRUPO-PER-JURIDICA");

            var rucIn = document.getElementById("P_RUC");
            var razIn = document.getElementById("P_RAZON_SOCIAL");
            var direIn = document.getElementById("P_DIRECCION_EMPRESA");

            // Comprobar si los campos existen antes de intentar cambiarlos
            if (!rucField || !razField || !direcField) {
                console.error("Uno o más campos no existen en el DOM");
                return; // Salir si hay un error
            }

            if (this.value === "2") { // Persona Jurídica
                rucField.style.display = "block";
                razField.style.display = "block";
                direcField.style.display = "block";
                GrupoPerJuField.style.display = "block";
                rucIn.required = true;
                razIn.required = true;
                direIn.required = true;



            } else { // Persona Natural
                rucField.style.display = "none";
                razField.style.display = "none";
                direcField.style.display = "none";
                GrupoPerJuField.style.display = "none";
                rucIn.required = false;
                razIn.required = false;
                direIn.required = false;
            }
        });
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

    {{-- <script src="{{ url('assets/js/jquery.min.js') }}"></script> --}}
    <script>
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });
        // const appUrl = "{{ config('app.url') }}";
        $(document).ready(function() {
            $('#P_DEPARTAMENTO').change(function() {
                var departamento = $(this).val();

                $('#P_PROVINCIA').prop('disabled', true).empty().append(
                    '<option value="" selected="">---------Seleccione---------</option>');
                $('#P_DISTRITO').prop('disabled', true).empty().append(
                    '<option value="" selected="">---------Seleccione---------</option>');

                console.log('dep ', departamento);
                if (departamento) {
                    $('#P_PROVINCIA').prop('disabled', false).empty().append(
                        '<option value="" selected="">---------Seleccione---------</option>');

                        let url = 'provincias/'+departamento;

                        fetchGet(url,function(result){
                            result.forEach(element => {
                                $('#P_PROVINCIA').append(
                                    '<option value="' + element.UBPRV + ' "> ' +
                                    element.NOPRV + '</option>'
                                )
                            });
                            $('#P_PROVINCIA').prop('disabled', false);
                        });
                }
            });

            $('#P_PROVINCIA').change(function() {
                var departamento = document.getElementById('P_DEPARTAMENTO').value;
                var provincia = $(this).val();
                console.log('dep ', departamento);
                console.log('provin: ', provincia);

                if (provincia) {
                    $('#P_DISTRITO').prop('disabled', false).empty().append(
                        '<option value="" selected="">---------Seleccione---------</option>');

                        let url = 'distritos/' + departamento + '/' + provincia;
                        fetchGet(url,function(data){
                            data.forEach(element => {
                                $('#P_DISTRITO').append(
                                    '<option value="' + element.UBDIS + ' "> ' +
                                    element.NODIS + '</option>'
                                )
                            });
                        });                
                } else {
                    $('#P_DISTRITO').prop('disabled', true).empty().append(
                        '<option value="" selected="">---------Seleccione---------</option>');
                }
            });

        });
    </script>
</body>
</html>