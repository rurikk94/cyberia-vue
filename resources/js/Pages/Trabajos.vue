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
                                            <li class="breadcrumb-item active" aria-current="page">Trabajos</li>
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
                                            <h1>Mis trabajos</h1>
                                        </div>
                                        <div class="col-3">
                                            <input type="text" v-model="search" placeholder="Busca un trabajo">
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
                                            {{dato.cliente.nombres +' '+ dato.cliente.apellidos}}
                                        </div>
                                        <div class="col py-1 m-auto">
                                            <inertia-link class="btn btn-success btn-lg" :href="route('trabajos.show',dato.id)" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver Trabajo">
                                                Ver
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
            trabajos: Object
        },

        data() {
            return {
                c_trabajos: [],
                search:''
            }
        },

        mounted() {
            this.c_trabajos = this.trabajos
        },

        computed: {
            filteredItems() {
            return this.c_trabajos.filter(item => {
                return item.nombre_trabajo.toLowerCase().indexOf(this.search.toLowerCase()) > -1
            })
            }
        },

        methods: {
        }
    }
</script>
