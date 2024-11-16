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

    $(idtabla).DataTable({
        data: data,
        columns: [
            { data: 'SOLI_ID' },
            { data: 'SOLI_NU_EMI' },
            { data: 'SOLI_FECHA' },
            { data: 'SOLI_NRO_EXPEDIENTE' },
            {
                data: 'SOLI_ASUNTO',
                render: (data) => data.length > 50 ? `${data.substring(0, 50)}...` : data
            },
            {
                data: 'SOLI_OBSERVACION',
                render: function (data) {
                    if (data) {
                        return data.length > 50 ? `${data.substring(0, 50)}...` : data
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
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#verDetalleSolicitud" class="btn btn-purple w-100" onclick="obtenerDatosRegistro_AdminSolicitud(${data.SOLI_ID});" ><i class="fas fa-eye m-1"></i>VER DATOS </button>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#registrarObservacion" class="btn btn-purple w-100" onclick="limpiarModalObservar(${data.SOLI_ID});" ><i class="fas fa-pencil-alt m-1"></i>OBSERVAR</button>
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

function obtenerDatosRegistro_AdminSolicitud(soli_id){
    // console.log("paramtro", soli_id);
    
    let url = 'tramite/solicitud/' + soli_id;
    fetchGet(url, function(result){
        if (result['error']) {
           return showMessageSweetRegister('error',result['error'] )
        }
        limpiarDatosSolicitud();
        mostrarDataSolicitud(result);

    })
}

function limpiarDatosSolicitud(){
    setValue('M_NRO_SOLICITUD','');
    setValue('M_FECHA_PRESENTACION','');
    setValue('M_ASUNTO','');
    setValue('M_EXPEDIENTE','');
    setValue('M_OBSERBACION',''); 
    var estado = document.getElementById('M_ESTADO')
    var genero = document.getElementById('M_GENERO')
    var archivoPrincipal = document.getElementById('ARCHIVOPRINCIPAL')
    var anexos = document.getElementById('ANEXOS');
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

function limpiarModalObservar(id_solicitud){
    setValue('P_MENSAJE_OBSERVACION','');
    $("#P_MENSAJE_OBSERVACION").removeClass('is-valid');
    $("#P_MENSAJE_OBSERVACION").removeClass('is-invalid');
    $("#P_MENSAJE_OBSERVACION").removeClass('invalid-feedback');
    $("#P_MENSAJE_OBSERVACION").removeClass('valid-feedback');

    setValue('ID_SOLICITUD',id_solicitud)
    var tex = document.getElementById('textoMaximo');
    tex.innerHTML = '';
    setValue('P_FECHA_LIMITE_SUBSANACION','');
    setValue('P_ARCHIVO_OBSERVACION','');
    $('.form-parsley').parsley().reset();
}
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

function RegistrarValidacionSolicitud(){
    // const archivoGuia = $('#P_ARCHIVO_OBSERVACION').prop("files")[0];
    // const archivoGuia2 = document.getElementById('P_ARCHIVO_OBSERVACION');
    // const observacion = getValue('P_MENSAJE_OBSERVACION');
    // const fechaLimite = getValue('P_FECHA_LIMITE_SUBSANACION');
    // let min = parseInt($("#P_MENSAJE_OBSERVACION" ).attr("minlength"));
    // if (observacion && observacion.length < min) {
    //     showMessageSweet('warning','La observacion debe ser valido');
    //     return false;
    // }
    // let url = 'administrarSolicitud/registrarObservacion';
    // fetchPost(url,data, function(result){
    //     return showMessageSweetRegister(result['tipo'],result['mensaje'] )
    // })
    setValue('TIPO_REGISTRO_OBSERVACION', 1);

}
// function registrarObservacion(tipo){
//     setValue('TIPO_REGISTRO_OBSERVACION', tipo);
// }

// setValue('TIPO_REGISTRO_OBSERVACION', tipo);
// setValue('TIPO_REGISTRO_OBSERVACION','1')
function actualizarTipoOperacion(tipo){
     document.getElementById('TIPO_REGISTRO_OBSERVACION').value = tipo
    document.getElementById('formObservacion').submit();
}



function esFechaMayorQueHoy(fechaInputId) {
    // const fechaInput = document.getElementById(fechaInputId).value;
    const fechaSubsanacion = getValue('P_FECHA_LIMITE_SUBSANACION');
    const fechaIngresada = new Date(fechaSubsanacion);
    
    // Obtener la fecha actual solo con Y-m-d
    const fechaActual = new Date();
    fechaActual.setHours(0, 0, 0, 0); // Resetea horas, minutos, segundos y milisegundos a 0
 
    if (fechaActual > fechaIngresada) {
        showMessageSweet('warning','La fecha de subsanacion debe ser mayor a la fecha actual');
        return false;
    }
}
 

function cargarArchivoGuia(event, cant = 2) {

    const file = event.target.files[0];
    // console.log(file);
    
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
