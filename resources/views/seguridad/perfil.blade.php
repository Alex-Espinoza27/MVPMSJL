<div class="container">
    <h3 class="card-title ">Actualizar perfil</h3>

    <div class="row border-mjl">
        <div class="col-md-7">
            <div class="card">
                <form action="" class="form-parsley" method="POST">
                    <div class="card-header bg-secondary">
                        <h4 class="card-title text-white">Datos principales</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4 ">
                            <label class="form-label">Tipo de Persona</label>
                            <select name="P_TIPO_PERSONA" class="form-select" id="P_TIPO_PERSONA"
                                onchange="tipoPersona();" disabled>
                                <option value="1">Persona Natural</option>
                                <option value="2">Persona Jurídica</option>
                            </select>
                        </div>

                        <div id="GRUPO-PER-JURIDICA">
                            <strong>Datos de la empresa</strong>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group mb-2 " id="GROUP-RUC">
                                        <label class="form-label" for="P_RUC">RUC de la Empresa</label>
                                        <input type="text" maxlength="11" class="form-control" name="P_RUC"
                                            id="P_RUC" placeholder="Ingrese el RUC" disabled
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group mb-0 " id="GROUP-RA_ZO">
                                        <label class="form-label" for="P_RAZON_SOCIAL">Razón Social</label>
                                        <input type="text" class="form-control" name="P_RAZON_SOCIAL"
                                            id="P_RAZON_SOCIAL" placeholder="Razón Social" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-4" id="GROUP-DIREC_EM">
                                    <label class="form-label" for="P_DIRECCION_EMPRESA">Dirección de la
                                        Empresa</label>
                                    <input type="text" class="form-control" name="P_DIRECCION_EMPRESA" disabled
                                        id="P_DIRECCION_EMPRESA" placeholder="Ingrese la dirección de la empresa">
                                </div>
                            </div>

                            <strong>Datos del representante</strong>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2 ">
                                    <label class="form-label"> Tipo de Documento </label>
                                    <select name="P_TIPO_DOCUMENTO" class="form-select" id="P_TIPO_DOCUMENTO"
                                        onchange="tipoDocumento(event);">
                                        <option value="1" selected="">Documento Nacional de Identidad </option>
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
                                        id="P_NRO_DOCUMENTO" placeholder="Ingrese el numero" maxlength="8"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label class="form-label" for="P_APELLIDO_PARTERNO">Apellido
                                        Paterno</label>
                                    <input type="text" class="form-control" name="P_APELLIDO_PARTERNO"
                                        id="P_APELLIDO_PARTERNO" placeholder="Ingrese el apellido paterno" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label class="form-label" for="P_APELLIDO_MATERNO">Apellido
                                        Materno</label>
                                    <input type="text" class="form-control" name="P_APELLIDO_MATERNO"
                                        id="P_APELLIDO_MATERNO" placeholder="Ingrese el apellido materno" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label class="form-label" for="P_NOMBRES">Nombres</label>
                                    <input type="text" class="form-control" name="P_NOMBRES" id="P_NOMBRES"
                                        placeholder="Nombre" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label class="form-label" for="P_DIRECCION_PERSONA">Dirección</label>
                                    <input type="text" class="form-control" name="P_DIRECCION_PERSONA"
                                        id="P_DIRECCION_PERSONA" placeholder="Ingrese la dirección" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-label"> Departamento</label>
                                    <select name="P_DEPARTAMENTO" class="form-select" id="P_DEPARTAMENTO" required
                                        onchange="provincia(event);">
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-label">Provincia</label>
                                    <select name="P_PROVINCIA" class="form-select" id="P_PROVINCIA" required
                                        onchange="distrito(event);">
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-label"> Distrito</label>
                                    <select name="P_DISTRITO" class="form-select" id="P_DISTRITO" required>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label class="form-label" for="P_CELULAR">Celular</label>
                                    <input type="text" maxlength="9" minlength="9" class="form-control"
                                        name="P_CELULAR" id="P_CELULAR" placeholder="celular"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group mb-2 ">
                                    <label class="form-label">Correo Electrónico</label>
                                    <input type="email" id="P_CORREO" class="form-control" name="P_CORREO"
                                        placeholder="Correo electrónico" required />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" container m-3">
                        <button type="button" name="actualizar" id="actualizar" class="btn btn-info"
                            onclick="actualizarDatos();"> Actualizar
                            Datos</button>
                        <button type="button" name="cancelar" id="cancelar" class="btn btn-secondary">
                            Cancelar</button>
                    </div>
                </form>
            </div>


        </div>
        <div class="col-md-4 ">
            <div class="card">
                <div class="card-body">
                    <div class="text-center dastone-profile-main">
                        <div class="dastone-profile-main-pic">
                            <img src="{{ asset('assets/images/users/user-8.jpg') }}" alt="" height="110"
                            id="profileImage" 
                                class="rounded-circle  w-50 h-auto">
                            <span class="dastone-profile_main-pic-change text-end "
                            onclick="document.getElementById('profileInput').click()" 
                            > <i class="fas fa-camera"></i></span>
                        </div>
                        <div class="">
                            <h5 class="mb-0">{{ session('user')->USU_CORREO }}</h5> 
                            <small class="text-muted">{{ session('ROL_USER')->ROL_NOMBRE }}</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-secondary">
                    <h4 class="card-title text-white">Datos adicionales</h4>
                </div>
                <div class="card-body">
                    <div class="form-group mb-4">
                        <label class="form-label">Genero</label>
                        <select name="P_GENERO" class="form-select" id="P_GENERO">
                            <option value="1">Masculino</option>
                            <option value="2">Femenino</option>
                        </select>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group mt-2">
                            <label class="form-label" for="P_FECHA_NACIMIENTO">Fecha de Nacimiento</label>
                            <input type="date" class="form-control border border-info" name="P_FECHA_NACIMIENTO"
                                id="P_FECHA_NACIMIENTO">
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <div class="text-center dastone-profile-main">
                        <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                            onclick="limpiarModal();" data-bs-target="#actualizarClave">
                            <i data-feather="key"
                                class="align-self-center icon-xs icon-dual me-1 text-danger "></i>Actualizar
                            Contraseña</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="actualizarClave" tabindex="-1" role="dialog"
        aria-labelledby="actualizarClaveTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <form class="form-parsley" action="{{ route('cambiarClave') }}" method="POST">
                    @csrf
                    <div class="modal-header">
                        <h6 class="modal-title m-0" id="actualizarClaveTitle">Actualizar Clave</h6>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body mx-5 my-2">
                        <div class="row">
                            <div class="form-group mb-2 ">
                                <h6>Clave Actual</h6>
                                <input type="password" id="P_CLAVE_ACTUAL" name="P_CLAVE_ACTUAL" 
                                    class="form-control" placeholder="Ingrese contraseña actual " required
                                    autocomplete="off" />
                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-2 ">
                                    <label class="form-label" for="P_CLAVE_NUEVA">Nueva contraseña</label>
                                    <input type="password" id="P_CLAVE_NUEVA" name="P_CLAVE_NUEVA"
                                        class="form-control" placeholder="Ingrese la Contraseña" autocomplete="off"
                                        onkeypress="" required />
                                </div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group mb-2">
                                    <label class="form-label">Confirmar contraseña nueva</label>
                                    <input type="password" id="P_CONFIRMACION_CLAVE" required
                                        name="P_CONFIRMACION_CLAVE" class="form-control"
                                        data-parsley-equalto="#P_CLAVE_NUEVA" placeholder="Confirmar Contraseña"
                                        autocomplete="off" />
                                    <div class="invalid-feedback">
                                        <span class="text-danger">¡Las contraseñas no coinciden!</span>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer ">
                        <button type="button" class="btn btn-soft-primary btn-sm" id="guardarClave"
                            onclick="actuaizarClave();">Guardar cambio</button>
                        <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">
                            Cerrar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <input type="file" id="profileInput" style="display: none;" accept="image/*" onchange="previewProfileImage(event)">

