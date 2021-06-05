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
                                            <li class="breadcrumb-item active" aria-current="page">Agenda</li>
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
                                    <h1>Mis Agenda</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="py-2">
                        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                                <div class="p-6 bg-white border-b border-gray-200">
                                    <div class="row">
                                        <h1>Agenda</h1>
                                    </div>
                                    <div class="row" v-for="dato in c_agenda" v-bind:key="dato.id">
                                        <div class="col py-1 m-auto">
                                            {{currentDateTime(dato.fecha_hora_inicio)}}
                                        </div>
                                        <div class="col py-1 m-auto">
                                            {{dato.trabajo.nombre_trabajo}}
                                        </div>
                                        <div class="col py-1 m-auto">
                                            <inertia-link class="btn btn-success btn-lg" :href="route('trabajos.show',dato.trabajo.id)" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver Trabajo">
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
    import moment from 'moment'
    import 'moment/locale/es'

    export default {
        components: {
            BreezeAuthenticatedLayout,
            Toast,
            Button},

        props: {
            auth: Object,
            errors: Object,
            agenda: Object
        },

        data() {
            return {
                c_agenda: [],
            }
        },

        mounted() {
            this.c_agenda = this.agenda
            console.log(this.agenda)
        },

        computed: {
        },

        methods: {
            currentDateTime(time) {
                var stillUtc = moment.utc(time).toDate();
                //var local = moment(stillUtc).local().format('YYYY-MM-DD HH:mm:ss');
                return moment(stillUtc).locale('es-mx').local().format('LLLL');
            }
        }
    }
</script>
