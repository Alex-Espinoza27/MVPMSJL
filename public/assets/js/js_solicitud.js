
// no se puede poner dentro del  abrimodal porque se repite dos veces el anexo
$(document).ready(function () {
    $('.repeater-default').repeater({
        showFirstItem: false,
        initEmpty: true,
        defaultValues: {
            'text-input': ''
        },
        show: function () {
            $(this).slideDown();
        },
        hide: function (deleteElement) {
            $(this).slideUp(deleteElement);
        }
    });
    solicitudes(); // solo listar
    getEstadoDocumento();
});

$('#registrarNuevo').on('shown.bs.modal', function () {
    // limpiarModal();
    getTupa();
    $(".select2").select2({
        width: "100%",
        dropdownParent: $("#registrarNuevo")
    });
    getTipoDocumento();

});

$('#registrarNuevo').on('hidden.bs.modal', limpiarModal);

function limpiarModal() {
    console.log("limpiar al modal");
    $('#P_NRO_FOLIOS').val('');
    // $('#P_ANIO_EXPEDIENTE').val('2024').trigger('change');

    $('.form-parsley').parsley().reset();
    $('#P_NRO_DOCUMENTO').val('');
    $('#P_TIPO_DOCUMENTO').val('').trigger('change');

    //  Todo anexos
    $('#P_ASUNTO').val('');

    var textoMaximo = document.getElementById('textoMaximo');
    textoMaximo.innerHTML = ''

    $("#P_ASUNTO").removeClass('is-valid');
    $("#P_ASUNTO").removeClass('is-invalid');
    $("#P_ASUNTO").removeClass('invalid-feedback');
    $("#P_ASUNTO").removeClass('valid-feedback');

    // var archivoPrinci = document.getElementById('P_ARCHIVO_PRIN');
    // archivoPrinci.file = null;

    $('#P_ARCHIVO_PRIN').val('');
    setValue('P_ARCHIVO_PRIN','')

    // Limpiar los anexos generados por el repeater
    $('input[id^="P_ANEXOS[]"]').each(function () {
        $(this).val('').dropify('reset');  // Limpiar el input de archivo de Dropify
    });

    // Eliminar los anexos del repeater
    $('div[data-repeater-item]').each(function () {
        $(this).remove();
    });

    //  // Restablecer al valor por defecto
    $('#P_TUPA').val('0').trigger('change');
}

function getTupa() {
    let url = 'tramite/solicitud/tupa';
    fetchGet(url, function (result) {
        llenarCombo(result, 'P_TUPA', 'DE_NOMBRE', 'CO_PROCESO', 0, '', 'NU_PLAZO');
    });
}

function getTupaSelect(event) {
    const select = event.target;
    // Obtén la opción seleccionada
    var selectedOption = select.options[select.selectedIndex];
    // Obtén el valor del atributo dataAdicional 
    var dataAdicional = (selectedOption.getAttribute("dataAdicional")) ? selectedOption.getAttribute("dataAdicional") : 0;

    const plazoElement = document.getElementById('PLAZO_TUPA');
    plazoElement.textContent = dataAdicional || 'N/A';
    document.getElementById("P_PLAZO_TUPA").value = (dataAdicional === 'N/A' || dataAdicional === null) ? 0 : dataAdicional;

}

function getTipoDocumento() {
    let url = 'tramite/solicitud/tipoDocumento';
    fetchGet(url, function (result) {
        llenarCombo(result, 'P_TIPO_DOCUMENTO', 'TIPDOC_DESCRIPCION', 'TIPDOC_ID', '', '', '');
    });
}
function getEstadoDocumento() {
    let url = 'tramite/solicitud/estadoDocumento';
    fetchGet(url, function (result) {
        console.log(result);
        llenarCombo(result, 'FILTRO_ESTADO', 'ESTA_DESCRIPCION', 'ESTA_ID', 0);
    });
}

