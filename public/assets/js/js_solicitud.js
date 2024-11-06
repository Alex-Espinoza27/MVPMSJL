
// no se puede poner dentro del  abrimodal porque se repite dos veces el anexo
$(document).ready(function () {
    // $('.repeater-default').repeater({
    //     showFirstItem: false,
    //     initEmpty: true,
    //     defaultValues: {
    //         'text-input': ''
    //     },
    //     show: function () {
    //         $(this).slideDown();
    //     },
    //     hide: function (deleteElement) {
    //         $(this).slideUp(deleteElement);
    //     }
    // });
    getTupa();

});


function abrirModal() {
    $(".select2").select2({
        width: "100%",
        dropdownParent: $("#registrarNuevo")
    });
    limpiarModal();
    getTipoDocumento();
}


function limpiarModal() {
    console.log("entreo");

    // Restablecer el estado de validación de Parsley
    $('.form-parsley').parsley().reset();

    // Limpiar todos los campos de texto y textarea
    $('#P_NRO_DOCUMENTO').val('');
    $('#P_NRO_EXPEDIENTE').val('');
    $('#P_TIPO_DOCUMENTO').val('').trigger('change');  // Para limpiar y restablecer el select2 si usas select2
    $('#P_ANIO_EXPEDIENTE').val('2024').trigger('change'); // Restablecer el valor por defecto

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

    document.getElementById('P_ARCHIVO_PRIN').value = null;
    $('#P_ARCHIVO_PRIN').val('');
    $('.dropify').dropify('destroy');
    $('#P_ARCHIVO_PRIN').dropify();
    console.log(document.getElementById('P_ARCHIVO_PRIN').value);

    // Limpiar los anexos generados por el repeater
    $('input[id^="P_ANEXOS[]"]').each(function () {
        $(this).val('').dropify('reset');  // Limpiar el input de archivo de Dropify
    });

    // Eliminar los anexos del repeater
    $('div[data-repeater-item]').each(function () {
        $(this).remove();  // Elimina los elementos del repeater
    });

    //  // Restablecer al valor por defecto
    $('#P_TUPA').val('0').trigger('change');

}
function registrarSolicitud() {
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
    var dataAdicional = selectedOption.getAttribute("dataAdicional");
    const plazoElement = document.getElementById('PLAZO_TUPA');
    plazoElement.textContent = dataAdicional || 'N/A';
    document.getElementById("P_PLAZO_TUPA").value = (dataAdicional === 'N/A' || dataAdicional === null) ? 0 : dataAdicional;
    // if (dataAdicional){ 
    //     document.getElementById("P_PLAZO_TUPA").value = (dataAdicional=='N/A')?  0 : dataAdicional ;
    // }
}

function getTipoDocumento() {
    let url = 'tramite/solicitud/tipoDocumento';
    fetchGet(url, function (result) {
        llenarCombo(result, 'P_TIPO_DOCUMENTO', 'TIPDOC_DESCRIPCION', 'TIPDOC_ID', '', '', '');
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

function uploadMainFail(event, cant = 2) {
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
    const anexos = document.querySelectorAll('input[id="P_ANEXOS[]"]');
    const archivos = [];
    var maxSizeTotal = (2) //* 1024 * 1024;
    var totalMB = 0;

    console.log("entro");

    if (file) {
        const fileSize = file.size;
        const maxSize = cant * 1024 * 1024;
        console.log("entro al if: ", fileSize);
        // Habilitarlo el span de agregar anexo
        // document.getElementById('AGREGAR_ANEXO').style.pointerEvents = 'auto';
        // document.getElementById('AGREGAR_ANEXO').style.opacity = '1';

        // Array de tipos de archivos permitidos
        const TiposPermitidos = [
            'application/pdf',
            'application/docx',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // Para .docx
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
            // document.getElementById('AGREGAR_ANEXO').style.pointerEvents = 'none';
            // document.getElementById('AGREGAR_ANEXO').style.opacity = '0.6';
            return false;
        }
    }
    console.log("Archivos seleccionados:", archivos);
    // $(document).on("click", "#AGREGAR_ANEXO", function() {
    // });  
}

function registerSoli(event) {
    // Crear un objeto FormData para enviar los datos del formulario
    let formData = new FormData();
    console.log("entro al form");
    
    // Obtener valores de los campos de texto y selects
    formData.append('P_TUPA', document.getElementById('P_TUPA').value);
    formData.append('PLAZO_TUPA', document.getElementById('PLAZO_TUPA').innerText);  // Si 'plazo' es un <strong> dentro de una etiqueta
    formData.append('P_ASUNTO', document.getElementById('P_ASUNTO').value);
    formData.append('P_TIPO_DOCUMENTO', document.getElementById('P_TIPO_DOCUMENTO').value);
    formData.append('P_NRO_EXPEDIENTE', document.getElementById('P_NRO_EXPEDIENTE').value);
    formData.append('P_ANIO_EXPEDIENTE', document.getElementById('P_ANIO_EXPEDIENTE').value);

    // Obtener el archivo principal
    const archivoPrincipal = document.getElementById('P_ARCHIVO_PRIN').files[0];
    if (archivoPrincipal) {
        formData.append('P_ARCHIVO_PRIN', archivoPrincipal);
    }

    // Obtener los anexos
    const anexos = document.querySelectorAll('input[id^="P_ANEXOS[]"]');
    anexos.forEach((input, index) => {
        const archivoAnexo = input.files[0];
        if (archivoAnexo) {
            formData.append(`P_ANEXOS[${index}]`, archivoAnexo);  // Enviar anexos con nombre de campo P_ANEXOS[n]
        }
    });

    console.log(formData);
    
    // Enviar el formulario a la ruta '/solicitud/registrar' con método POST
    // fetch('/solicitud/registrar', {
    //     method: 'POST',
    //     body: formData,
    //     headers: {
    //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')  // Para enviar el token CSRF
    //     }
    // })
    //     .then(response => response.json())  // Aquí puedes manejar la respuesta, por ejemplo si es exitosa o si hay errores
    //     .then(data => {
    //         console.log(data);  // Aquí puedes manejar la respuesta de la API (como éxito o error)
    //         alert('Solicitud registrada con éxito');
    //     })
    //     .catch(error => {
    //         console.error('Error al registrar la solicitud:', error);
    //         alert('Ocurrió un error al registrar la solicitud.');
    //     });
}

function showMessageSweetRegister(p_ico,p_title) {
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            // toast.onmouseenter = Swal.stopTimer;s
            toast.onmouseleave = Swal.resumeTimer;
        }
    });
    Toast.fire({
        icon: p_ico,
        title: p_title
    });
}