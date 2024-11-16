$(document).ready(function () {
    postSolicitudes(); // solo listar
});

function postSolicitudes() {

    var url = 'tramite/solicitud/tramitadorLista';
    fetchGet(url, function (result) {
        data = result;
        mostrarDatosTabla_AdminSolicitud(data, '#dataSolicitud');
    });

}

function limpiarFiltro(){
    $('#FILTRO_EXPEDIENTE').val('');
    $('#FILTRO_TIPO_EXPEDIENTE').val('0');
    $('#FILTRO_ESTADO').val('0').trigger('change');
    $('#FILTRO_FECHA_INICIO').val('');
    $('#FILTRO_FECHA_FIN').val('');
}

function reducir(data) {
    if (data) {
        return data.length > 50 ? `${data.substring(0, 50)}...` : data
    }
    return '';
}


function mostrarDatosTabla_AdminSolicitud(data, idtabla) {
    const minPalabras = 50;
    $(idtabla).DataTable({
        data: data,
        columns: [
            { data: 'SOLI_ID' },
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
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#registrarObservacion" class="btn btn-purple w-100" ><i class="fas fa-pencil-alt m-1"></i>OBSERVAR</button>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#verDetalleSolicitud" class="btn btn-info w-10"   onclick="seguimientoAdministrativo(${data.SOLI_ID});"><i class="fas fa-route m-1"></i>VER SEGUIMIENTO</button>
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
    });
}

/*
function obtenerDatosRegistro(soli_id){
    let url = 'tramite/solicitud/' + soli_id;
    fetchGet(url, function(result){
        if (result['error']) {
           return showMessageSweetRegister('error',result['error'] )
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

}*/

// =============== TODO REGISTRO DE OBSERVACION ============================
function mostrarDataSolicitud(data){
    setValue('M_NRO_SOLICITUD',data['solicitud'].SOLI_NU_EMI);
    setValue('M_FECHA_PRESENTACION',data['solicitud'].SOLI_FECHA);
    setValue('M_ASUNTO',data['solicitud'].SOLI_ASUNTO);
    setValue('M_EXPEDIENTE',data['solicitud'].SOLI_NRO_EXPEDIENTE);
    setValue('M_OBSERBACION',data['solicitud'].SOLI_OBSERVACION);

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
    const pathAdicional = '../../storage/app'
    archivoPrincipal.innerHTML += `<li><a href="${pathAdicional+'/' + data['archivoPrincipal'].ARCHIPRIN_NOMBRE_FILE_ORIGEN}"  target="_blank">${data['archivoPrincipal'].ARCHIPRIN_NOMBRE_FILE}</a></li>`

    //anexo
    var anexos = document.getElementById('ANEXOS');
    if(data['anexos']){
        anexos.innerHTML += '<ul class="m-0">' 
        data['anexos'].forEach(anexo => {
            anexos.innerHTML += `<li><a href="${pathAdicional +'/'+ anexo.ANEX_NOMBRE_FILE_ORIGEN}" target="_blank" >${anexo.ANEX_NOMBRE_FILE}</a></li>`;
        });
         anexos.innerHTML += '</ul>'
    }
}

function actualizarTipoOperacion(tipo){
    // validar el tipo de envio * Validar solicutd  * enviar observacion | primero valida la observacion 
    setValue('TIPO_REGISTRO_OBSERVACION',tipo);
    const lentObservacion = getValue('P_MENSAJE_OBSERVACION');
    const min = $('#P_MENSAJE_OBSERVACION').attr('minlength');

    if(lentObservacion.length < min){
        longitudTextAsunto('P_MENSAJE_OBSERVACION','textoMaximo');
        return;
    }
    document.getElementById('formObservacion').submit();
}

function esFechaMayorQueHoy(fechaInputId) {
    const fechaSubsanacion = getValue('P_FECHA_LIMITE_SUBSANACION');
    const fechaIngresada = new Date(fechaSubsanacion);
    const fechaActual = new Date(); // Obtener la fecha actual solo con Y-m-d
    fechaActual.setHours(0, 0, 0, 0); // Resetea horas, minutos, segundos y milisegundos a 0
    if (fechaActual > fechaIngresada) {
        showMessageSweet('warning','La fecha de subsanacion debe ser mayor a la fecha actual');
        setValue('P_FECHA_LIMITE_SUBSANACION', '')
        return false;
    }
}
 
function cargarArchivoGuia(event, cant = 2) {
    const file = event.target.files[0];
    if (file) {
        const fileSize = file.size;
        const maxSize = cant * 1024 * 1024; 
        console.log(fileSize,maxSize);
        
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
    }
}

// Illuminate\Database\QueryException: SQLSTATE[HY000] [1045] Access denied for user &#039;forge&#039;@&#039;localhost&#039; (using password: NO) 
// (Connection: mysql, SQL: EXEC MDSJL.MOSTRAR_SOLICITUDES 76815943) 
// in file C:\laragon\www\MPVSJL\vendor\laravel\framework\src\Illuminate\Database\Connection.php on line 829