function uploadPrincipal(event, cant = 2) {
    const file = event.target.files[0];
    if (file) {
        const fileSize = file.size;
        const maxSize = cant * 1024 * 1024;
        if (file.type != 'application/pdf') {
            showMessageSweet('error', 'Opss!', 'Solo esta permitido archivos PDF.');
            event.target.value = null;
            return false;
        }
        else if (fileSize > maxSize) {
            showMessageSweet('error', 'Opss!',
                `El archivo seleccionado es demasiado grande. Por favor, elige un archivo de hasta ${cant} MB.`);
            event.target.value = null;
        }
    }
}

function uploadAnexo(event, cant = 2) {
    const file = event.target.files[0];
    const anexos = document.querySelectorAll('input[id="P_ANEXOS"]');
    console.log(anexos);

    const archivos = [];
    var maxSizeTotal = (30) //* 1024 * 1024; -> MAXIMO DE 30 MBs
    var totalMB = 0;

    if (file) {
        const fileSize = file.size;
        const maxSize = cant * 1024 * 1024;
        console.log("entro al if: ", fileSize);
        // Array de tipos de archivos permitidos
        const TiposPermitidos = [
            'application/pdf',
            'application/docx',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // Para .docx
            'application/doc', // Para .docx
            'application/msword', // Para .docx
            'image/jpeg',
            'image/png'
        ];

        if (!TiposPermitidos.includes(file.type)) {
            showMessageSweet('error', 'Opss!', 'Solo están permitidos archivos PDF, DOCX, JPG, PNG');
            console.log("file:type: ", file.type);
            event.target.value = null;
            return false;
        }
        if (fileSize > maxSize) {
            showMessageSweet('error', 'Opss!',
                `El archivo seleccionado es demasiado grande. Por favor, elige un archivo de hasta ${cant} MB.`);
            event.target.value = null;
            return false;
        }
        // -------------------------------------------------------------------------------------
        anexos.forEach(input => {
            if (input.files.length > 0) {
                archivos.push(...input.files);
                totalMB += input.files[0].size / (1024 * 1024);
                // totalMB += input.files[0].size / (1024 * 1024);
            }
        });
        console.log("total MB:", totalMB);
        if (totalMB > maxSizeTotal) {
            showMessageSweet('error', 'Opss!', `Solamente se permiten ${maxSizeTotal} MB en total de anexos.`);
            event.target.value = null;
            return false;
        }
    }
    console.log("Archivos seleccionados:", archivos);
}


// ==============================================================================================

function solicitudes() {
    var url = 'tramite/solicitud/lista';
    fetchGet(url, function (result) {
        data = result;
        mostrarDatosTabla(data);
    });

    $('#FILTRO_EXPEDIENTE').val('');
    $('#FILTRO_TIPO_EXPEDIENTE').val('0');

    $('#FILTRO_ESTADO').val('0').trigger('change');
    $('#FILTRO_FECHA_INICIO').val('');
    $('#FILTRO_FECHA_FIN').val('');
}

// function limitarPalabras(texto, limite = 10) {
//     const palabras = texto.split(' ');
//     if (palabras.length > limite) {
//         return palabras.slice(0, limite).join(' ') + '...';
//     }
//     return texto;
// }

// function limitarCaracteres(texto, limite = 50) {
//     if (texto.length > limite) {
//         return texto.substring(0, limite) + '...';
//     }
//     return texto;
// }

// function limitarPalabras(texto, limite = 10) {
//     const palabras = texto.split(' ');
//     if (palabras.length > limite) {
//         return `<span title="${texto}">${palabras.slice(0, limite).join(' ')}...</span>`;
//     }
//     return texto;
// }


function reducir(data) {
    if (data) {
        return data.length > 50 ? `${data.substring(0, 50)}...` : data
    }
    return '';
}

