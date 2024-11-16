
@if (session('ok'))
    <script> showMessageSweet('success', 'Registrado!',session('ok') )</script>
@endif

@if (session('success'))
    <script> showMessageSweet('success', 'Registrado!',session('success') )</script>
@endif

@if (session('error'))
    <script> showMessageSweet('error', 'Registrado!',session('error') )</script>
@endif



<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row">
                        <div class="col">
                            <h4 class="page-title">ADMINISTRAR SOLICITUDES</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            {{-- <div class="card-header mb-2">
                <div class="card-title fs-5 mb-2">Busqueda</div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mt-2 ">
                            <div class="form-group">
                                <label class="form-label" for="FILTRO_EXPEDIENTE">Número de Solicitud /
                                    Expediente</label>
                                <input type="text" class="form-control border border-info" name="FILTRO_EXPEDIENTE"
                                    id="FILTRO_EXPEDIENTE" placeholder="Ingrese el numero del expediente">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mt-2 ">
                            <label class="form-label">Tipo Expediente</label>
                            <select name="FILTRO_TIPO_EXPEDIENTE" class="form-select border border-info"
                                id="FILTRO_TIPO_EXPEDIENTE">
                                <option value="0" selected="">--Seleccione---</option>
                                <option value="1">TUPA</option>
                                <option value="2">SOLICITUD</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mt-2 ">
                            <label class="form-label">Estado del documento</label>
                            <select name="FILTRO_ESTADO" class="form-select border border-info" id="FILTRO_ESTADO">
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mt-2">
                            <label class="form-label" for="FILTRO_FECHA_INICIO">Desde</label>
                            <input type="date" class="form-control border border-info" name="FILTRO_FECHA_INICIO"
                                id="FILTRO_FECHA_INICIO" placeholder="Ingrese el numero del expediente">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mt-2">
                            <label class="form-label" for="FILTRO_FECHA_FIN">Hasta</label>
                            <input type="date" class="form-control border border-info" name="FILTRO_FECHA_FIN"
                                id="FILTRO_FECHA_FIN" placeholder="Ingrese el numero del expediente">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-3">
                    <button type="button" class="btn btn-danger" onclick="aplicarFiltro();">BUSCAR</button>
                    <button type="button" class="btn btn-secondary" onclick="solicitudes();">LIMPIAR</button>
                </div>
            </div> --}}
            <div class="card-body text-size-20">
                <table id="dataSolicitud" class="table table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; border-color:black;  width: 100%; ">
                    <thead class="secondary">
                        <tr class="btn-secondary text-white">
                            <th><strong>#NRO</strong></th>
                            <th><strong>SOLICITUD</strong></th>
                            <th><strong>FECHA DE PRESENTACION</strong></th>
                            <th><strong>NUMERO DE EXPEDIENTE</strong></th>
                            <th><strong>ASUNTO</strong></th>
                            <th><strong>OBSERVACIONES</strong></th>
                            <th><strong>ANEXOS</strong></th>
                            <th><strong>ESTADO</strong></th>
                            <th><strong>ACCIONES</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



