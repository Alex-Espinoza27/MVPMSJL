
@if(session('success'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'Aceptar'
        });
    });
</script>
@endif

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: '¡Éxito!',
            text: "{{ session('error') }}",
            icon: 'error',
            confirmButtonText: 'error'
        });
    });
</script>
@endif





<div class="row">
    <div class="col-12">
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="row">
                        <div class="col">
                            <h4 class="page-title">SOLICITUD</h4>
                            <div class="breadcrumb d-flex gap-2">
                                <h5><a href="#">Inicio /</a></h5>
                                <h5><a href="#">Solicitud /</a></h5>
                                <h5><a href="#">Lista</a></h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header mb-2">
                <div class="card-title fs-5 mb-2">Busqueda</div>
                {{-- FILTRO --}}
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group mt-2 ">
                            <div class="form-group">
                                <label class="form-label" for="FILTRO_NRO_DOCUMENTO">Número de Solicitud /
                                    Expediente</label>
                                <input type="text" class="form-control border border-info"
                                    name="FILTRO_NRO_DOCUMENTO" id="FILTRO_NRO_DOCUMENTO"
                                    placeholder="Ingrese el numero del expediente">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mt-2 ">
                            <label class="form-label">Tipo Documento</label>
                            <select name="FILTRO_TIPO_DOCUMENTO" class="form-select border border-info"
                                id="FILTRO_TIPO_DOCUMENTO">
                                <option value="1" selected="">Todos</option>
                                <option value="2">TUPA</option>
                                <option value="3">SOLICITUD</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mt-2 ">
                            <label class="form-label">Estado del documento</label>
                            <select name="FILTRO_ESTADO" class="form-select border border-info"
                                id="FILTRO_TIPO_DOCUMENTO">
                                <option value="1" selected="">Todos</option>
                                <option value="2">PRESENTADO</option>
                                <option value="3">OBSERVADO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mt-2 ">
                            <label class="form-label">Estado del documento</label>
                            <select name="FILTRO_ESTADO" class="form-select border border-info "
                                id="FILTRO_TIPO_DOCUMENTO">
                                <option value="1" selected="">Todos</option>
                                <option value="2">PRESENTADO</option>
                                <option value="3">OBSERVADO</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group mt-2">
                            <label class="form-label" for="FILTRO_NRO_DOCUMENTO">Desde</label>
                            <input type="date" class="form-control border border-info" name="FILTRO_NRO_DOCUMENTO"
                                id="FILTRO_NRO_DOCUMENTO" placeholder="Ingrese el numero del expediente">
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end gap-3">
                    <button type="button" class="btn btn-danger">BUSCAR</button>
                    <button type="button" class="btn btn-secondary">LIMPIAR</button>
                    <button type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#registrarNuevo"
                        {{-- onclick="abrirModal()" id="abrirRegistroModal" --}}>REGISTRAR NUEVO</button>
                </div>
            </div>
            <div class="card-body text-size-20">
                <table id="row_callback" class="table table-striped table-bordered dt-responsive nowrap"
                    style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead class="secondary">
                        <tr class="btn-secondary text-white">
                            <th><strong>Numero Expediente</strong></th>
                            <th><strong>Tipo</strong></th>
                            <th><strong>Asunto</strong></th>
                            <th><strong>Fecha</strong></th>
                            <th><strong>Estado</strong></th>
                            <th><strong>Fecha atencion</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>EXP-001</td>
                            <td>Expediente</td>
                            <td>Solicitud de información</td>
                            <td>2024-01-15</td>
                            <td>En Proceso</td>
                            <td>2024-01-20</td>
                        </tr>
                        <tr>
                            <td>SOL-002</td>
                            <td>Solicitud</td>
                            <td>Permiso de construcción</td>
                            <td>2024-02-10</td>
                            <td>Aprobado</td>
                            <td>2024-02-15</td>
                        </tr>
                        <tr>
                            <td>EXP-003</td>
                            <td>Expediente</td>
                            <td>Reclamo de servicio</td>
                            <td>2024-03-05</td>
                            <td>Resuelto</td>
                            <td>2024-03-10</td>
                        </tr>
                        <tr>
                            <td>SOL-002</td>
                            <td>Solicitud</td>
                            <td>Permiso de construcción</td>
                            <td>2024-02-10</td>
                            <td>Aprobado</td>
                            <td>2024-02-15</td>
                        </tr>
                        <tr>
                            <td>EXP-003</td>
                            <td>Expediente</td>
                            <td>Reclamo de servicio</td>
                            <td>2024-03-05</td>
                            <td>Resuelto</td>
                            <td>2024-03-10</td>
                        </tr>
                        <tr>
                            <td>SOL-002</td>
                            <td>Solicitud</td>
                            <td>Permiso de construcción</td>
                            <td>2024-02-10</td>
                            <td>Aprobado</td>
                            <td>2024-02-15</td>
                        </tr>
                        <tr>
                            <td>EXP-003</td>
                            <td>Expediente</td>
                            <td>Reclamo de servicio</td>
                            <td>2024-03-05</td>
                            <td>Resuelto</td>
                            <td>2024-03-10</td>
                        </tr>
                        <tr>
                            <td>SOL-004</td>
                            <td>Solicitud</td>
                            <td>Registro de empresa</td>
                            <td>2024-04-01</td>
                            <td>En Espera</td>
                            <td>N/A</td>
                        </tr>
                        <tr>
                            <td>EXP-005</td>
                            <td>Expediente</td>
                            <td>Queja de producto</td>
                            <td>2024-04-20</td>
                            <td>En Proceso</td>
                            <td>2024-04-25</td>
                        </tr>
                        <tr>
                            <td>SOL-006</td>
                            <td>Solicitud</td>
                            <td>Licencia de funcionamiento</td>
                            <td>2024-05-12</td>
                            <td>Aprobado</td>
                            <td>2024-05-18</td>
                        </tr>
                        <tr>
                            <td>EXP-007</td>
                            <td>Expediente</td>
                            <td>Actualización de datos</td>
                            <td>2024-06-01</td>
                            <td>En Espera</td>
                            <td>N/A</td>
                        </tr>
                        <tr>
                            <td>SOL-008</td>
                            <td>Solicitud</td>
                            <td>Informe de auditoría</td>
                            <td>2024-06-15</td>
                            <td>Resuelto</td>
                            <td>2024-06-20</td>
                        </tr>
                        <tr>
                            <td>EXP-009</td>
                            <td>Expediente</td>
                            <td>Consulta legal</td>
                            <td>2024-07-10</td>
                            <td>En Proceso</td>
                            <td>2024-07-15</td>
                        </tr>
                        <tr>
                            <td>SOL-010</td>
                            <td>Solicitud</td>
                            <td>Subsidio gubernamental</td>
                            <td>2024-08-05</td>
                            <td>Aprobado</td>
                            <td>2024-08-10</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div> <!-- end col -->
