// $(".select2").select2({
//     width: "100%",
//     dropdownParent: $("#registrarNuevo")
// });

$(document).ready(function () {
//     $('.repeater-default').repeater({
//         showFirstItem: false, 
//         initEmpty: true, 
//         defaultValues: {
//             'text-input': ''
//         },
//         show: function () {
//             $(this).slideDown(); 
//         },
//         hide: function (deleteElement) {
//             $(this).slideUp(deleteElement);
//         }
//     }); 
    getTupa();
});


function abrirModal() {
    $(".select2").select2({
        width: "100%",
        dropdownParent: $("#registrarNuevo")
    });

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
        // getTupa();
    });

    // mostrar TUPA
    getTipoDocumento();
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
    console.log(selectedOption);
    var dataAdicional = selectedOption.getAttribute("dataAdicional");
    const plazoElement = document.getElementById('plazo');
    plazoElement.textContent = dataAdicional || 'N/A';
}

function getTipoDocumento() {
    let url = 'tramite/solicitud/tipoDocumento';
    fetchGet(url, function (result) {
        llenarCombo(result, 'P_TIPO_DOCUMENTO', 'TIPDOC_DESCRIPCION ', 'TIPDOC_ID');
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
function uploadAnexoFail(event, cant = 2) {
    const file = event.target.files[0];
    const anexos = document.querySelectorAll('input[id="P_ANEXOS[]"]');
    const archivos = [];
    var maxSizeTotal = (100) * 1024 * 1024;
    var totalMB = 0;

    console.log("entro");
    if (file) {
        const fileSize = file.size;
        const maxSize = cant * 1024 * 1024;
        console.log("entro al if: ", fileSize);
        // Array de tipos de archivos permitidos
        const allowedTypes = [
            'application/pdf',
            'application/docx',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // Para .docx
            'image/jpeg', // Para JPG
            'image/png' // Para PNG
        ];
        if (!allowedTypes.includes(file.type)) {
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
            showMessageSweet('error', 'Opss!', 'Solamente se permiten 100 MB en total de anexos.');
            event.target.value = null;
            return false;
        }
    }
    console.log("Archivos seleccionados:", archivos);
    // $(document).on("click", "#AGREGAR_ANEXO", function() {
    // });  
}


