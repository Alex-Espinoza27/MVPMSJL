<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row">
                        <div class="col">
                            <h4 class="page-title">Documentos Observados</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            {{-- <form  id="formFiltro"> --}}
            <div class="card-header mb-2">
                <div class="card-title fs-5 mb-2">Busqueda</div>
                {{-- FILTRO --}}
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
                                {{-- <option value="0" selected="">Todos</option> --}}

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
                    {{-- <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#registrarNuevo">REGISTRAR NUEVO</button> --}}
                </div>
            </div>
            {{-- </form> --}}
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Listado de Solicitudes</h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="width:100%">
                            <thead class="bg-secondary text-white">
                                <tr>
                                    <th>SOLICITUD</th>
                                    <th>FECHA DE PRESENTACION</th>
                                    <th>EXPEDIENTE</th>
                                    <th>ASUNTO</th>
                                    <th>OBSERVACIONES</th>
                                    <th>ANEXOS</th>
                                    <th>ESTADO</th>
                                    <th>ACCIONES</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- MODAL PARA VER DATOS DE LA SOLICITUD --}}
<div class="modal fade bd-example-modal-xl " id="verDetalleSolicitud" tabindex="-1" role="dialog"
    aria-labelledby="verDetalleSolicitudLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog  modal-xl modal-dialog-start" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="verDetalleSolicitudLabel">DETALLE DE LA SOLICITUD</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
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
                                    <input type="text" id="M_NRO_SOLICITUD" class="form-control"
                                        name="NRO_SOLICITUD" disabled />
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
                                    <textarea id="M_OBSERBACION" cols="100" rows="2" class="form-control" disabled></textarea>
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-4 d-flex align-items-center justify-content-end ">
                                    <label class="text-end">Fecha de Observación: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="M_FECHA_OBSERVACION" class="form-control" disabled />
                                </div>
                            </div>

                            <div class="row mb-2">
                                <div class="col-md-4 d-flex align-items-center justify-content-end ">
                                    <label class="text-end">Estado: </label>
                                </div>
                                <div class="col-md-8" id="M_ESTADO">
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

                    <div id="cardObservacion">
                        {{-- DATOS ADICIONALES DE LA OBSERVACIONI --}}
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
                <button type="button" class="btn btn-soft-secondary btn-sm" data-bs-dismiss="modal"><i class="typcn typcn-times"></i> CANCELAR</button>
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
                <h6 class="modal-title m-0" id="registrarObservacionLabel">OBSERVACIONES DEL DOCUMENTO</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="container-fluid px-5 py-2">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="form-label">Digite la Observacion:</label>
                        <textarea class="form-control w-100" rows="4" id="P_MENSAJE_OBSERVACION" disabled></textarea>
                    </div>
                </div>
                <div class="row g-3 my-3">
                    <div class="col-md-6">
                        <label class="form-label" for="P_FECHA_LIMITE_SUBSANACION"> Fecha Límite de
                            Subsanacíon:</label>
                        <input type="date" class="form-control border border-info" id="P_FECHA_LIMITE_SUBSANACION"
                            disabled>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label" for="P_ARCHIVO_OBSERVACION"> Documento guía por MPV-MDSJL </label>
                        <a href=""></a>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="btnObservar" class="btn btn-soft-secondary btn-sm"
                    data-bs-dismiss="modal"><i class="typcn typcn-times"></i> CANCELAR</button>
            </div>
        </div>
    </div>
</div>


{{-- SUBSANAR DOCUMENTO OBSERVADO --}}
<div class="modal fade bd-example-modal-lg" id="subsanarDocumentoModal" tabindex="-1" role="dialog"
    aria-labelledby="subsanarDocumentoModalLabel" aria-hidden="true" data-bs-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-start" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title m-0" id="subsanarDocumentoModalLabel">SUBSANAR SOLICITUD</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <p>EN PROCESO DE IMPLEMENTACIÓN</p>

            <div class="modal-footer">
                <button type="button" id="btnObservar" class="btn btn-soft-secondary btn-sm"
                    data-bs-dismiss="modal"><i class="typcn typcn-times"></i> CANCELAR</button>
            </div>
        </div>
    </div>
</div>
