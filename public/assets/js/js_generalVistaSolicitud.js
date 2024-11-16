
// ===================== TODO MOSTRAR DATOS DE LA SOLICITUD ============================
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