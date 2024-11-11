
// document.getElementById("P_TIPO_PERSONA").addEventListener("change", function () {
//     var rucField = document.getElementById("GROUP-RUC");
//     var razField = document.getElementById("GROUP-RA_ZO");
//     var direcField = document.getElementById("GROUP-DIREC_EM");
//     var GrupoPerJuField = document.getElementById("GRUPO-PER-JURIDICA");

//     var rucIn = document.getElementById("P_RUC");
//     var razIn = document.getElementById("P_RAZON_SOCIAL");
//     var direIn = document.getElementById("P_DIRECCION_EMPRESA");

//     if (!rucField || !razField || !direcField) {
//         console.error("Uno o más campos no existen en el DOM");
//         return;
//     }
//     if (this.value === "2") {
//         rucField.style.display = "block";
//         razField.style.display = "block";
//         direcField.style.display = "block";
//         GrupoPerJuField.style.display = "block";
//         rucIn.required = true;
//         razIn.required = true;
//         direIn.required = true;

//     } else {
//         rucField.style.display = "none";
//         razField.style.display = "none";
//         direcField.style.display = "none";
//         GrupoPerJuField.style.display = "none";
//         rucIn.required = false;
//         razIn.required = false;
//         direIn.required = false;
//     }
// });


$(document).ready(function () {
    var ok =''
    ok = usuarioLogeado();
    // departamentos();
    if(!ok){
        usuarioLogeado();
        console.log('volvio a ejecutarse');
        
    }
});


function tipoPersona(tipo) {
    var rucField = document.getElementById("GROUP-RUC");
    var razField = document.getElementById("GROUP-RA_ZO");
    var direcField = document.getElementById("GROUP-DIREC_EM");
    var GrupoPerJuField = document.getElementById("GRUPO-PER-JURIDICA");

    var rucIn = document.getElementById("P_RUC");
    var razIn = document.getElementById("P_RAZON_SOCIAL");
    var direIn = document.getElementById("P_DIRECCION_EMPRESA");

    if (tipo === '2') {
        rucField.style.display = "block";
        razField.style.display = "block";
        direcField.style.display = "block";
        GrupoPerJuField.style.display = "block";
        rucIn.required = true;
        razIn.required = true;
        direIn.required = true;
    } else {
        rucField.style.display = "none";
        razField.style.display = "none";
        direcField.style.display = "none";
        GrupoPerJuField.style.display = "none";
        rucIn.required = false;
        razIn.required = false;
        direIn.required = false;
    }
    return 'ok';
}

function tipoDocumento() {
    var nuroField = document.getElementById("P_NRO_DOCUMENTO");
    nuroField.value = ''
    if (this.value === "1") {
        nuroField.maxLength = 8;
    } else if (this.value === "2") {
        nuroField.maxLength = 12;
    } else if (this.value === "3") {
        nuroField.maxLength = 8;
    } else {
        // nuroField.maxLength = "";
    }
}


// document.getElementById("P_TIPO_PERSONA").dispatchEvent(new Event("change"));
// document.getElementById("P_TIPO_DOCUMENTO").addEventListener("change", function () {
//     var nuroField = document.getElementById("P_NRO_DOCUMENTO");
//     nuroField.value = ''
//     if (this.value === "1") {  
//         nuroField.maxLength = 8; 
//     } else if (this.value === "2") { 
//         nuroField.maxLength = 12;
//     } else if (this.value === "3") { 
//         nuroField.maxLength = 8;
//     } else {
//         nuroField.maxLength = "";  
//     }
// });
// document.getElementById("P_TIPO_DOCUMENTO").dispatchEvent(new Event("change"));



function usuarioLogeado() {
    let url = 'usuario/usuarioRepresentante';
    var usuario;
    var representante;
    var ok ='';
    fetchGet(url, function (result) {
        console.log(result);
        usuario = result.usuario;
        if (result.representante) {
            representante = result.representante;
        }
        ok = actualizarVista(usuario, representante)
    });
    return ok;
}

function actualizarVista(usuario, representante = '') {
    // console.log(usuario, representante);
    var usuarioActualizar;
    if (representante != '') { // persona juridica
        usuarioActualizar = representante;
    }
    else {
        usuarioActualizar = usuario;
    }
    tipoPersona(usuario.USU_TIPO_PERSONA);

    if (representante != '') {
        setValue('P_TIPO_PERSONA', usuario.USU_TIPO_PERSONA);
        setValue('P_RUC', usuario.USU_NUMERO_DOCUMENTO);
        setValue('P_RAZON_SOCIAL', usuario.USU_RAZON_SOCIAL);
        setValue('P_DIRECCION_EMPRESA', usuario.USU_DIRECCION);
    }
    // else {
    // }

    setValue('P_TIPO_DOCUMENTO', usuarioActualizar.USU_TIPO_DOCUMENTO);
    setValue('P_NRO_DOCUMENTO', usuarioActualizar.USU_NUMERO_DOCUMENTO);
    setValue('P_APELLIDO_PARTERNO', usuarioActualizar.USU_APE_PATERNO);
    setValue('P_APELLIDO_MATERNO', usuarioActualizar.USU_APE_MATERNO);
    setValue('P_NOMBRES', usuarioActualizar.USU_NOMBRES);
    setValue('P_DIRECCION_PERSONA', usuarioActualizar.USU_DIRECCION);
    setValue('P_CELULAR', usuarioActualizar.USU_NU_CELULAR);
    setValue('P_CORREO', usuarioActualizar.USU_CORREO);

    if( usuarioActualizar.USU_SEXO){
        setValue('P_GENERO', usuarioActualizar.USU_SEXO);
    }
    if( usuarioActualizar.USU_FEC_NACE){
        setValue('P_FECHA_NACIMIENTO', usuarioActualizar.USU_FEC_NACE);
    }

    let urlDepartamento = 'departamentos';
    fetchGet(urlDepartamento, function (result) {
        llenarCombo(result, 'P_DEPARTAMENTO', 'NODEP', 'UBDEP', '', usuarioActualizar.USU_DEPARTAMENTO);
    });
    let urlProvincia = 'provincias/' + usuarioActualizar.USU_DEPARTAMENTO;
    fetchGet(urlProvincia, function (result) {
        llenarCombo(result, 'P_PROVINCIA', 'NOPRV', 'UBPRV', '', usuarioActualizar.USU_PROVINCIA);
    });
    let urlDistrito = 'distritos/' + usuarioActualizar.USU_DEPARTAMENTO + '/' + usuarioActualizar.USU_PROVINCIA;
    fetchGet(urlDistrito, function (result) {
        llenarCombo(result, 'P_DISTRITO', 'NODIS', 'UBDIS', '', usuarioActualizar.USU_DISTRITO);
    });
    return 'ok';
}

