require('./bootstrap');

require('alpinejs');

import Vue from 'vue';
/** moment para cambiar formato de fecha */
import moment from 'moment';
/** $fecha es la variable que s utiliza n los componentes vue llama a esta funcion */
Vue.prototype.$fecha = function(Cambiar_fecha){
    return moment(Cambiar_fecha).locale('es').format('LL');

}
/** datatable de forma global para todos loco componentes de blue */
import datatable from 'datatables.net-bs4';
require('datatables.net-buttons/js/dataTables.buttons')
require('datatables.net-buttons/js/buttons.html5')
import print from 'datatables.net-buttons/js/buttons.print';
import jszip from 'jszip/dist/jszip';
import pdfmake from 'pdfmake/build/pdfmake';
import pdffonts from 'pdfmake/build/vfs_fonts';



Vue.prototype.$tablaglobal = function(nombre_tabla){
    this.$nextTick(() => {
        $(nombre_tabla).DataTable({
            "order": [
                [0, 'desc']
            ],
            dom: "<'row'<'col-sm-12 m-5 text-center'B>><'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p><br>>",
            //botones para exportar
            buttons: [{
                    "extend": "copyHtml5",
                    "text": "<i class='fas fa-copy'></i> Copiar",
                    "titleAttr": "Copiar",
                    "className": "btn btn-secondary",
                },
                {
                    "extend": "excelHtml5",
                    "text": "<i class='fas fa-file-excel'></i> Excel",
                    "titleAttr": "Exportar a Excel",
                    "className": "btn btn-success",
                },
                {
                    "extend": "pdfHtml5",
                    "text": "<i class='fas fa-file-pdf'></i> PDF",
                    "titleAttr": "Exportar a PDF",
                    "className": "btn btn-danger",
                },
                {
                    "extend": "csvHtml5",
                    "text": "<i class='fas fa-file-csv'></i> Csv",
                    "titleAttr": "Exportar a Csv",
                    "className": "btn btn-info",
                },
                {
                    "extend": "print",
                    "text": "<i class='fas fa-print'></i> Imprimir",
                    "titleAttr": "Imprimir Archivo",
                    "className": "btn btn-secondary",
                },
            ]
        });
    });

}

pdfMake.vfs = pdffonts.pdfMake.vfs;
window.JSZip = jszip;

Vue.component('articulo', require('./components/Articulo.vue').default);
Vue.component('dataartivulo', require('./components/DataArticulo.vue').default);

const app = new Vue({
    el: '#app',
});
