

function showMessage(tipo = '', contenido = '', titulo = '') {
    //success, info, warning, error
    var toast = toastr[tipo](contenido, titulo)
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": false,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": 500,
        "hideDuration": 1000,
        "timeOut": 5000,
        "extendedTimeOut": 1000,
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    toastr.remove(toast);
}

function showMessageSweet(tipo = '', titulo = '', contenido = '') {
    Swal.fire({
        title: titulo,
        text: contenido,
        icon: tipo,
        showCancelButton: 0,
        confirmButtonColor: "#556ee6",
        cancelButtonColor: "#f46a6a"
    });
}

function showMessageSweetAceptar(tipo = '', titulo = '', contenido = '', callback) {
    Swal.fire({
        title: titulo,
        text: contenido,
        icon: tipo,
        showCancelButton: 0,
        confirmButtonText: 'Aceptar',
        confirmButtonColor: "#556ee6",
        cancelButtonColor: "#f46a6a"
    }).then((result) => {
        callback(result);
    });
}

function Loading() {
    Swal.fire({
        title: 'Cargando..!',
        allowOutsideClick: false,
        allowOutsideClick: false,
        showDenyButton: false,
        showCancelButton: false,
        showConfirmButton: false,
        timer: 5000,
        timerProgressBar: true,
        // onBeforeOpen: () => {
        //     Swal.showLoading()
        // },
    });
}
function closeLoading() {
    swal.close();
}

function showMessageConfirm(title, text, callback) {
    Swal.fire({
        title: title,
        text: text,
        icon: 'warning',
        showDenyButton: false,
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Aceptar'
    }).then((result) => {
        callback(result);
        /*
          if (result.isConfirmed) {
            Swal.fire('Saved!', '', 'success')
          } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
          }*/
    })
}

function openModalRuta(url, conten, idmodal, callback) {
    $(conten).load(urljs + url,
        function () {
            $(idmodal).modal('show');
            callback("ok");
        });
};
function OpenModal(idmodal) {
    $(idmodal).modal('show');
}
function CloseModal(idmodal) {
    $(idmodal).modal('hide');
}

function getValue(id) {
    return document.getElementById(id).value;
}

function setValue(id, value = '') {
    return document.getElementById(id).value = value;
}

function getValueCheckBox(id) {
    let val;
    if ($('#' + id).is(":checked")) {
        val = 1;
    } else {
        val = 0;
    }
    return val;
}

function getValueChecked(val) {
    if (val == true) {
        val = 1;
    } else {
        val = 0;
    }
    return val;
}

function fetchPostText(url, frm, callback) {
    fetch(urljs + url, {
        method: "POST",
        body: frm
    }).then(res => res.json())
        .then(res => {
            callback(res);
        }).catch(err => {
            console.log(err);
        })
}
function fetchPost(url, frm, callback, loading = true) {
    if (loading) {
        $("body").addClass("loader");
    }

    fetch(urljs + url, {
        method: "POST",
        body: JSON.stringify(frm),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    }).then(res => res.json())
        .then(res => {

            if (loading) {
                $("body").removeClass("loader");
            }
            callback(res);
        }).catch(err => {
            if (loading) {
                $("body").removeClass("loader");
            }
            console.log(err);
        })
}

function fetchPostHtml(url, frm, callback, loading = true) {
    if (loading) {
        $("body").addClass("loader");
    }

    fetch(urljs + url, {
        method: "POST",
        body: JSON.stringify(frm),
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
    }).then(res => res.text())
        .then(res => {

            if (loading) {
                $("body").removeClass("loader");
            }
            callback(res);
        }).catch(err => {
            if (loading) {
                $("body").removeClass("loader");
            }
            console.log(err);
        })
}

function LimpiarDatos(idFrm, excepciones = []) {

    var elementos = document.querySelectorAll("#" + idFrm + " [name]");
    for (var i = 0; i < elementos.length; i++) {
        if (!excepciones.includes(elementos[i].name))
            elementos[i].value = "";
    }
}

