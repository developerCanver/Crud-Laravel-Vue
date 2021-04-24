<template>
    <div class="container">
        <div class="row justify-content-center">
            <h2>Gestionar Articulos</h2>
            <hr>
            <!-- Trigger the modal with a button -->
            <button type="button" @click="modificar=false; abrirModal()" class="btn btn-info btn-lg my-4">Nuevo
                Articulo</button>

            <!-- Modal -->
            <div class="modal " :class="{mostrarModal:llamarModal}">
                <div class="modal-dialog">
                    <div class="modal-content">

                        <!-- Modal content-->
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">{{tituloModal}}</h5>
                            <button type="button" @click="cerrarModal()">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="email">Nombre Articulo:</label>
                                        <input v-model="articulo.nombre" type="text" class="form-control" placeholder="Nombre Articulo">
                                        <span class="text-danger" v-if="errores.nombre">{{errores.nombre[0]}}</span>
                                    </div>
                                </div>
                          
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="email">Stock:</label>
                                        <input v-model="articulo.stock" type="number" class="form-control" placeholder="0">
                                         <span class="text-danger" v-if="errores.stock">{{errores.stock[0]}}</span>
                                    </div>
                                   
                                </div>
                            </div>
                              <div class="row">
                                <div class="col-12">
                                     <div class="form-group">
                                        <label for="email">Descripción:</label>
                                        <input v-model="articulo.descripcion" type="text" class="form-control" placeholder="Descripcion">
                                         <span class="text-danger" v-if="errores.descripcion">{{errores.descripcion[0]}}</span>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" @click="cerrarModal()" class="btn btn-default"
                                data-dismiss="modal">Cancelar</button>
                            <button type="button" class="btn btn-success" @click="guardar()" data-dismiss="modal">Guardar</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <!-- Button trigger modal -->

        <table class="table table-striped">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Descripcion</th>
                    <th scope="col">Stock</th>
                    <th colspan="2">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="art in articulos" :key="art.id">
                    <th scope="row">{{art.id}}</th>
                    <td>{{art.nombre}}</td>
                    <td>{{art.descripcion}}</td>
                    <td>{{art.stock}}</td>
                    <td><button @click="modificar=true; abrirModal(art)" type="button"
                            class="btn btn-outline-primary">Editar</button>
                    </td>
                    <td><button @click="eliminar(art.id)" type="button" class="btn btn-outline-danger">Eliminar</button>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                articulo:{
                  
                    nombre:'',
                    descripcion:'',
                    stock:'',

                },
                  id:0,
                modificar: true,
                llamarModal: 0,
                tituloModal: '',
                articulos: [],
                errores:{},
            }

        },
        methods: {
            //todos lo metodos CRUD
            async listar() {
                const res = await axios.get('/articulos');
                this.articulos = res.data;
            },
            async eliminar(id) {
                const res = await axios.delete('/articulos/' + id);
                this.listar();
                //console.log("Eliminado");
            },
             async guardar() {
                 //modificar y guarddar 
                 try {
                     if (this.modificar) {
                         const res = await axios.put('/articulos/'+this.id, this.articulo);
                     } else {
                          const res = await axios.post('/articulos', this.articulo);
                     }
                   this.cerrarModal();
                    this.listar();
                     
                 } catch (error) {
                     //errores de validate controller
                        if (error.response.data) {
                            this.errores=error.response.data.errors
                        }
                        
                     //console.log(error.response.data);
                     
                 }
                //console.log("Eliminado");
            },
            abrirModal(data={}) {
                this.llamarModal = 1;

                if (this.modificar) {

                    this.tituloModal = "Modificar Articulo";
                    this.articulo.nombre=data.nombre;
                    this.id=data.id;
                    this.articulo.descripcion=data.descripcion;
                    this.articulo.stock=data.stock;

                } else {
                    this.tituloModal = "Crear Articulo";

                    this.articulo.id=0;
                    this.articulo.nombre='';
                    this.articulo.descripcion='';
                    this.articulo.stock=1;
                }
            },
            cerrarModal() {
                this.llamarModal = 0;
            },
        },

        //ciclo de vida
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            this.listar();
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
