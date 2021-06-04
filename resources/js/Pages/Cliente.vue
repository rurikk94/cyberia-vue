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
                                            <li class="breadcrumb-item"><inertia-link :href="route('clientes')">Clientes</inertia-link></li>
                                            <li class="breadcrumb-item active" aria-current="page">Detalle del Cliente</li>
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
                                    <h1>{{c_cliente.nombres}} {{c_cliente.apellidos}}</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-2" v-if="!editando">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <form @submit.prevent="add">
                                    <input type="hidden" name="id" v-model="formEdit.cliente_id">
                                    <div class="row g-2">
                                            <div class="col-md">
                                                <div class="form-floating">
                                                      <label for="material">Dato</label>
                                                      <select class="form-control" name="material" id="material" v-model="form.key" required>
                                                          <option v-for="dato in datos" v-bind:key="dato.key" :value="dato.key">{{dato.key}}</option>
                                                      </select>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="value" id="value" v-model="form.value" required :placeholder="form.key">
                                                <label for="value">{{ form.key }}</label>
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
                                        <input type="hidden" name="id" v-model="formEdit.cliente_id">
                                    <div class="row g-2">
                                            <div class="col-md">
                                                <div class="form-floating">
                                                      <label for="material">Dato</label>
                                                      {{formEdit.key}}
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="text" class="form-control" name="value" id="value" v-model="formEdit.value" required :placeholder="form.key">
                                                <label for="value">{{ formEdit.key }}</label>
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
                                    <div class="row">
                                        <h1>Teléfonos</h1>
                                    </div>
                                    <div class="row" v-for="dato in telefonos" v-bind:key="dato.id">
                                        <div class="col py-1 m-auto">
                                            {{dato.value}}
                                            <a :href="'tel:'+dato.value" target="_blank">Llamar</a>
                                            <a :href="'https://wa.me/'+dato.value" target="_blank">Whatsapp</a>
                                        </div>
                                        <div class="col py-1 m-auto">
                                            <button type="button" class="btn btn-primary btn-lg" v-on:click="showEdit(dato)">Editar</button>
                                            <button type="button" class="btn btn-danger btn-lg" v-on:click="deleteItem(dato.id)">Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-2">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <div class="row">
                                        <h1>Direcciones</h1>
                                    </div>
                                    <div class="row" v-for="dato in direcciones" v-bind:key="dato.id">
                                        <div class="col py-1 m-auto">
                                            {{dato.value}}
                                            <a :href="'https://www.google.com/maps/place/'+dato.value" target="_blank">Google Maps</a>
                                            <a :href="'https://waze.com/ul?q='+dato.value" target="_blank">Waze</a>
                                        </div>
                                        <div class="col py-1 m-auto">
                                            <button type="button" class="btn btn-primary btn-lg" v-on:click="showEdit(dato)">Editar</button>
                                            <button type="button" class="btn btn-danger btn-lg" v-on:click="deleteItem(dato.id)">Eliminar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-2">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <div class="row">
                                        <h1>Emails</h1>
                                    </div>
                                    <div class="row" v-for="dato in emails" v-bind:key="dato.id">
                                        <div class="col py-1 m-auto">
                                            <a :href="'mailto:'+dato.value" target="_blank">
                                            {{dato.value}}
                                            </a>
                                        </div>
                                        <div class="col py-1 m-auto">
                                            <button type="button" class="btn btn-primary btn-lg" v-on:click="showEdit(dato)">Editar</button>
                                            <button type="button" class="btn btn-danger btn-lg" v-on:click="deleteItem(dato.id)">Eliminar</button>
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
            cliente: Object
        },

        data() {
            return {
                datos:[
                    {key: 'direccion'},
                    {key: 'telefono'},
                    {key: 'email'},
                ],
                c_cliente: {
                    id: '',
                    nombres: '',
                    apellidos: '',
                    metadatos: [],
                },
                form: this.$inertia.form({
                    cliente_id: '',
                    key: '',
                    value: '',
                }),
                formEdit: this.$inertia.form({
                    id: '',
                    cliente_id: '',
                    key: '',
                    value: '',
                }),
                editando: false,
            }
        },

        mounted() {
            this.c_cliente = this.cliente
            this.form.cliente_id = this.c_cliente.id
        },

        computed: {
            direcciones(){
                return this.c_cliente.metadatos.filter(function (d) {
                    return d.key == 'direccion'
                })
            },
            emails() {
                return this.c_cliente.metadatos.filter(function (d) {
                    return d.key == 'email'
                })
            },
            telefonos() {
                return this.c_cliente.metadatos.filter(function (d) {
                    return d.key == 'telefono'
                })
            },
        },

        methods: {
            add() {
                axios.post(this.route('clientes.metadato.add'),this.form)
                .then(res => {
                    var metadato = res.data.metadato;
                    this.c_cliente.metadatos = this.c_cliente.metadatos.concat(metadato);
                    this.form.reset('key', 'value');
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

                        axios.delete(this.route('clientes.metadato.delete',idItem))
                        .then(res => {
                            var metadato = parseInt(res.data.metadato);
                            this.c_cliente.metadatos = this.c_cliente.metadatos.filter((obj) => {
                                return obj.id !== metadato;
                            })
                            this.$moshaToast('Eliminado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                        })
                        .catch((e) => {
                            this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                        })

                    }
                })

            },
            showEdit(metadato){
                this.formEdit.id = metadato.id
                this.formEdit.cliente_id = metadato.cliente_id
                this.formEdit.key = metadato.key
                this.formEdit.value = metadato.value
                this.editando = true
            },
            guardarEdit(idItem){
                axios.put(this.route('clientes.metadato.update',idItem),this.formEdit)
                .then(() => {

                    this.c_cliente.metadatos.find(n => n.id === idItem).value = this.formEdit.value

                    this.$moshaToast('Editado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                    this.form.reset('key', 'value');
                    this.editando = false
                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
            }
        }
    }
</script>
