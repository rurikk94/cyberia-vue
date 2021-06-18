<template>
    <div class="row">
        <div class="col-12 col-md-4 py-1">
            <h1>Agenda</h1>
        </div>
        <div class="col-12 col-md-8 py-1 text-uppercase my-auto position-relative d-flex align-items-center">
            <span class="text-muted h3 my-auto" v-on:click="getAgenda('antes')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver semana anterior"> <i class="fas fa-chevron-left"></i> </span>
            <span class="text-muted my-auto"> {{ toMoment(c_desde,'LL') }} al {{ toMoment(c_hasta,'LL') }} </span>
            <span class="text-muted h3 my-auto" v-on:click="getAgenda('despues')" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver semana próxima"> <i class="fas fa-chevron-right"></i> </span>
        </div>
    </div>
    <div class="row my-3" v-for="dato in c_agenda" v-bind:key="dato.id">
        <div class="col-12 col-md-5 py-1 text-uppercase">
            <span class="h3 bg-naranjito text-white p-1 fw-bold">{{ toMoment(dato.fecha_hora_inicio,'DD') }}</span>
            {{ toMoment(dato.fecha_hora_inicio,'MMM') }} {{ toMoment(dato.fecha_hora_inicio,'ddd') }} {{ toMoment(dato.fecha_hora_inicio,'HH:mm') }}-{{ toMoment(dato.fecha_hora_fin,'HH:mm') }}
        </div>
        <div class="col-12 col-md-5 py-1 m-auto">
            {{dato.trabajo.nombre_trabajo}}
        </div>
        <div class="col-12 col-md-2 py-1 m-auto">
            <div class="d-grid gap-2">
                <inertia-link class="btn btn-success btn-lg" :href="route('trabajos.show',dato.trabajo.id)" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver Trabajo">
                    Ver
                </inertia-link>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import { Tooltip, Toast, Popover } from 'bootstrap';
    import moment from 'moment'
    import 'moment/locale/es'

    export default {
        components: {},

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
