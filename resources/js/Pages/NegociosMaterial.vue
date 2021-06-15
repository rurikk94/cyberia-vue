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
                                            <li class="breadcrumb-item"><inertia-link :href="route('negocios')">Negocios</inertia-link></li>
                                            <li class="breadcrumb-item active" aria-current="page">Materiales de {{ c_negocio.nombre }}</li>
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
                                    <h1>Materiales del Negocio {{ c_negocio.nombre }} ({{ c_materiales_negocio.length }})</h1>
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
                                                      <label for="material">Material</label>
                                                      <select class="form-control" name="material" id="material" v-model="form.material" required>
                                                          <option v-for="material in c_materiales" v-bind:key="material.id" :value="material.id">{{material.nombre}} {{material.marca}} {{material.modelo}}</option>
                                                      </select>
                                                </div>
                                            </div>
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="number" class="form-control" name="precio" id="precio" v-model="form.precio" required placeholder="precio">
                                                <label for="precio">precio</label>
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
                                                      {{formEdit.material.nombre}} {{formEdit.material.modelo}} {{formEdit.material.nombre}}
                                            </div>
                                            <div class="col-md">
                                                <div class="form-floating">
                                                <input type="number" class="form-control" name="precio" id="precio" v-model="formEdit.precio" required placeholder="precio">
                                                <label for="precio">precio</label>
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
                                        <div class="col py-1 m-auto">Material
                                        </div>
                                        <div class="col py-1 m-auto">Precio
                                        </div>
                                        <div class="col py-1 m-auto">
                                        </div>
                                    </div>
                                    <div class="row" v-for="material in c_materiales_negocio" v-bind:key="material.id">
                                        <div class="col py-1 m-auto">{{material.material.nombre}} {{material.material.marca}} {{material.material.modelo}}
                                        </div>
                                        <div class="col py-1 m-auto">{{'$ ' + material.precio.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")  }}
                                        </div>
                                        <div class="col py-1 m-auto">
                                            <button type="button" class="btn btn-primary btn-lg" v-on:click="showEdit(material)">Editar Precio</button>
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
            materiales: Object,
            materiales_negocio: Object,
            negocio: Object,
        },

        data() {
            return {
                c_materiales_negocio: Object,
                c_materiales: Object,
                c_negocio: Object,
                form: this.$inertia.form({
                    material: '',
                    precio: '',
                }),
                formEdit: this.$inertia.form({
                    id: '',
                    material: '',
                    precio: '',
                }),
                editando: false,
            }
        },

        mounted() {
            this.c_negocio = this.negocio
            this.c_materiales = this.materiales
            this.c_materiales_negocio = this.materiales_negocio
        },
        methods: {
            add() {
                axios.post(this.route('negocios.material.add',this.c_negocio.id),{
                    'material': parseInt(this.form.material),
                    'precio': parseInt(this.form.precio)
                    })
                .then(res => {
                    var material = res.data.material;

                    this.c_materiales_negocio = material;
                    this.form.reset('material', 'precio');
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

                        axios.delete(this.route('negocios.material.delete',idItem),{params: {
                            'id': idItem
                        }})
                        .then(res => {
                            var material = parseInt(res.data.material);
                            this.c_materiales_negocio = this.c_materiales_negocio.filter((obj) => {
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
                this.formEdit.material = material.material
                this.formEdit.precio = material.precio
                this.editando = true
            },
            guardarEdit(idItem){
                axios.put(this.route('negocios.material.update',idItem),this.formEdit)
                .then(() => {

                    this.c_materiales_negocio.find(n => n.id === idItem).precio = this.formEdit.precio

                    this.$moshaToast('Editado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                    this.form.reset('material', 'precio');
                    this.editando = false
                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
            }
        }
    }
</script>
