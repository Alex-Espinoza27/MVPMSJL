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
                                    <input type="text" class="form-control border border-info"
                                        name="FILTRO_EXPEDIENTE" id="FILTRO_EXPEDIENTE"
                                        placeholder="Ingrese el numero del expediente">
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
                            <thead>
                                <tr>
                                    <th>SOLICITUD</th>
                                    <th>FECHA</th>
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