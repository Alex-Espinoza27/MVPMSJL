
document.getElementById("P_TIPO_PERSONA").addEventListener("change", function () {
    var rucField = document.getElementById("GROUP-RUC");
    var razField = document.getElementById("GROUP-RA_ZO");
    var direcField = document.getElementById("GROUP-DIREC_EM");
    var GrupoPerJuField = document.getElementById("GRUPO-PER-JURIDICA");

    var rucIn = document.getElementById("P_RUC");
    var razIn = document.getElementById("P_RAZON_SOCIAL");
    var direIn = document.getElementById("P_DIRECCION_EMPRESA");

    if (!rucField || !razField || !direcField) {
        console.error("Uno o más campos no existen en el DOM");
        return;
    }
    if (this.value === "2") {
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

});
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
    let url = 'departamentos';
    fetchGet(url, function (result) {
        result.forEach(element => {
            console.log(result);
            
        }); 
    });
}

function actualizar(data) {
    
}

function departamentos() {
    let url = 'departamentos';
    fetchGet(url, function (result) {
        result.forEach(element => {
            $('#P_DEPARTAMENTO').append(
                '<option value="' + element.UBDEP + ' "> ' +
                element.NODEP + '</option>'
            )
        });
        $('#P_DEPARTAMENTO').prop('disabled', false);
    });
}


$(document).ready(function () {
    $('#P_DEPARTAMENTO').change(function () {
        var departamento = $(this).val();

        if (departamento) {

            $('#P_PROVINCIA').prop('disabled', false).empty().append(
                '<option value="" selected="">---------Seleccione---------</option>');

            let url = 'departamentos';

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
    });

    $('#P_DEPARTAMENTO').change(function () {
        var departamento = $(this).val();

        $('#P_PROVINCIA').prop('disabled', true).empty().append(
            '<option value="" selected="">---------Seleccione---------</option>');
        $('#P_DISTRITO').prop('disabled', true).empty().append(
            '<option value="" selected="">---------Seleccione---------</option>');

        console.log('dep ', departamento);
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
    });

    $('#P_PROVINCIA').change(function () {
        var departamento = document.getElementById('P_DEPARTAMENTO').value;
        var provincia = $(this).val();
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
    });
});