</div> <!-- end row -->

{{-- MODAL DE REGISTRO --}}
<div class="modal fade" id="registrarNuevo" tabindex="-1" role="dialog" aria-labelledby="registrarNuevo"
    aria-hidden="false" data-bs-backdrop="static">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header ">
                <h6 class="modal-title m-0" id="">REGISTRAR SOLICITUD</h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div><!--end modal-header-->


            {{-- <form class="form-parsley" onsubmit="registrarSolicitud()" enctype="multipart/form-data" id="formDocumentos"> --}}
            <form class="form-parsley" action="{{ route('tramite.solicitud.registrar') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row pb-3">
                        <div class="col-md-12">
                            <label>Seleccione el tipo de servicio</label>
                            <span class="text-muted pb-3">(Opcional) </span>
                            <select class="select2 form-control mb-3 custom-select form-select"
                                onchange="getTupaSelect(event,0)" style="width: 100%; height:36px;" id="P_TUPA"
                                name="P_TUPA">
                            </select>
                        </div>
                    </div>
                    {{-- CARDS DE INFROMACION DEL TUPA --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <div class="card">
                                    <div class="card-header bg-secondary card-pa">
                                        <h6 class="card-title text-white">Formatos</h6>
                                    </div>
                                    <div class="card-body card-pa">
                                        <p class="card-text text-muted">Descarge el formato</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <div class="card">
                                    <div class="card-header bg-secondary card-pa">
                                        <h6 class="card-title text-white">Duracicón del Trámite</h6>
                                    </div>
                                    <div class="card-body card-pa">
                                        <p class="card-text text-muted">El tramite elegido tiene un
                                            plazo de <strong id="PLAZO_TUPA" name="PLAZO_TUPA">N/A</strong>
                                        </p>
                                        <input type="hidden" id="P_PLAZO_TUPA" name="P_PLAZO_TUPA">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TIPO DE DOCUMENTO - POR EL MOMENTO --}}
                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label" for="P_TIPO_DOCUMENTO">Seleccione el Tipo de Documento</label>
                            <div class="form-group d-flex justify-content-center aling-item-center">
                                <div class="col-md-5">
                                    <select name="P_TIPO_DOCUMENTO" class="form-select" id="P_TIPO_DOCUMENTO"
                                        required>
                                    </select>
                                </div>
                                <div class="col-md-2 d-flex justify-content-center aling-item-center">
                                    <i data-feather="minus"></i>
                                </div>
                                <div class="col-md-5">
                                    <input type="text" class="form-control border" name="P_NRO_DOCUMENTO"
                                        id="P_NRO_DOCUMENTO" placeholder="Numero de documento" required>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="P_NRO_EXPEDIENTE">Ingrese el Expediente
                                referencial (Opcioal) </label>
                            <div class="form-group d-flex justify-content-center aling-item-center">
                                <div class="col-md-5">
                                    <input type="text" class="form-control border" name="P_NRO_EXPEDIENTE"
                                        id="P_NRO_EXPEDIENTE" placeholder="Numero del expediente" required>
                                </div>
                                <div class="col-md-2">
                                    <div class="justify-content-center aling-item-center">
                                        <i data-feather="minus"></i>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <select name="P_ANIO_EXPEDIENTE" class="form-select " id="P_ANIO_EXPEDIENTE"
                                        required>
                                        <option value="2024">2024</option>
                                        <option value="2023">2023</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ASUNTO --}}
                    <div class="row pb-3">
                        <div class="col-md-12">
                            <label class="mb-2">Ingrese el asunto</label>
                            <textarea class="form-control " rows="5" id="P_ASUNTO" name="P_ASUNTO" placeholder="Escriba aquí.." required
                                onkeyup="longitudTextAsunto('P_ASUNTO','textoMaximo');" minlength="15" maxlength="200" style="height: 96px;"></textarea>
                            <small id="textoMaximo"></small>
                        </div>
                    </div>

                    {{-- ARCHIVO PRINCIPAL -- Y --- ANEXOS  --}}
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <label class="card-title" for="P_ARCHIVO_PRIN">Documento
                                        principal:</label>
                                    <span class="text-muted pb-3">Peso máximo: 50 MB en total, solo se
                                        aceptan formato pdf</span>
                                </div>
                                <div class="card-body ">
                                    <input type="file" id="P_ARCHIVO_PRIN" name="P_ARCHIVO_PRIN"
                                        class="dropify rounded form-file" data-allowed-file-extensions="pdf"
                                        data-max-file-size-preview="50" required data-errors-position="outside"
                                        onchange="uploadPrincipal(event,50)" />
                                </div>
                            </div>
                        </div>

                        {{-- ANEXOS --}}
                        <div class="col-md-6">
                            <fieldset>
                                <div class="repeater-default">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="form-group mb-0 row">
                                                <div class="col-md-12 row">
                                                    <div class="col-md-8">
                                                        <label class="card-title" for="">
                                                            Anexos (Opcional) :</label>
                                                        <span class="text-muted pb-3">Peso máximo por
                                                            anexo es 20MB, el formato puede ser pdf,
                                                            word y jpg;</span>
                                                    </div>
                                                    <div
                                                        class="col-md-4 d-flex justify-content-center aling-item-center">
                                                        <span data-repeater-create="" id="AGREGAR_ANEXO"
                                                            class="btn btn-outline-success pt-2">
                                                            <span class="fas fa-plus"></span> Agregar
                                                            anexo
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div data-repeater-list="LIST_ANEXOS">
                                                <div data-repeater-item="">
                                                    <div class="form-group row d-flex align-items-end">
                                                        <div class="col-md-8">
                                                            <input type="file" class="form-control rounded "
                                                                name="P_ANEXOS" id="P_ANEXOS"
                                                                accept="application/pdf,image/png,image/jpeg,.doc,.docx"
                                                                data-max-file-size="20" data-errors-position="outside"
                                                                onchange="uploadAnexo(event,20)" required>
                                                        </div>
                                                        <div class="col-md-3">
                                                            <span data-repeater-delete=""
                                                                class="btn btn-outline-danger">
                                                                <span class="far fa-trash-alt me-1"></span>Eliminar
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-danger"><i class="typcn typcn-tick"></i>
                        REGISTRAR</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                        onclick="limpiarModal()"><i class="typcn typcn-times"></i> CANCELAR</button>
                </div>
            </form>

        </div>
    </div>
</div>
