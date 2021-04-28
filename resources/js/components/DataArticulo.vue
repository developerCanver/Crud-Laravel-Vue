<template>
    <div class="container">
        <br>
        <div class="row justify-content-center">
            <h2>Gestionar Articulos con Data Tables</h2>
            <hr>
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-success btn-sm" @click="ModalCrear" data-toggle="modal"
                data-target="#exampleModal">
                Crear Articulo
            </button>
            <!-- Modal -->


            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header" v-bind:style="{ background: color }">
                            <h5 class="modal-title text-center" id="exampleModalLabel">{{titulo}}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="form-group ">
                                    <label for="exampleInputEmail1">Nombre Articulo</label>
                                    <input type="text" class="form-control" placeholder="Nombre Articulo" required v-model="articulo.nombre">

                                    <span class="text-danger" v-if="errores.nombre">{{errores.nombre[0]}}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Descripción</label>
                                    <input type="text" class="form-control" placeholder="Descripción Articulo" required v-model="articulo.descripcion">
                                    <span class="text-danger"
                                        v-if="errores.descripcion">{{errores.descripcion[0]}}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Stock</label>
                                    <input type="number" class="form-control" placeholder="0" required v-model="articulo.stock">
                                    <span class="text-danger" v-if="errores.stock">{{errores.stock[0]}}</span>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>

                                    <button type="button" @click.prevent="crear()" v-if="btnCrear"
                                        class="btn btn-success ">Crear</button>
                                    <button type="button" @click.prevent="editar(idArticulo)" v-if="btnEditar"
                                        class="btn btn-primary">Editar</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>


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
                        <td class="form-inline">
                            <div class="form-group m-2">
                                <button class="btn btn-success btn-sm" type="button"> <i
                                        class="fas fa-info-circle"></i></button>
                                <button class="btn btn-primary btn-sm" type="button" @click="ModalEditar(articulo)"> <i
                                        class="fas fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm" type="button"> <i
                                        class="fas fa-trash-alt"></i></button>
                            </div>
                        </td>
                    </tr>
                </tbody>

            </table>


        </div>
    </div>

</template>

<script>
    import datatable from 'datatables.net-bs4';
    require('datatables.net-buttons/js/dataTables.buttons')
    require('datatables.net-buttons/js/buttons.html5')
    import print from 'datatables.net-buttons/js/buttons.print';
    import jszip from 'jszip/dist/jszip';
    import pdfmake from 'pdfmake/build/pdfmake';
    import pdffonts from 'pdfmake/build/vfs_fonts';
    import Swal from 'sweetalert2';

    pdfMake.vfs = pdffonts.pdfMake.vfs;
    window.JSZip = jszip;

    export default {
        mounted() {
            this.getArticulos()
        },
        data() {
            return {
                //asihnar variables vacias en las cuales se van a oparar para CRUD
                articulos: [],
                articulo: {
                    nombre: '',
                    descripcion: '',
                    stock: '',
                },
                titulo: '',
                color: '',
                btnCrear: false,
                btnEditar: false,
                idArticulo: '',
                errores: [],
            }
        },

        methods: {
            // listar la tabla con datos quemados
            tabla() {
                this.$nextTick(() => {

                    $('#example').DataTable({
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
            },
            //C0ONSULTA  
            getArticulos() {
                axios.get('dataArticulos').then(res => {
                    this.articulos = res.data;
                    //PARA QUE CARGUE LAS LIBRERIAS
                    //destruir la tabla para volver agenerarla
                    $('#example').DataTable().destroy()

                    this.tabla();

                })
            },

            async crear() {
                try {

                    const res = await axios.post('/dataArticulos/', this.articulo);

                    this.getArticulos();
                    $('#exampleModal').modal('hide');
                    this.articulo = {
                        nombre: '',
                        descripcion: '',
                        stock: '',
                    }
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Felicidades! Guardado con Éxito',
                        showConfirmButton: false,
                        timer: 900
                    })

                } catch (error) {
                    //errores de validate controller
                    if (error.response.data) {
                        this.errores = error.response.data.errors;
                    }

                }

            },
            editar() {
                axios.put('dataArticulos/' + this.idArticulo, this.articulo).then(res => {
                    //se envio los atributos de articulo al controlador
                    this.getArticulos();
                    //volver a listar
                    //cerrar modal
                    $('#exampleModal').modal('hide');
                    //mostrar mesaje guardado

                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Felicidades! Editado con Éxito',
                        showConfirmButton: false,
                        timer: 1000
                    })

                }).catch(function (error) {
                    //para imprimir en una aleerta 
              
                    if (error.response.data) {
                        console.log(error.response.data.errors)
                        this.errores = error.response.data.errors;
                    }

                });
            },
            //abrir modal para crear articulo
            ModalCrear() {
                this.titulo = 'Crear  Articulo',
                    this.color = 'rgb(128 221 167)';
                this.articulo = {
                    nombre: '',
                    descripcion: '',
                    stock: '',
                }
                this.btnCrear = true;
                this.btnEditar = false;

            },
            //abrir modal para editar articulo
            ModalEditar(datos) {
                this.titulo = 'Editar  Articulo',
                    this.color = 'rgb(91 174 214)';
                this.articulo = {
                    nombre: datos.nombre,
                    descripcion: datos.descripcion,
                    stock: datos.stock,
                }
                this.btnCrear = false;
                this.btnEditar = true;
                this.idArticulo = datos.id;
                $('#exampleModal').modal('show');

            },

        }
    }

</script>