function mostrarDatosTabla(data) {
    const minPalabras = 50;
    $('#row_callback').DataTable({
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
                                <button type="button" data-bs-toggle="modal" data-bs-target="#verDetalleSolicitud" class="btn btn-info w-100"   onclick="mostrarSeguimientoRegistro(${data.SOLI_ID});"><i class="fas fa-route m-1"></i>VER SEGUIMIENTO</button>
                            </div>
                            </div>
                            
                        </div>
                        `;
                    // <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-trash"></i></button>
                }
            }
        ],
        responsive: true,
        destroy: true
        // dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
        //     '<"row"<"col-sm-12"tr>>' +
        //     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
        // buttons: [
        //     'copy', 'excel', 'pdf'
        // ]
    });
}


// ===================== TODO MOSTRAR DATOS DE LA SOLICITUD ============================

/*
function obtenerDatosRegistro(soli_id){
    console.log("paramtro", soli_id);
    
    let url = 'tramite/solicitud/' + soli_id;
    fetchGet(url, function(result){
        if (result['error']) {
            showMessageSweetRegister('error',result['error'] )
        }
        limpiarDatosSolicitud();
        mostrarDataSolicitud(result);
        mostrarDataObservacion(result['solicitud']);
    })
}
function limpiarDatosSolicitud(){
    setValue('M_NRO_SOLICITUD','');
    setValue('M_FECHA_PRESENTACION','');
    setValue('M_FECHA_OBSERVACION','');
    setValue('M_ASUNTO','');
    setValue('M_EXPEDIENTE','');
    setValue('M_OBSERBACION',''); 
    var estado = document.getElementById('M_ESTADO')
    var genero = document.getElementById('M_GENERO')
    var archivoPrincipal = document.getElementById('ARCHIVOPRINCIPAL')
    var anexos = document.getElementById('ANEXOS');
    var cardBody = document.getElementById('cardObservacion');
    cardBody.innerHTML = '';
    estado.innerHTML = '';
    genero.innerHTML = '';
    archivoPrincipal.innerHTML = ''; 
    anexos.innerHTML ='';
    setValue('M_TIPO_PERSONA','' );
    setValue('M_TIPO_DOCUMENTO','' );
    setValue('M_RAZON_SOCIAL','' );
    setValue('M_CORREO','' );
    setValue('M_CELULAR','' );
    setValue('M_DIRECCION','' );
}
function mostrarDataSolicitud(data){
    setValue('M_NRO_SOLICITUD',data['solicitud'].SOLI_NU_EMI);
    setValue('M_FECHA_PRESENTACION',data['solicitud'].SOLI_FECHA);
    setValue('M_ASUNTO',data['solicitud'].SOLI_ASUNTO);
    setValue('M_EXPEDIENTE',data['solicitud'].SOLI_NRO_EXPEDIENTE);
    setValue('M_OBSERBACION',data['solicitud'].SOLI_OBSERVACION);
    setValue('M_FECHA_OBSERVACION',data['solicitud'].SOLI_FECHA_OBSERVACION);

    var estado = document.getElementById('M_ESTADO')
    var genero = document.getElementById('M_GENERO')
    estado.innerHTML += `<span class="badge ${data['estado'].ESTA_COLOR}">${data['estado'].ESTA_DESCRIPCION}</span>`
    
    tipPersona = (data['solicitante'].USU_TIPO_PERSONA =='1') ? 'PERSONA NATURAL': 'PERSONA JURIDICA';
    tipodocumento = (data['solicitante'].USU_TIPO_DOCUMENTO =='1') ? 'DNI': (data['solicitante'].USU_TIPO_DOCUMENTO =='2') ? 'CARNET DE EXTRANJERÍA': (data['solicitante'].USU_TIPO_DOCUMENTO =='3') ? 'PASAPORTE': 'NO TIENE';
    icono = (data['solicitante'].USU_TIPO_PERSONA =='2') ? 'JURIDICA <i class="fab fa-odnoklassniki"></i>' : (data['solicitante'].USU_SEXO =='1') ? ' MASCULINO <i class="fas fa-male"></i>' : 'FEMENINO<i class="fas fa-female"></i> ';
    genero.innerHTML += icono;

    setValue('M_TIPO_PERSONA',tipPersona );
    setValue('M_TIPO_DOCUMENTO',tipodocumento );
    setValue('M_RAZON_SOCIAL',data['solicitante'].USU_RAZON_SOCIAL );
    setValue('M_CORREO',data['solicitante'].USU_CORREO );
    setValue('M_CELULAR',data['solicitante'].USU_NU_CELULAR );
    setValue('M_DIRECCION',data['solicitante'].USU_DIRECCION );
    
    // archivos
    var archivoPrincipal = document.getElementById('ARCHIVOPRINCIPAL')
    archivoPrincipal.innerHTML = ''; 
    const pathAdicional = '../../storage/app/'
    archivoPrincipal.innerHTML += `<li><a href="${pathAdicional + data['archivoPrincipal'].ARCHIPRIN_NOMBRE_FILE_ORIGEN}"  target="_blank">${data['archivoPrincipal'].ARCHIPRIN_NOMBRE_FILE}</a></li>`

    //anexo
    var anexos = document.getElementById('ANEXOS');
    if(data['anexos']){
        anexos.innerHTML += '<ul class="m-0">' 
        data['anexos'].forEach(anexo => {
            anexos.innerHTML += `<li><a href="${pathAdicional+'/' +anexo.ANEX_NOMBRE_FILE_ORIGEN}" target="_blank" >${anexo.ANEX_NOMBRE_FILE}</a></li>`;
        });
         anexos.innerHTML += '</ul>'
    }
}
function mostrarDataObservacion(dataRegistro){
    
    var fechalimite = '';
    var archivoGuia = '';
    if(dataRegistro.SOLI_ESTADO_ID != 3) {return;}

    if(dataRegistro.SOLI_FECHA_LIMITE_SUBSANACION){
        fechalimite = `
            <div class="row mb-2">
                <label class="form-label" for="OBS_FECHA_LIMITE_SUBSANACION"> Fecha Límite de Subsanacíon: </label>
                <input type="text" id="OBS_FECHA_LIMITE_SUBSANACION" class="form-control"  value="${dataRegistro.SOLI_FECHA_LIMITE_SUBSANACION}" disabled />
            </div>
        `
    }
    var patMain = '../../storage/app/'
    if(dataRegistro.SOLI_FILE_OBSERVACION){
        archivoGuia = `
            <div class="row mb-2">
                <label class="form-label" for="P_ARCHIVO_OBSERVACION"> Documento guía: </label>
                <li><a href="${patMain + dataRegistro.SOLI_FILE_OBSERVACION }" target="_blank"> Documento Guia de MPV MDSJL</a></li>
            </div>
        `
    }
                
    var cuerpo = `
        <div class="card border border-warning" >
            <div class="card-header bg-warning">
                <h4 class="card-title text-white">Datos de la Observación</h4>
            </div>
            <div class="card-body">
                ${fechalimite + archivoGuia }        
            </div>
        </div>`
    
    var cardBody = document.getElementById('cardObservacion');
    cardBody.innerHTML += cuerpo;

}
function mostrarSeguimientoRegistro(soli_id){
}
function aplicarFiltro() {
    
    const url = 'tramite/solicitud/filtro';
    // Obtener los valores de los filtros 
    const filtroExpediente = document.getElementById('FILTRO_EXPEDIENTE').value;
    const filtroTipoExpediente = document.getElementById('FILTRO_TIPO_EXPEDIENTE').value;
    const filtroEstado = document.getElementById('FILTRO_ESTADO').value;
    const filtroFechaInicio = document.getElementById('FILTRO_FECHA_INICIO').value;
    const filtroFechaFin = document.getElementById('FILTRO_FECHA_FIN').value;

    // Crear el objeto de datos
    const dataFiltro = {
        FILTRO_EXPEDIENTE: filtroExpediente,
        FILTRO_TIPO_EXPEDIENTE: filtroTipoExpediente,
        FILTRO_ESTADO: filtroEstado,
        FILTRO_FECHA_INICIO: filtroFechaInicio,
        FILTRO_FECHA_FIN: filtroFechaFin
    };
    // console.log(dataFiltro);
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

    if (!token) {
        console.error('CSRF token not found');
        return;
    }
    fetchPost(url, dataFiltro, function (result) {
        if (result.status == 'success') {
            // console.log("adentro",result.data);
            // return result.data;
            mostrarDataTabla(result.data);
        }
        else {
            showMessageSweet('warning', 'Ocurrio un problema', 'Al filtrar los datos ocurrio un problema, intentalo mas tarde')
        }
    })
}
*/ 

// ===================== TODO OBSERVACION ============================


                        


