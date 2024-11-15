function obtenerDatosRegistro(soli_id){
    console.log("paramtro", soli_id);
    
    let url = 'tramite/solicitud/' + soli_id;
    fetchGet(url, function(result){
        if (result['error']) {
            showMessageSweetRegister('error',result['error'] )
        }
        limpiarDataSolicitud();
        mostrarDataSolicitud(result);
    })
}

function limpiarDataSolicitud(){
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
    archivoPrincipal.innerHTML += `<li><a href="${data['archivoPrincipal'].ARCHIPRIN_NOMBRE_FILE_ORIGEN}"  target="_blank">${data['archivoPrincipal'].ARCHIPRIN_NOMBRE_FILE}</a></li>`

    //anexo
    var anexos = document.getElementById('ANEXOS');
    if(data['anexos']){
        anexos.innerHTML += '<ul class="m-0">' 
        data['anexos'].forEach(anexo => {
            anexos.innerHTML += `<li><a href="${anexo.ANEX_NOMBRE_FILE_ORIGEN}" target="_blank" >${anexo.ANEX_NOMBRE_FILE}</a></li>`;
        });
         anexos.innerHTML += '</ul>'
    }
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