function fetchGet(url, callback, loading = true) {
    //Loading();
    if (loading) {
        $("body").addClass("loader");
    }
    var urlAbsoluta = urljs + url; 
    fetch(urlAbsoluta).then(res => res.json())
        .then(res => {
            $("body").removeClass("loader");
            //closeLoading();
            callback(res)
        }).catch(err => {
            $("body").removeClass("loader");
            console.log(err);
        }) 
}

function fetchGetHtml(url, callback) {
    var urlAbsoluta = urljs + url;
    fetch(urlAbsoluta)
        .then(function (response) {
            return response.text();
        })
        .then(function (body) {
            callback(body);
        });
}

function llenarCombo(data, id, propiedadMostrar, propiedadId, valueDefecto = "", valueSelected = "", valueAdicional= "") {
    var contenido = ""
    var elemento;
    var AtributoAdicional = ""
    contenido += "<option value='" + valueDefecto + "'>-- Seleccione --</option>"

    // adicional = (valueAdicional != "")? "dataAdicional='"+valueAdicional+"'": "";
    // console.log(AtributoAdicional); 
    // console.log(valueAdicional); 
    
    for (var j = 0; j < data.length; j++) {
        elemento = data[j];

        if(valueAdicional != ""){
            AtributoAdicional = "dataAdicional='"+elemento[valueAdicional]+"'";
        }

        if (elemento[propiedadId] == valueSelected) {
            contenido += "<option value='" + elemento[propiedadId] + "' "+ AtributoAdicional +" selected>" + elemento[propiedadMostrar] + "</option>"
        } else {
            contenido += "<option value='" + elemento[propiedadId] + "' "+ AtributoAdicional +" >" + elemento[propiedadMostrar] + "</option>"
        }
    }
    contenido += "";
    document.getElementById(id).innerHTML = contenido;
}   

