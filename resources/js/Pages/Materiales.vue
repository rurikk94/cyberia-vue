<template>
    <breeze-authenticated-layout>
        <div class="container">
            <div class="row">
                <div class="col">

                    <div class="py-2">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb">
                                            <li class="breadcrumb-item"><inertia-link :href="route('dashboard')">Inicio</inertia-link></li>
                                            <li class="breadcrumb-item active" aria-current="page">Materiales</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-2">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <div class="row">
                                        <div class="col-3">
                                            <h1>Materiales ({{ current_materiales.length }})</h1>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" v-model="search" placeholder="Busca un material">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="py-2" v-if="!editando">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <form @submit.prevent="add">
                                    <div class="row g-2">
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="nombre" id="nombre" v-model="form.nombre" required placeholder="nombre">
                                                <label for="nombre">Nombre</label>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="marca" id="marca" v-model="form.marca" required placeholder="marca">
                                                <label for="marca">Marca</label>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="modelo" id="modelo" v-model="form.modelo" required placeholder="modelo">
                                                <label for="modelo">Modelo</label>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row g-2">
                                            <div class="col-md">
                                                <button type="submit" class="btn btn-success btn-lg btn-block">Agregar</button>
                                            </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-2" v-if="editando">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <form @submit.prevent="edit">
                                        <input type="hidden" name="id" v-model="formEdit.id">
                                    <div class="row g-2">
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="nombre" id="nombre" v-model="formEdit.nombre" required placeholder="nombre">
                                                <label for="nombre">Nombre</label>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="marca" id="marca" v-model="formEdit.marca" required placeholder="marca">
                                                <label for="marca">Ubicacion</label>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="modelo" id="modelo" v-model="formEdit.modelo" required placeholder="modelo">
                                                <label for="modelo">Modelo</label>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                            </div>
                                    </div>
                                    <div class="row g-2">
                                            <div class="col-md">                                                
                                                <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" style="position: absolute;top: -500px;"/>
                                                <div class="card text-center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Subir foto">
                                                    <div class="card-body" v-on:click="$refs.file.click()" role="button">
                                                        <i class="fas fa-upload fa-2x" role="button"></i>
                                                        <p class="mb-0" role="button"> {{ this.file !== '' ? this.file.name : 'Subir foto' }}</p>
                                                    </div>
                                                    <div v-if="this.file !== ''" class="card-footer border-top-0 bg-white">
                                                        <button class="btn btn-sm btn-secondary" v-on:click="submitFile(formEdit)">Subir</button>
                                                    </div>
                                                </div>
                                            </div>
                                    </div>
                                    <div class="row g-2">
                                            <div class="col-md">
                                                <button type="submit" class="btn btn-success btn-lg btn-block" v-on:click="guardarEdit(formEdit.id)">Guardar</button>
                                                <button type="button" class="btn btn-danger btn-lg btn-block" v-on:click="this.editando = false">Cancelar</button>
                                            </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-2">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <div class="row" v-for="material in filteredItems" v-bind:key="material.id">
                                        <div class="col-2 py-1 m-auto">
                                            <img class="img-fluid" :src="route('dashboard.i') + '/storage/' + material.imagen.replace('public/', '') " alt="" srcset="">
                                        </div>
                                        <div class="col py-1 m-auto">{{material.nombre}}
                                        </div>
                                        <div class="col py-1 m-auto">{{material.marca}}
                                        </div>
                                        <div class="col py-1 m-auto">{{material.modelo}}
                                        </div>
                                        <div class="col py-1 m-auto">
                                            <button type="button" class="btn btn-primary btn-lg" v-on:click="showEdit(material)">Editar</button>
                                            <button type="button" class="btn btn-danger btn-lg" v-on:click="deleteItem(material.id)">Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </breeze-authenticated-layout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated'
    import axios from 'axios'
    import Button from '@/Components/Button.vue'
    import { Tooltip, Toast, Popover } from 'bootstrap';

    export default {
        components: {
            BreezeAuthenticatedLayout,
            Toast,
            Button},

        props: {
            auth: Object,
            errors: Object,
            materiales: Object
        },

        data() {
            return {
                file: '',
                current_materiales:  [],
                form: this.$inertia.form({
                    nombre: '',
                    marca: '',
                    modelo: '',
                }),
                formEdit: this.$inertia.form({
                    id: '',
                    nombre: '',
                    marca: '',
                    modelo: '',
                }),
                editando: false,
                search:''
            }
        },

        mounted() {
            this.current_materiales = this.materiales
        },

        computed: {
            filteredItems() {
            return this.current_materiales.filter(item => {
                return item.nombre.toLowerCase().indexOf(this.search.toLowerCase()) > -1
            })
            }
        },

        methods: {
            add() {
                axios.post(this.route('materiales.add'),this.form)
                .then(res => {
                    var material = res.data.material;
                    this.current_materiales = this.current_materiales.concat(material);
                    this.form.reset('nombre', 'marca', 'modelo');
                    this.$moshaToast('Agregado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})

                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
            },
            deleteItem(idItem) {

                this.$swal({
                title: '¿Estás seguro?',
                text: "No puedes revertir esta eliminación",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, eliminarlo!'
                })
                .then((result) => {
                    if (result.isConfirmed) {

                        axios.delete(this.route('materiales.delete',idItem),{params: {
                            'id': idItem
                        }})
                        .then(res => {
                            var material = parseInt(res.data.material);
                            this.current_materiales = this.current_materiales.filter((obj) => {
                                return obj.id !== material;
                            })
                            this.$moshaToast('Eliminado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                        })
                        .catch((e) => {
                            this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                        })

                    }
                })

            },
            showEdit(material){
                this.formEdit.id = material.id
                this.formEdit.nombre = material.nombre
                this.formEdit.marca = material.marca
                this.formEdit.modelo = material.modelo
                this.editando = true
            },
            guardarEdit(idItem){
                axios.put(this.route('materiales.update',idItem),this.formEdit)
                .then(() => {

                    this.current_materiales.find(n => n.id === idItem).nombre = this.formEdit.nombre
                    this.current_materiales.find(n => n.id === idItem).marca = this.formEdit.marca
                    this.current_materiales.find(n => n.id === idItem).modelo = this.formEdit.modelo

                    this.$moshaToast('Editado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                    this.form.reset('nombre', 'marca', 'modelo');
                    this.editando = false
                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
            },   
            handleFileUpload(){
                this.file = this.$refs.file.files[0];
            },         
            submitFile(material){
                let formData = new FormData();
                formData.append("material_id", material.id);
                formData.append('file', this.file);
                axios.post(this.route('materiales.imagen.add', material.id),formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(res => {
                    var material = res.data.material;
                    //this.c_trabajo.documentos = this.c_trabajo.documentos.concat(documento);
                    this.file = '';
                    this.$moshaToast('Agregado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})

                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })

            },
        }
    }
</script>
