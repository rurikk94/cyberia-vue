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
                                            <li class="breadcrumb-item active" aria-current="page">Trabajos</li>
                                        </ol>
                                    </nav>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-2" v-if="!agregando">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <div class="row">
                                        <div class="col-3">
                                            <h1>Mis trabajos</h1>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" v-model="search" placeholder="Busca un trabajo">
                                        </div>
                                        <div class="col-3">
                                            <button class="btn btn-success btn-lg btn-block" v-on:click="this.agregando = true">Agregar</button>
                                        </div>
                                    </div>
                                    <div class="row" v-for="dato in filteredItems" v-bind:key="dato.id">
                                        <div class="col py-1 m-auto">
                                            {{dato.nombre_trabajo}}
                                        </div>
                                        <div class="col py-1 m-auto">
                                            {{dato.ubicacion}}
                                        </div>
                                        <div class="col py-1 m-auto">
                                            <inertia-link role="button" class="text-reset" :href="route('clientes.show',dato.cliente.id)" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver Cliente">
                                                {{dato.cliente.nombres +' '+ dato.cliente.apellidos}}
                                            </inertia-link>
                                        </div>
                                        <div class="col py-1 m-auto">
                                            <div class="btn-group" role="group" aria-label="opciones">
                                            <inertia-link class="btn btn-success" :href="route('trabajos.show',dato.id)" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver Trabajo">
                                                Ver
                                            </inertia-link>
                                            <button type="button" class="btn btn-danger" v-on:click="deleteItem(dato.id)">Eliminar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-2" v-if="agregando && !agregandoCliente">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <form @submit.prevent="addTrabajo">
                                    <div class="row g-2">
                                        <div class="col-md">
                                            <div class="form-floating">
                                            <input type="text" class="form-control" name="nombre_trabajo" id="nombre_trabajo" v-model="form.nombre_trabajo" required placeholder="Titulo del trabajo">
                                            <label for="nombre_trabajo">Titulo del trabajo</label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-floating">
                                            <input type="text" class="form-control" name="ubicacion" id="ubicacion" v-model="form.ubicacion" required placeholder="Calle Número, Ciudad">
                                            <label for="ubicacion">Ubicación</label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-floating">
                                            <input type="text" class="form-control" name="descripcion" id="descripcion" v-model="form.descripcion" required placeholder="Descripcion">
                                            <label for="descripcion">Descripción del trabajo</label>
                                            </div>
                                        </div>
                                        <div class="col-md">
                                            <div class="form-floating">
                                                <select class="form-select" id="cliente" aria-label="Elija un Cliente Existente" v-model="form.cliente_id" required>
                                                    <option v-for="cliente in c_clientes" v-bind:key="cliente.id" :value="cliente.id">{{cliente.nombres}} {{cliente.apellidos}}</option>
                                                </select>
                                                <label for="cliente">Cliente</label>
                                            </div>
                                            <button type="button" class="btn btn-success btn-sm" v-on:click="this.agregandoCliente = true">Agregar Nuevo Cliente</button>
                                        </div>
                                        <div class="col-md">
                                            <div class="btn-group-vertical" role="group" aria-label="opciones">
                                                <button type="submit" class="btn btn-success btn-block">Agregar</button>
                                                <button type="button" class="btn btn-danger btn-block" v-on:click="this.agregando = false, this.form.reset('nombre_trabajo', 'ubicacion','descripcion', 'cliente_id')">Cancelar</button>
                                            </div>
                                        </div>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-2" v-if="agregando && agregandoCliente">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <form @submit.prevent="addCliente">
                                    <div class="row g-2">
                                            <div class="col-12">
                                                <label for="nombres">Nuevo Cliente</label>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="nombres" id="nombres" v-model="formCliente.nombres" required placeholder="nombres">
                                                <label for="nombres">Nombres</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="apellidos" id="apellidos" v-model="formCliente.apellidos" required placeholder="apellidos">
                                                <label for="apellidos">Apellidos</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-floating">
                                                <input type="tel" class="form-control" name="telefono" id="telefono" v-model="formCliente.telefono" placeholder="+56912345678">
                                                <label for="telefono">Teléfono</label>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="email" id="email" v-model="formCliente.email" placeholder="email">
                                                <label for="email">Email</label>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="btn-group" role="group" aria-label="opciones">
                                                    <button type="submit" class="btn btn-success">Agregar</button>
                                                    <button type="submit" class="btn btn-danger" v-on:click="this.agregandoCliente = false, formCliente.reset('nombres', 'apellidos')">Cancelar</button>
                                                </div>
                                            </div>
                                    </div>
                                    </form>
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
            trabajos: Object,
            clientes: Object
        },

        data() {
            return {
                c_trabajos: [],
                c_clientes: [],
                search:'',
                agregando: false,
                agregandoCliente: false,
                form: this.$inertia.form({
                    nombre_trabajo: '',
                    ubicacion: '',
                    descripcion: '',
                    cliente_id: '',
                }),
                formCliente: this.$inertia.form({
                    nombres: '',
                    apellidos: '',
                    telefono: '',
                    email: '',
                }),
            }
        },

        mounted() {
            this.c_trabajos = this.trabajos
            this.c_clientes = this.clientes
        },

        computed: {
            filteredItems() {
            return this.c_trabajos.filter(item => {
                let trabajo = item.cliente.nombres + ' ' + item.cliente.apellidos + ' ' + item.ubicacion + ' ' + item.nombre_trabajo + ' ' + item.descripcion + ' ' + item.codigo_trabajo
                return trabajo.toLowerCase().indexOf(this.search.toLowerCase()) > -1
            })
            }
        },

        methods: {
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

                        axios.delete(this.route('trabajo.delete',idItem),{params: {
                            'id': idItem
                        }})
                        .then(res => {
                            var cliente = parseInt(res.data.trabajo);
                            this.c_trabajos = this.c_trabajos.filter((obj) => {
                                return obj.id !== idItem;
                            })
                            this.$moshaToast('Eliminado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                        })
                        .catch((e) => {
                            this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                        })

                    }
                })

            },
            addCliente() {
                axios.post(this.route('clientes.add'),this.formCliente)
                .then(res => {
                    var cliente = res.data.cliente;
                    this.c_clientes = this.c_clientes.concat(cliente);
                    this.form.cliente_id = cliente.id;
                    this.formCliente.reset('nombres', 'apellidos');
                    this.$moshaToast('Agregado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
                .finally(res => {
                    this.agregandoCliente = false
                })
            },
            addTrabajo() {
                axios.post(this.route('trabajo.add'),this.form)
                .then(res => {
                    var trabajo = res.data.trabajo;
                    this.c_trabajos = this.c_trabajos.concat(trabajo);
                    this.form.reset('nombre_trabajo', 'ubicacion', 'descripcion', 'cliente_id');
                    this.$moshaToast('Agregado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                    this.$inertia.visit(this.route('trabajos.show',trabajo.id))

                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
                .finally(res => {
                    this.agregando = false
                })
            },
        }
    }
</script>
