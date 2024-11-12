
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

    var textoMaximo = document.getElementById('textoMaximo').value = '';
    textoMaximo.value = ""
    //  $('#textoMaximo').val('');
    console.log(textoMaximo.value);
    $("#P_ASUNTO").removeClass('invalid-feedback')
    $("#P_ASUNTO").removeClass('is-invalid');
    $("#textoMaximo").removeClass('invalid-feedback');
    $("#textoMaximo").removeClass('valid-feedback');

    document.getElementById('P_ARCHIVO_PRIN').file = null;
    $('#P_ARCHIVO_PRIN').val('');
    // $('.dropify').dropify('destroy');
    // $('#P_ARCHIVO_PRIN').dropify();

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


function longitudTextAsunto(inputID, IDmessage) {
    const mensaje = document.querySelector('#' + inputID);
    const longitud = document.querySelector('#' + IDmessage);
    let min = parseInt($("#" + inputID).attr("minlength"));
    let max = parseInt($("#" + inputID).attr("maxlength"));

    longitud.innerHTML = `Longitud: ${mensaje.value.length} - Mínimo ${min} / Máximo ${max}`;
    const contarLongitud = () => {
        longitud.innerHTML = `Longitud: ${mensaje.value.length} - Mínimo ${min} / Máximo ${max}`;
    }
    if (mensaje.value.length == max) {
        return;
    }
    //console.log(mensaje.value.length,max);
    if (mensaje.value.length < min) {
        $("#" + inputID).addClass('is-invalid');
        $("#" + IDmessage).addClass('invalid-feedback');
    } else {
        $("#" + inputID).removeClass('is-invalid');
        $("#" + inputID).addClass('is-valid');
        $("#" + IDmessage).removeClass('invalid-feedback');
        $("#" + IDmessage).addClass('valid-feedback');
    }
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

    // console.log("entro");

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
        mostrarData(data);
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
    if(data){
        return data.length > 50 ? `${data.substring(0, 50)}...` : data
    }
    return '';
}

function mostrarData(data) {
    const BOTONES = `
            <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-ellipsis-v"></i></button>
                <div class="dropdown-menu">
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-purple"><i class="fas fa-eye m-1"></i>VER DATOS </button>
                        <button type="button" class="btn btn-info"><i class="fas fa-route m-1"></i>VER SEGUIMIENTO</button>
                    </div>    
                </div>
            <button type="button" class="btn btn-warning dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-trash"></i></button>
            `;

    $('#row_callback').DataTable({
        data: data,
        columns: [
            { data: 'SOLI_NU_EMI' },
            { data: 'SOLI_FECHA' },
            { data: 'SOLI_NRO_EXPEDIENTE' },
            {
                data: 'SOLI_ASUNTO',
                render: (data) => data.length > 50 ? `${data.substring(0, 50)}...` : data
            },
            {
                data: 'SOLI_OBSERVACION',
                // render: (data) => data.length > 50 ? `${data.substring(0, 50)}...` : data
            },
            { data: 'CANTIDAD_ANEXO' },
            {
                data: null,
                // render: function (data, type, row) { 
                //     return `<span class="${row.ESTA_COLOR}">${row.ESTA_DESCRIPCION}</span>`;
                // }
                render: (data) => `<span class="badge ${data.ESTA_COLOR}">${data.ESTA_DESCRIPCION}</span>`

            },
            {
                data: null,
                render: function () {
                    return BOTONES;
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
            mostrarData(result.data);
        }
        else {
            showMessageSweet('warning', 'Ocurrio un problema', 'Al filtrar los datos ocurrio un problema, intentalo mas tarde')
        }
    })
}