{{-- MODAL PARA VER DATOS DE LA SOLICITUD --}}
<div class="modal fade bd-example-modal-xl " id="verDetalleSolicitud" tabindex="-1" role="dialog"
    aria-labelledby="verDetalleSolicitudLabel" aria-hidden="true">
    <div class="modal-dialog  modal-xl modal-dialog-start" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="verDetalleSolicitudLabel">DETALLE DE LA SOLICITUD</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->
            <div class="row  m-3">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h4 class="card-title text-white">Datos de la Solicitud</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-md-4 d-flex align-items-center justify-content-end ">
                                    <label class="text-end">Numero de solicitud: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="M_NRO_SOLICITUD" class="form-control" name="NRO_SOLICITUD"
                                        disabled />
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-4 d-flex align-items-center justify-content-end ">
                                    <label class="text-end">Fecha de presentación: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="M_FECHA_PRESENTACION" class="form-control" disabled />
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-4 d-flex align-items-center justify-content-end ">
                                    <label class="text-end">Asunto: </label>
                                </div>
                                <div class="col-md-8">
                                    <textarea name="" id="M_ASUNTO" cols="100" rows="2" class="form-control" disabled></textarea>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-4 d-flex align-items-center justify-content-end ">
                                    <label class="text-end">Expediente: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="M_EXPEDIENTE" class="form-control" disabled />
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-4 d-flex align-items-center justify-content-end ">
                                    <label class="text-end">Observaciones: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="M_OBSERBACION" class="form-control" disabled />
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-4 d-flex align-items-center justify-content-end ">
                                    <label class="text-end">Estado: </label>
                                </div>
                                <div class="col-md-8" id="M_ESTADO">
                                    {{-- <input type="text" id="M_ESTADO" class="form-control"  disabled /> --}}
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header bg-secondary">
                            <h4 class="card-title text-white">Archivos</h4>
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <label><strong>Archivo principal:</strong></label>
                                <div class="row" id="ARCHIVOPRINCIPAL">
                                    {{-- arhivo principal --}}
                                </div>
                                <div class="dropdown-divider mb-0"></div>
                                <label><strong class="text-25">Anexos:</strong></label>
                                <div class="row" id="ANEXOS">
                                    {{-- anexos --}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mx-5 my-0">
                <div class="card-header bg-secondary">
                    <h4 class="card-title text-white">Datos de la persona</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-2">
                        <div class="col-md-4 d-flex align-items-center justify-content-end ">
                            <label class="text-end">Tipo de Persona: </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="M_TIPO_PERSONA" class="form-control" disabled />
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 d-flex align-items-center justify-content-end ">
                            <label class="text-end">Tipo Documento: </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="M_TIPO_DOCUMENTO" class="form-control" disabled />
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 d-flex align-items-center justify-content-end ">
                            <label class="text-end">Razon social: </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="M_RAZON_SOCIAL" class="form-control" disabled />
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 d-flex align-items-center justify-content-end ">
                            <label class="text-end">Correo Electrónico: </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="M_CORREO" class="form-control" disabled />
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 d-flex align-items-center justify-content-end ">
                            <label class="text-end">Número de Teléfono: </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="M_CELULAR" class="form-control" disabled />
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 d-flex align-items-center justify-content-end ">
                            <label class="text-end">Domicilio: </label>
                        </div>
                        <div class="col-md-6">
                            <input type="text" id="M_DIRECCION" class="form-control" disabled />
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-4 d-flex align-items-center justify-content-end ">
                            <label class="text-end">Género: </label>
                        </div>
                        <div class="col-md-6" id="M_GENERO">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>


{{-- REGISTRAR OBSERVACION A LA SOLICITUD --}}
<div class="modal fade bd-example-modal-lg" id="registrarObservacion" tabindex="-1" role="dialog"
    aria-labelledby="registrarObservacionLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-start" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="registrarObservacionLabel">OBSERVAR DOCUMENTO</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('administrar.registrar.Observacion') }}" class="form-parsley"
                enctype="multipart/form-data" method="POST"   id="formObservacion">
                @csrf
                <input type="hidden" name="TIPO_REGISTRO_OBSERVACION" id="TIPO_REGISTRO_OBSERVACION">
                {{-- <input type="hidden" name="TIPO_REGISTRO_OBSERVACION" id="TIPO_REGISTRO_OBSERVACION"> --}}

                <input type="hidden" name="ID_SOLICITUD" id="ID_SOLICITUD">
                <div class="container-fluid px-5 py-2">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Digite la Observacion:</label>
                            <textarea class="form-control w-100" rows="4" id="P_MENSAJE_OBSERVACION" name="P_MENSAJE_OBSERVACION"
                                placeholder="Escriba aquí.." minlength="15" onkeyup="longitudTextAsunto('P_MENSAJE_OBSERVACION','textoMaximo');"
                                maxlength="200" required>
                            </textarea>
                            <small id="textoMaximo"></small>
                        </div>
                    </div>
                    <div class="row g-3 my-3">
                        <div class="col-md-6">
                            <label class="form-label" for="P_FECHA_LIMITE_SUBSANACION">
                                Fecha Límite de Subsanacíon:
                            </label>
                            <br>
                            <input type="date" class="form-control border border-info"
                                name="P_FECHA_LIMITE_SUBSANACION" id="P_FECHA_LIMITE_SUBSANACION"
                                onchange="esFechaMayorQueHoy('P_FECHA_LIMITE_SUBSANACION');">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="P_ARCHIVO_OBSERVACION">  
                                Agregar Documento <span class="text-muted">(Opcional): El archivos debe ser menor a
                                    20MB.</span>
                            </label>
                            <input type="file" class="form-control" name="P_ARCHIVO_OBSERVACION"
                                id="P_ARCHIVO_OBSERVACION" accept="application/pdf,image/png,image/jpeg,.doc,.docx"
                                {{-- data-errors-position="outside"  data-max-file-size="10" --}} onchange="cargarArchivoGuia(event,20)">
                        </div>
                    </div>
                    
                </div>
                <div class="modal-footer">
                    <button type="button" id="btnValidarSolicitud" class="btn btn-purple" onclick="actualizarTipoOperacion('1');">VALIDAR SOLICITUD</button>
                    <button type="button" id="btnRegistrarObservacion" class="btn btn-outline-danger"
                        onclick="actualizarTipoOperacion('2');">ENVIAR OBSERVACION</button>
                    <button type="button" id="btnObservar" class="btn btn-soft-secondary btn-sm"
                        data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
