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
                                    <input type="text" class="form-control" placeholder="Nombre Articulo" required
                                        v-model="articulo.nombre">

                                    <span class="text-danger" v-if="errores.nombre">{{errores.nombre[0]}}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Descripción</label>
                                    <input type="text" class="form-control" placeholder="Descripción Articulo" required
                                        v-model="articulo.descripcion">
                                    <span class="text-danger"
                                        v-if="errores.descripcion">{{errores.descripcion[0]}}</span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword1">Stock</label>
                                    <input type="number" class="form-control" placeholder="0" required
                                        v-model="articulo.stock">
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
                        <td>{{$fecha(articulo.created_at)}}</td>
                        <td class="form-inline" style="padding: 5px;">
                            <div class="form-group ">                               
                                <button class="btn btn-primary btn-sm" type="button" @click="ModalEditar(articulo)"> <i
                                        class="fas fa-edit"></i></button>
                                <button class="btn btn-danger btn-sm" type="button" @click="eliminar(articulo.id)"> <i
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

import Swal from 'sweetalert2';

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
            //fecha se paso de forma global app.js y se utilisa $fecha()
            // fecha(Cambiar_fecha){
            //     return moment(Cambiar_fecha).locale('es').format('LL');

            // },
            // SE paso tabla global app.js
            // tabla() {
            
            // },
            //C0ONSULTA  
            getArticulos() {
                axios.get('dataArticulos').then(res => {
                    this.articulos = res.data;
                    //destruir la tabla para volver agenerarla
                    $('#example').DataTable().destroy()
                    //PARA QUE CARGUE LAS LIBRERIAS
                    this.$tablaglobal('#example');
                })
            },

            async crear() {
                try {
                    const res = await axios.post('/dataArticulos/', this.articulo);
                    this.getArticulos();
                    $('#exampleModal').modal('hide');
                    this.idArticulo = '';
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
            async editar() {
                try {
                    const res = await axios.put('dataArticulos/' + this.idArticulo, this.articulo);
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
                    });

                } catch (error) {
                    //para imprimir en una aleerta 
                    if (error.response.data) {
                        console.log(error.response.data.errors)
                        this.errores = error.response.data.errors;
                    }
                }
            },
            async eliminar(id) {
                try {
                    Swal.fire({
                        title: '¿Esta seguro de Eliminar?',
                        text: "Se eliminara permanentemente!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Si, Continuar!',
                        cancelButtonText: 'No, Cancelar!',
                    }).then((result) => {
                        if (result.isConfirmed) {

                            axios.delete('dataArticulos/' + id);
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Eliminado! con Éxito',
                                showConfirmButton: false,
                                timer: 800
                            });
                            this.getArticulos();
                        }
                    })

                } catch (error) {
                    //para imprimir en una aleerta 
                    if (error.response.data) {
                        console.log(error.response.data.errors)
                        this.errores = error.response.data.errors;
                    }
                }
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
