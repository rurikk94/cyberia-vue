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
                                    <Agendamiento :agenda_antes="agenda_antes"  :agenda="agenda"  :agenda_despues="agenda_despues" :desde="desde" :hasta="hasta"/>
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
    import Agendamiento from '@/Components/Agendamiento.vue'
    import { Tooltip, Toast, Popover } from 'bootstrap';
    import moment from 'moment'
    import 'moment/locale/es'

    export default {
        components: {
            BreezeAuthenticatedLayout,
            Toast,
            Button,
            Agendamiento
        },

        props: {
            auth: Object,
            errors: Object,
            agenda_antes: Object,
            agenda: Object,
            agenda_despues: Object,
            desde: String,
            hasta: String,
        },

        data() {
            return {
                c_desde: '',
                c_hasta: '',
                c_agenda_antes: [],
                c_agenda: [],
                c_agenda_despues: [],
            }
        },

        mounted() {
            this.c_agenda_antes = this.agenda_antes
            this.c_agenda = this.agenda
            this.c_agenda_despues = this.agenda_despues
            this.c_desde = this.desde
            this.c_hasta = this.hasta
        },

        computed: {
        },

        methods: {
            toMoment(time,formato) {
                var stillUtc = moment.utc(time).toDate();
                //var local = moment(stillUtc).local().format('YYYY-MM-DD HH:mm:ss');
                return moment(stillUtc).locale('es-mx').local().format(formato);
            },
            getAgenda(option){
                var desde = this.c_desde
                var hasta = this.c_hasta
                if (option == "antes"){
                    this.c_agenda = this.c_agenda_antes
                    this.c_desde = moment(this.c_desde).subtract(2, 'week')
                    this.c_hasta = moment(this.c_hasta).subtract(2, 'week')
                }
                if (option == "despues"){
                    this.c_agenda = this.c_agenda_despues
                    this.c_desde = moment(this.c_desde).add(2, 'week')
                    this.c_hasta = moment(this.c_hasta).add(2, 'week')
                }
                axios.get(this.route('agenda'),{params: {
                            'desde': desde,
                            'hasta': hasta,
                            'option': option
                        }}
                    )
                .then(res => {
                    this.c_agenda_antes = res.data.agenda_antes
                    this.c_agenda = res.data.agenda
                    this.c_agenda_despues = res.data.agenda_despues
                    this.c_desde = res.data.desde
                    this.c_hasta = res.data.hasta
                })
            }
        }
    }
</script>
