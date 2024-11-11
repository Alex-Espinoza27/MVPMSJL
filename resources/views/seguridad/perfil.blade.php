<h3 class="card-title text-white">Actualizar perfil</h3>
<div class="container">
    <form action="">
        <div class="row border-mjl">



            <div class="col-md-7">
                <div class="card">
                    <div class="card-header bg-secondary">
                        <h4 class="card-title text-white">Datos principales</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group mb-4 ">
                            <label class="form-label">Tipo de Persona</label>
                            <select name="P_TIPO_PERSONA" class="form-select" id="P_TIPO_PERSONA">
                                <option value="1" selected="">Persona Natural</option>
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
                                            id="P_RUC" placeholder="Ingrese el RUC"
                                            oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                    </div>
                                </div>
    
                                <div class="col-md-6">
                                    <div class="form-group mb-0 " id="GROUP-RA_ZO">
                                        <label class="form-label" for="P_RAZON_SOCIAL">Razón Social</label>
                                        <input type="text" class="form-control" name="P_RAZON_SOCIAL" id="P_RAZON_SOCIAL"
                                            placeholder="Razón Social">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group mb-4" id="GROUP-DIREC_EM">
                                    <label class="form-label" for="P_DIRECCION_EMPRESA">Dirección de la
                                        Empresa</label>
                                    <input type="text" class="form-control" name="P_DIRECCION_EMPRESA"
                                        id="P_DIRECCION_EMPRESA" placeholder="Ingrese la dirección de la empresa">
                                </div>
                            </div>

                            <strong>Datos del representante</strong>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-2 ">
                                    <label class="form-label"> Tipo de Documento </label>
                                    <select name="P_TIPO_DOCUMENTO" class="form-select" id="P_TIPO_DOCUMENTO">
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
                                    <select name="P_DEPARTAMENTO" class="form-select" id="P_DEPARTAMENTO" required>
                                        <option value="" selected="">
                                            ---------Seleccione---------</option>
                                        {{-- @foreach ($departamentos as $departamento)
                                        <option value="{{ $departamento->UBDEP }}">
                                            {{ $departamento->NODEP }}</option>
                                    @endforeach --}}
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-label">Provincia</label>
                                    <select name="P_PROVINCIA" class="form-select" id="P_PROVINCIA" required
                                        disabled>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group ">
                                    <label class="form-label"> Distrito</label>
                                    <select name="P_DISTRITO" class="form-select" id="P_DISTRITO" required disabled>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-2">
                                    <label class="form-label" for="P_CELULAR">Celular</label>
                                    <input type="text" maxlength="9" minlength="9" class="form-control"
                                        name="P_CELULAR" id="P_CELULAR" placeholder="celular"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" required>
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
                        <button type="button" name="actualizar" id="actualizar" class="btn btn-primary"> Actualizar
                            Datos</button>
                        <button type="button" name="cancelar" id="cancelar" class="btn btn-secondary">
                            Cancelar</button>
                    </div>

                </div>
            </div>
            <div class="col-md-4   alert alert-light container d-flex justify-content-center aling-item-center h-100">
                <figure>
                    <img src="{{ asset('images/logo.png') }}" alt="Descripción de la imagen" class="img-fluid">

                    <figcaption>Este es el pie de foto o descripción de la imagen</figcaption>
                </figure>
            </div>
        </div>
    </form>
</div>
