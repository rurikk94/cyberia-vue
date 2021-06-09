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
                                            <li class="breadcrumb-item active" aria-current="page">Clientes</li>
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
                                            <h1>Clientes ({{ current_clientes.length }})</h1>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" v-model="search" placeholder="Busca un cliente">
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
                                                <input type="text" class="form-control" name="nombres" id="nombres" v-model="form.nombres" required placeholder="nombres">
                                                <label for="nombres">nombres</label>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="apellidos" id="apellidos" v-model="form.apellidos" required placeholder="apellidos">
                                                <label for="apellidos">apellidos</label>
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
                                                <input type="text" class="form-control" name="nombres" id="nombres" v-model="formEdit.nombres" required placeholder="nombres">
                                                <label for="nombres">nombres</label>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="apellidos" id="apellidos" v-model="formEdit.apellidos" required placeholder="apellidos">
                                                <label for="apellidos">apellidos</label>
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
                                    <div class="row" v-for="cliente in filteredItems" v-bind:key="cliente.id">
                                        <div class="col py-1 m-auto">{{cliente.nombres}}
                                        </div>
                                        <div class="col py-1 m-auto">{{cliente.apellidos}}
                                        </div>
                                        <div class="col py-1 m-auto">
                                            <inertia-link class="btn btn-success btn-lg" :href="route('clientes.show',cliente.id)" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver Detalles del Cliente">
                                                Ver Detalles
                                            </inertia-link>
                                            <button type="button" class="btn btn-primary btn-lg" v-on:click="showEdit(cliente)">Editar</button>
                                            <button type="button" class="btn btn-danger btn-lg" v-on:click="deleteItem(cliente.id)">Eliminar</button>
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
            clientes: Object
        },

        data() {
            return {
                current_clientes: [],
                form: this.$inertia.form({
                    nombres: '',
                    apellidos: '',
                }),
                formEdit: this.$inertia.form({
                    id: '',
                    nombres: '',
                    apellidos: '',
                }),
                editando: false,
                search:''
            }
        },

        mounted() {
            this.current_clientes = this.clientes
        },

        computed: {
            filteredItems() {
            return this.current_clientes.filter(item => {
                return (item.nombres.toLowerCase().indexOf(this.search.toLowerCase()) > -1 || item.apellidos.toLowerCase().indexOf(this.search.toLowerCase()) > -1)
            })
            }
        },

        methods: {
            add() {
                axios.post(this.route('clientes.add'),this.form)
                .then(res => {
                    var cliente = res.data.cliente;
                    this.current_clientes = this.current_clientes.concat(cliente);
                    this.form.reset('nombres', 'apellidos');
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

                        axios.delete(this.route('clientes.delete',idItem),{params: {
                            'id': idItem
                        }})
                        .then(res => {
                            var cliente = parseInt(res.data.cliente);
                            this.current_clientes = this.current_clientes.filter((obj) => {
                                return obj.id !== cliente;
                            })
                            this.$moshaToast('Eliminado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                        })
                        .catch((e) => {
                            this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                        })

                    }
                })

            },
            showEdit(cliente){
                this.formEdit.id = cliente.id
                this.formEdit.nombres = cliente.nombres
                this.formEdit.apellidos = cliente.apellidos
                this.editando = true
            },
            guardarEdit(idItem){
                axios.put(this.route('clientes.update',idItem),this.formEdit)
                .then(() => {

                    this.current_clientes.find(n => n.id === idItem).nombres = this.formEdit.nombres
                    this.current_clientes.find(n => n.id === idItem).apellidos = this.formEdit.apellidos

                    this.$moshaToast('Editado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                    this.form.reset('nombres', 'apellidos');
                    this.editando = false
                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
            }
        }
    }
</script>