function buscarEnTabla(idInput, IdTabla) {
    $(idInput).keyup(function () {
        _this = this;
        $.each($(IdTabla + " tbody tr"), function () {
            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });
}

function soloNumeros(idInput) {
    $(idInput).keypress(
        function (event) {
            //console.log( event.keyCode);

            if ((event.keyCode != 48) && event.keyCode != 8) {
                if (!parseInt(String.fromCharCode(event.which))) {
                    event.preventDefault();
                }
            }
        }
    );
}

function buscarEnTabla(idInput, IdTabla) {
    $(idInput).keyup(function () {
        _this = this;
        $.each($(IdTabla + " tbody tr"), function () {

            if ($(this).text().toLowerCase().indexOf($(_this).val().toLowerCase()) === -1)
                $(this).hide();
            else
                $(this).show();
        });
    });
}
function exportarExcel(idTabla) {
    window.open('data:application/vnd.ms-excel,' + encodeURIComponent($(idTabla).html()));
}

function dataMes(CONTENEDOR) {
    var contenido = "";
    var elemento;
    let meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    var fecha = new Date();
    var fechaMes = fecha.getMonth() + 1;
    var fechaAnno = fecha.getFullYear();

    for (var i = 1; i <= 12; i++) {
        contenido += `<option value='${i}' ${(fechaMes == i) ? 'selected' : ''} >${meses[i - 1]}</option>`;
    }
    $("#" + CONTENEDOR).html(contenido);
}

function dataAnno(CONTENEDOR, DESDE = 2022) {
    var contenido = "";
    var elemento;
    var fecha = new Date();
    var anno = fecha.getFullYear();
    var fechaAnno = fecha.getFullYear();

    contenido += `<option value='' >--Seleccione--</option>`;
    for (var i = fechaAnno; i >= DESDE; i--) {
        contenido += `<option value='${i}' ${(anno == i) ? 'selected' : ''} >${i}</option>`;
    }
    $("#" + CONTENEDOR).html(contenido);
}


function FormatNumber(n, currency = '') {
    return currency + parseFloat(n).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,');
}

function showPopup(ruta, idmodal, className = "", titulo = "Popup") {

    var namePopup = 'popup_' + idmodal;
    var contenido = "";
    contenido += `<div class="modal fade modal-class" id="${namePopup}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                       <div class="modal-dialog modal-dialog-centered ${className} " role="document">
                           <div class="modal-content">
                               <div class="modal-header bg-muni">
                                   <h6 class="modal-title m-0 text-white" id="exampleModalPrimary1">${titulo}</h6>
                                   <button type="button" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
                               </div>
                               <div class="modal-body ${namePopup}">
                               </div>
                               <div class="modal-footer">                                                    
                                   <button type="button" class="btn btn-soft-secondary " data-bs-dismiss="modal">Cerrar ventana</button>
                               </div>
                           </div>
                       </div>
                   </div>`;
    removeElementsByClass('modal-class');

    $("body").append(contenido);

    $('.' + namePopup).load(urljs + ruta, function (res) { });

    OpenModal("#" + namePopup);
}

function removeElement(id) {
    var elem = document.getElementById(id);
    return elem.parentElement.removeChild(elem);
}
function removeElementsByClass(className) {
    const elements = document.getElementsByClassName(className);
    while (elements.length > 0) {
        elements[0].parentNode.removeChild(elements[0]);
    }
}


function validaTeclas(e, tip) {

    var tecla = document.all ? tecla = e.keyCode : tecla = e.which;

    var soloLetras = "abcdefghijklmnÃ±opqrstuvwxyzABCDEFGHIJKLMNÃ‘OPQRSTUVWXYZ ";
    var soloAlphan = "abcdefghijklmnÃ±opqrstuvwxyzABCDEFGHIJKLMNÃ‘OPQRSTUVWXYZ 0123456789";
    var soloNumero = "0123456789";
    var soloDecima = "0123456789.";
    var sinCeros = "123456789";
    var soloNumerocoma = "0123456789,-";

    switch (tip) {
        case 'text':
            return (soloLetras.indexOf(String.fromCharCode(tecla)) > -1);
            break;
        case 'alpha':
            return (soloAlphan.indexOf(String.fromCharCode(tecla)) > -1);
            break;
        case 'number':
            return (soloNumero.indexOf(String.fromCharCode(tecla)) > -1);
            break;
        case 'numeric':
            return (soloDecima.indexOf(String.fromCharCode(tecla)) > -1);
            break;
        case 'sinceros':
            return (sinCeros.indexOf(String.fromCharCode(tecla)) > -1);
            break;
        case 'numcoma':
            return (soloNumerocoma.indexOf(String.fromCharCode(tecla)) > -1);
            break;
    }
}

function rellenarceros(n, length) {
    n = n.toString();
    while (n.length < length) n = "0" + n;
    return n;
}
function limitDecimalPlaces(e, count) {
    if (e.target.value.indexOf('.') == -1) { return; }
    if ((e.target.value.length - e.target.value.indexOf('.')) > count) {
        e.target.value = parseFloat(e.target.value).toFixed(count);
    }
}

function floorPrecised(number, precision) {
    var power = Math.pow(10, precision);

    return Math.floor(number * power) / power;
}


function selectChecks(source, name = 'check-select') {
    var checkboxes = document.querySelectorAll('input[name=' + name + ']');
    for (var i = 0; i < checkboxes.length; i++) {
        if (checkboxes[i] != source)
            checkboxes[i].checked = source.checked;
    }
}

function longitudText(inputID, IDmessage, max = 0, btnValida = '') {
    const mensaje = document.querySelector('#' + inputID);
    const longitud = document.querySelector('#' + IDmessage);
    longitud.innerHTML = `Longitud: ${mensaje.value.length} / mÃ­nimo ${max}`;

    const contarLongitud = () => {
        longitud.innerHTML = `Longitud: ${mensaje.value.length} / mÃ­nimo ${max}`;
    }
    if (max == 0) {
        max = parseInt($("#" + inputID).attr("maxlength"));
    }
    if (mensaje.value.length < max) {
        $("#" + inputID).addClass('is-invalid');
        $("#" + IDmessage).addClass('invalid-feedback');
        if (btnValida != '') {
            $("#" + btnValida).addClass('disabled');
        }
    } else {
        $("#" + inputID).removeClass('is-invalid');
        $("#" + inputID).addClass('is-valid');

        $("#" + IDmessage).removeClass('invalid-feedback');
        $("#" + IDmessage).addClass('valid-feedback');
        if (btnValida != '') {
            $("#" + btnValida).removeClass('disabled');
        }
    }

}
function getCSRFToken() {
    return document.querySelector('meta[name="csrf-token"]').getAttribute('content');
}
function api_persona_pide_sunat(TIPO, DOCUMENTO, callback) {

    let urljs = window.location.protocol + "//" + window.location.host;
    var urlAbsoluta = urljs + '/api-persona?TIPO=' + TIPO + '&DOCUMENTO=' + DOCUMENTO;

    $("body").addClass("loader");

    $.ajax({
        url: urlAbsoluta,
        type: 'GET',
        headers: {
            'X-CSRF-TOKEN': getCSRFToken(),
        },
        success: function (res) {
            callback(res);
            $("body").removeClass("loader");
        },
        error: function (err) {
            console.log(err);
            $("body").removeClass("loader");
        }
    });
}


function envioAjaxdata(url, data, callback) {
    // let urljs = window.location.protocol + "//" + window.location.host+'/';
    //console.log(urljs);
    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $("body").addClass("loader");
    $.ajax({
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': csrfToken
        },
        url: urljs + url,
        data: data,
        dataType: 'json',
        encode: true,
        cache: false,
        processData: false,
        contentType: false,
        beforeSend: function () {
        },
        success: function (data) {
            callback(data)
            $("body").removeClass("loader");
        },
        error: function () {
            $("body").removeClass("loader");
        }
    });
}
function envioAjaxdataText(url, data, callback) {

    $("body").addClass("loader");
    $.ajax({
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: urljs + url,
        data: data,
        dataType: 'html',
        processData: false,
        contentType: false,
        beforeSend: function () {
        },
        success: function (data) {
            callback(data)
            $("body").removeClass("loader");
        },
        error: function () {
            $("body").removeClass("loader");
        }
    });
}


function showMessageAlert(title = '', text = '', icon, rollback) {
    Swal.fire({
        title: title,
        text: text,
        icon: icon,
        confirmButtonText: "Aceptar",
    }).then((result) => {
        rollback(result);
    })
}

function showMessageAlertHtml(title, icon, html) {
    Swal.fire({
        title: title,
        icon: icon,
        html: html,
        showConfirmButton: false,
        showCancelButton: false
    });

    //EL SUSO
    /* var buttons = $('<div>')
       .append(
           createButton('Ok', function() {
               console.log('ok'); 
           })
       ).get(0);
       ID.HTML(buttons);
   */
}
function closeSwal() {
    swal.close();
}

function createButton(text, clase, cb) {
    return $(`<button class="btn ${clase} m-1">${text}</button>`).on('click', cb);
}

function validaCoreo(idInput) {
    document.getElementById(idInput).addEventListener('input', function () {
        campo = event.target;

        emailRegex = /^[-\w.%+]{1,64}@(?:[A-Z0-9-]{1,63}\.){1,125}[A-Z]{2,63}$/i;
        //Se muestra un texto a modo de ejemplo, luego va a ser un icono
        if (emailRegex.test(campo.value)) {
            $(this).removeClass("is-invalid");
            $(this).addClass("is-valid");
        } else {

            $(this).removeClass("is-valid");
            $(this).addClass("is-invalid");
        }
    });
}

function getRandomInt(max) {
    return Math.floor(Math.random() * max);
}
function number_format(number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}