function departamentos(departamentoUsuario) {
    let url = 'departamentos';
    fetchGet(url, function (result) {
        llenarCombo(result, 'P_DEPARTAMENTO', 'NODEP', 'UBDEP', '', departamentoUsuario);
    });

    let urlProvincia = 'provincias/' + departamento;
    fetchGet(url, function (result) {
        llenarCombo(result, 'P_DEPARTAMENTO', 'NODEP', 'UBDEP', '', departamentoUsuario);
    });

    let urlDistrito = 'distritos/' + departamento + '/' + provincia;
    fetchGet(url, function (result) {
        llenarCombo(result, 'P_DEPARTAMENTO', 'NODEP', 'UBDEP', '', departamentoUsuario);
    });

}
function provincia(event) {
    var departamento = event.target.value;
    console.log(departamento);

    $('#P_PROVINCIA').prop('disabled', true).empty().append('<option value="" selected="">---------Seleccione---------</option>');
    $('#P_DISTRITO').prop('disabled', true).empty().append('<option value="" selected="">---------Seleccione---------</option>');

    if (departamento) {
        $('#P_PROVINCIA').prop('disabled', false).empty().append(
            '<option value="" selected="">---------Seleccione---------</option>');
        let url = 'provincias/' + departamento;
        fetchGet(url, function (result) {
            result.forEach(element => {
                $('#P_PROVINCIA').append(
                    '<option value="' + element.UBPRV + ' "> ' +
                    element.NOPRV + '</option>'
                )
            });
            $('#P_PROVINCIA').prop('disabled', false);
        });
    }
}
function distrito(event) {
    var departamento = document.getElementById('P_DEPARTAMENTO').value;
    var provincia = event.target.value;
    console.log('dep ', departamento);
    console.log('provin: ', provincia);

    if (provincia) {
        $('#P_DISTRITO').prop('disabled', false).empty().append(
            '<option value="" selected="">---------Seleccione---------</option>');

        let url = 'distritos/' + departamento + '/' + provincia;
        fetchGet(url, function (data) {
            data.forEach(element => {
                $('#P_DISTRITO').append(
                    '<option value="' + element.UBDIS + ' "> ' +
                    element.NODIS + '</option>'
                )
            });
        });
    } else {
        $('#P_DISTRITO').prop('disabled', true).empty().append(
            '<option value="" selected="">---------Seleccione---------</option>');
    }
}


function actualizarDatos() {
    let data = {
        P_TIPO_PERSONA: document.getElementById("P_TIPO_PERSONA").value,
        P_RUC: document.getElementById("P_RUC") ? document.getElementById("P_RUC").value : null,
        P_RAZON_SOCIAL: document.getElementById("P_RAZON_SOCIAL") ? document.getElementById("P_RAZON_SOCIAL").value : null,
        P_DIRECCION_EMPRESA: document.getElementById("P_DIRECCION_EMPRESA") ? document.getElementById("P_DIRECCION_EMPRESA").value : null,
        P_TIPO_DOCUMENTO: document.getElementById("P_TIPO_DOCUMENTO").value,
        P_NRO_DOCUMENTO: document.getElementById("P_NRO_DOCUMENTO").value,
        P_APELLIDO_PARTERNO: document.getElementById("P_APELLIDO_PARTERNO").value,
        P_APELLIDO_MATERNO: document.getElementById("P_APELLIDO_MATERNO").value,
        P_NOMBRES: document.getElementById("P_NOMBRES").value,
        P_DIRECCION_PERSONA: document.getElementById("P_DIRECCION_PERSONA").value,
        P_DEPARTAMENTO: document.getElementById("P_DEPARTAMENTO").value,
        P_PROVINCIA: document.getElementById("P_PROVINCIA").value,
        P_DISTRITO: document.getElementById("P_DISTRITO").value,
        P_CELULAR: document.getElementById("P_CELULAR").value,
        P_CORREO: document.getElementById("P_CORREO").value,
        P_GENERO: document.getElementById("P_GENERO") ? document.getElementById("P_GENERO").value : null,
        P_FECHA_NACIMIENTO: document.getElementById("P_FECHA_NACIMIENTO") ? document.getElementById("P_FECHA_NACIMIENTO").value : null
    };



    let url = 'usuario/actualizarUsuario';
    showMessageConfirm('', '¿Estas seguro de hacer los cambios? ', function (si) {
        if (si.isConfirmed) {
            fetchPost(url, data, function (result) {
                showMessageSweetRegister(result['tipo'], result['mensaje']);
            });
        }

    })








    // showMessageSweetRegister('error', 'noers')

    // showMessageSweet('error', 'noers', 'con 3 parametros')








}



