<template>
    <breeze-authenticated-layout>
        <div class="container">
            <div class="row">
                <div class="col">

                    <div class="py-2">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="px-6 py-3 bg-white border-b border-gray-200">
                                    <nav aria-label="breadcrumb">
                                        <ol class="breadcrumb my-auto">
                                            <li class="breadcrumb-item"><inertia-link :href="route('dashboard')">Inicio</inertia-link></li>
                                            <li class="breadcrumb-item active" aria-current="page">Negocios</li>
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
                                            <h1>Negocios ({{ current_negocios.length }})</h1>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" v-model="search" placeholder="Busca un negocio">
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
                                            <div class="col-12">
                                                <p>Agrega un <strong>Negocio</strong> a tu página, de esta forma podrás asignarle <strong>Materiales</strong> y después, podrás agregarla a un trabajo, y podrás cotizar.</p>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="nombre" id="nombre" v-model="form.nombre" required placeholder="nombre">
                                                <label for="nombre">Nombre</label>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="ubicacion" id="ubicacion" v-model="form.ubicacion" required placeholder="ubicacion">
                                                <label for="ubicacion">Ubicacion</label>
                                                </div>
                                            </div>
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
                                                <input type="text" class="form-control" name="nombre" id="nombre" v-model="formEdit.nombre" required placeholder="nombre" ref="nombre">
                                                <label for="nombre">Nombre</label>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="ubicacion" id="ubicacion" v-model="formEdit.ubicacion" required placeholder="ubicacion">
                                                <label for="ubicacion">Ubicacion</label>
                                                </div>
                                            </div>
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
                                    <div class="row" v-for="negocio in filteredItems" v-bind:key="negocio.id">
                                        <div class="col py-1 m-auto">{{negocio.nombre}}
                                        </div>
                                        <div class="col py-1 m-auto">{{negocio.ubicacion}}
                                        </div>
                                        <div class="col py-1 m-auto">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-primary btn-sm" v-on:click="showEdit(negocio), this.$ref.nombre.focus()">Editar</button>
                                                <button type="button" class="btn btn-danger btn-sm" v-on:click="deleteItem(negocio.id)">Eliminar</button>
                                                <inertia-link class="btn btn-success btn-sm" :href="route('negocios.material',negocio.id)" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver Materiales del Negocio">
                                                    Ver Materiales
                                                </inertia-link>
                                            </div>
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
            Toast,Tooltip, Popover,
            Button},

        props: {
            auth: Object,
            errors: Object,
            negocios: Object
        },

        data() {
            return {
                current_negocios:  [],
                form: this.$inertia.form({
                    nombre: '',
                    ubicacion: '',
                }),
                formEdit: this.$inertia.form({
                    id: '',
                    nombre: '',
                    ubicacion: '',
                }),
                editando: false,
                search:''
            }
        },

        mounted() {
            this.current_negocios = this.negocios

            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        },

        computed: {
            filteredItems() {
            return this.current_negocios.filter(item => {
                let negocio = item.nombre + ' ' + item.ubicacion
                return negocio.toLowerCase().indexOf(this.search.toLowerCase()) > -1
            })
            }
        },

        methods: {
            add() {
                axios.post(this.route('negocios.add'),this.form)
                .then(res => {
                    var negocio = res.data.negocio;
                    this.current_negocios = this.current_negocios.concat(negocio);
                    this.form.reset('nombre', 'ubicacion');
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

                        axios.delete(this.route('negocios.delete',idItem),{params: {
                            'id': idItem
                        }})
                        .then(res => {
                            var negocio = parseInt(res.data.negocio);
                            this.current_negocios = this.current_negocios.filter((obj) => {
                                return obj.id !== negocio;
                            })
                            this.$moshaToast('Eliminado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                        })
                        .catch((e) => {
                            this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                        })

                    }
                })

            },
            showEdit(negocio){
                this.formEdit.id = negocio.id
                this.formEdit.nombre = negocio.nombre
                this.formEdit.ubicacion = negocio.ubicacion
                this.editando = true
            },
            guardarEdit(idItem){
                axios.put(this.route('negocios.update',idItem),this.formEdit)
                .then(() => {

                    this.current_negocios.find(n => n.id === idItem).nombre = this.formEdit.nombre
                    this.current_negocios.find(n => n.id === idItem).ubicacion = this.formEdit.ubicacion

                    this.$moshaToast('Editado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                    this.form.reset('nombre', 'ubicacion');
                    this.editando = false
                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
            }
        }
    }
</script>