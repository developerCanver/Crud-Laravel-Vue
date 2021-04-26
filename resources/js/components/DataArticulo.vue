<template>
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="mt-3">Gestionar Articulos con Data Tables</h2>
            <hr>
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-info btn-lg my-4">Nuevo
                Articulo</button>

            <!-- Modal -->

            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                    <tr>
                        <th>IDS</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th>Stock</th>
                        <th>Fecha creado</th>
                        <th>Opciones</th>
           

                    </tr>
                </thead>
                <tbody>
                    <tr v-for="articulo in articulos" :key="articulo.id">
                        <td>{{articulo.id}}</td>
                        <td>{{articulo.nombre}}</td>
                        <td>{{articulo.descripcion}}</td>
                        <td>{{articulo.stock}}</td>
                        <td>{{articulo.created_at}}</td>
                        <td>
                            <button class="btn btn-success btn-sm" type="button"> Detalle</button>
                            <button class="btn btn-primary btn-sm" type="button"> Editar</button>
                            <button class="btn btn-danger btn-sm" type="button"> Eliminar</button>
                        </td>
                    </tr>
                </tbody>

            </table>


        </div>
    </div>

</template>

<script>
    import datatable from 'datatables.net-bs4';
require( 'datatables.net-buttons/js/dataTables.buttons')
require( 'datatables.net-buttons/js/buttons.html5')


import print from 'datatables.net-buttons/js/buttons.print';
import jszip from 'jszip/dist/jszip';
 import pdfmake from 'pdfmake/build/pdfmake';
 import pdffonts from 'pdfmake/build/vfs_fonts';

 pdfMake.vfs = pdffonts.pdfMake.vfs;
 window.JSZip = jszip;

    export default {
        mounted() {
            this.getArticulos()
        },
        data() {
            return {
                articulos: [],
            }
        },

        methods: {
            // listar la tabla con datos quemados
            tabla() {
                this.$nextTick(() => {
                    $('#example').DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'excel', 'pdf'
                    ]
                });
                });
            },
            //c0ONSULTA  
            getArticulos() {
                axios.get('dataArticulos').then(res => {
                    this.articulos = res.data;
                    //PARA QUE CARGUE LAS LIBRERIAS
                    this.tabla();
                    //console.log(this.articulos);

                    // listar sin editar Y eliminar 
                    // $('#example').DataTable({
                    //     data: res.data,
                    //      //variable que resivimos
                    //     columns: [{
                    //             data: 'id'
                    //         },
                    //         {
                    //             data: 'nombre'
                    //         },
                    //         {
                    //             data: 'descripcion'
                    //         },
                    //         {
                    //             data: 'stock'
                    //         },
                    //         {
                    //             data: 'created_at'
                    //         }
                    //     ]
                    // });


                })
            },

        }
    }

</script>

<style scoped>
    .mostrarModal {
        display: list-item;
        opacity: 1;
        background: rgba(41, 57, 82, 0.542);
    }

</style>
