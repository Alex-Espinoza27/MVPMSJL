// $(function () {
//     $('[data-toggle="tooltip"]').tooltip({
//         container: 'body',
//         html: true
//     });
// });

$(document).ready(function () {
    observados()
});


function observados() {
    var url = 'observado/lista';
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

    $('#datatable').DataTable({
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
                data: 'SOLI_OBSERVACION'
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
    });
}
 



// function mostrarData(data) {
//     $(document).ready(function () {
//         const table = $('#datatable').DataTable({
//             data: data,
//             columns: [
//                 { data: 'SOLI_NU_EMI' },
//                 { data: 'SOLI_FECHA' },
//                 { data: 'SOLI_NRO_EXPEDIENTE' },
//                 {
//                     data: 'SOLI_ASUNTO',
//                     render: (data) => data.length > 50 ? `${data.substring(0, 50)}...` : data
//                 },
//                 {
//                     data: 'SOLI_OBSERVACION'
//                     // render: (data) => data.length > 30 ? `${data.substring(0, 30)}...` : data
//                 },
//                 { data: 'CANTIDAD_ANEXO' },
//                 {
//                     data: null,
//                     render: (data) => `<span class="badge ${data.ESTA_COLOR}">${data.ESTA_DESCRIPCION}</span>`
//                 },
//                 {
//                     data: null,
//                     render: () => `
//                     <div class="d-flex gap-2">
//                         <button class="btn btn-sm btn-primary ver-datos">
//                             <i class="fas fa-eye"></i>
//                         </button>
//                         <button class="btn btn-sm btn-info ver-seguimiento">
//                             <i class="fas fa-route"></i>
//                         </button>
//                     </div>
//                 `
//                 }
//             ],
//             responsive: true
//             // language: {
//             //     url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
//             // },
//             // dom: '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>' +
//             //     '<"row"<"col-sm-12"tr>>' +
//             //     '<"row"<"col-sm-12 col-md-5"i><"col-sm-12 col-md-7"p>>',
//             // buttons: [
//             //     'copy', 'excel', 'pdf'
//             // ]
//         });

//         $('#datatable').on('click', '.ver-datos', function () {
//             const data = table.row($(this).closest('tr')).data();

//         });

//         $('#datatable').on('click', '.ver-seguimiento', function () {
//             const data = table.row($(this).closest('tr')).data();

//         });
//     });
// }


// const tableConfig = {
//     // Inicialización personalizada
//     initComplete: function() {
//         // Agregar filtros personalizados
//         this.api().columns().every(function() {
//             let column = this;
//             if (column.index() < 6) {
//                 let select = $('<select class="form-select form-select-sm"><option value="">Todos</option></select>')
//                     .appendTo($(column.footer()).empty())
//                     .on('change', function() {
//                         let val = $.fn.dataTable.util.escapeRegex($(this).val());
//                         column.search(val ? '^'+val+'$' : '', true, false).draw();
//                     });

//                 column.data().unique().sort().each(function(d) {
//                     select.append(`<option value="${d}">${d}</option>`);
//                 });
//             }
//         });
//     },

//     createdRow: function(row, data) {
//         $(row).addClass(data.ESTA_COLOR);
//     }
// };


// $.fn.dataTable.ext.errMode = 'none';
// $('#datatable').on('error.dt', function(e, settings, techNote, message) {
//     console.error('Error en la tabla:', message);
//     Swal.fire({
//         icon: 'error',
//         title: 'Error al cargar los datos',
//         text: 'Por favor, intente nuevamente más tarde'
//     });
// });

