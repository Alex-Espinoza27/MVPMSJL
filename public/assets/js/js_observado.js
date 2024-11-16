// $(function () {
//     $('[data-toggle="tooltip"]').tooltip({
//         container: 'body',
//         html: true
//     });
// });

$(document).ready(function () {
    observados()
});


function observados() {
    var url = 'observado/lista';
    fetchGet(url, function (result) {
        data = result;
        mostrarData(data);
    });

    $('#FILTRO_EXPEDIENTE').val('');
    $('#FILTRO_TIPO_EXPEDIENTE').val('0');
    $('#FILTRO_ESTADO').val('0').trigger('change');
    $('#FILTRO_FECHA_INICIO').val('');
    $('#FILTRO_FECHA_FIN').val('');
}

function reducir(data) {
    if(data){
        return data.length > 50 ? `${data.substring(0, 50)}...` : data
    }
    return '';
}

function mostrarData(data) {
    const minPalabras = 50;
    $('#datatable').DataTable({
        data: data,
        columns: [
            { data: 'SOLI_NU_EMI' },
            { data: 'SOLI_FECHA' },
            { data: 'SOLI_NRO_EXPEDIENTE' },
            {
                data: 'SOLI_ASUNTO',
                render: (data) => data.length > minPalabras ? `${data.substring(0, minPalabras)}...` : data
            },
            {
                data: 'SOLI_OBSERVACION',
                render: function (data) {
                    if (data) {
                        return data.length > minPalabras ? `${data.substring(0, minPalabras)}...` : data
                    }
                    return '';
                }
            },
            { data: 'CANTIDAD_ANEXO' },
            {
                data: null,
                render: (data) => `<span class="badge ${data.ESTA_COLOR}">${data.ESTA_DESCRIPCION}</span>`
            },
            {
                data: null,
                render: function (data) {
                    return `
                        <div class="container">
                            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i
                                 class="fas fa-ellipsis-v"></i></button>
                            <div class="dropdown-menu">
                                <div class="d-flex flex-column align-items-center gap-2 ">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#verDetalleSolicitud" class="btn btn-purple w-100" onclick="obtenerDatosRegistro(${data.SOLI_ID});" ><i class="fas fa-eye m-1"></i>VER DATOS </button>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#subsanarDocumentoModal" class="btn btn-info w-100"   onclick="subsanarSolicitud(${data.SOLI_ID});"><i class="fas fa-route m-1"></i>SUBSANAR SOLICITUD</button>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#" class="btn btn-info w-10"   onclick="mostrarSeguimientoRegistro(${data.SOLI_ID});"><i class="fas fa-route m-1"></i>VER SEGUIMIENTO</button>
                            </div>
                            </div>
                        </div>
                        `;
                }
            }
        ],
        responsive: true,
        destroy: true
    });
}

function subsanarSolicitud(solicitud_id){

}

function mostrarSeguimientoRegistro(solicitud_id){

}
