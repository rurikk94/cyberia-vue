<template>
    <div class="container">
        <div v-if="!get_c_trabajo" class="row">
            <div class="col">
                <div class="py-2">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200 text-center">
                                <h1>Ver estado del Trabajo</h1>
                                <form @submit.prevent="getTrabajo">
                                <div class="row g-2">
                                        <div class="col">
                                            <div class="form-floating">
                                            <input type="text" class="form-control" name="codigo_trabajo" id="codigo_trabajo" v-model="form.codigo_trabajo" required placeholder="Código del trabajo">
                                            <label for="nombres">Código del trabajo</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <button type="submit" class="btn btn-success btn-lg btn-block">Ingresar</button>
                                        </div>
                                </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" v-if="get_c_trabajo">
            <div class="col">
                <div class="py-2">
                    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6 bg-white border-b border-gray-200">
                                <div class="row mb-2">
                                    <button type="button" class="btn btn-primary btn-lg" v-on:click="this.get_c_trabajo = false">Salir</button>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-8">
                                        <div class="row">
                                            <div class="col-4 d-flex">
                                                <div class="h3">Trabajo</div>
                                            </div>
                                            <div class="col-8">
                                                <h3>{{ c_trabajo.nombre_trabajo }}</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <h3>Cliente</h3>
                                            </div>
                                            <div class="col-8">
                                                <h3>{{c_trabajo.cliente.nombres}} {{c_trabajo.cliente.apellidos}}</h3>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4 d-flex">
                                                <div class="h3">Ubicación</div>
                                            </div>
                                            <div class="col-6">
                                                <h4> {{c_trabajo.ubicacion}} </h4>
                                            </div>
                                            <div class="col-2 d-flex justify-content-around">
                                                <a :href="'https://www.google.com/maps/place/'+c_trabajo.ubicacion" target="_blank" class="text-dark"><i class="fas fa-map-marked-alt  fa-2x" alt="Google Maps"></i></a>
                                                <a :href="'https://waze.com/ul?q='+c_trabajo.ubicacion" target="_blank" class="text-dark"><i class="fab fa-waze fa-2x" alt="Waze"></i></a>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4 d-flex">
                                                <div class="h3">Descripción</div>
                                            </div>
                                            <div class="col-12">
                                                <p>{{c_trabajo.descripcion}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <h3>Tipo de Trabajo</h3>
                                            </div>
                                            <div class="col-8">
                                                <select class="form-control" v-model="c_trabajo.tipo_trabajo" disabled>
                                                    <option v-for="tipo_trabajo in tipo_trabajos" v-bind:key="tipo_trabajo.key" :value="tipo_trabajo.key">{{tipo_trabajo.value}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <h3>Estado Cotización</h3>
                                            </div>
                                            <div class="col-8">
                                                <select class="form-control" v-model="c_trabajo.cotizacion_estado" disabled>
                                                    <option v-for="estado in estado_cotizacion" v-bind:key="estado.key" :value="estado.key">{{estado.value}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-4">
                                                <h3>Estado Avance</h3>
                                            </div>
                                            <div class="col-8">
                                                <select class="form-control" v-model="c_trabajo.avance_estado" disabled>
                                                    <option v-for="estado in estado_avance" v-bind:key="estado.key" :value="estado.key">{{estado.value}}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h3>Documentos <small>
                                                    <button v-on:click="toggleView()" v-bind:class="[!list_view ? 'text-primary' : '', 'm-1']"><i class="fas fa-th"></i></button>
                                                    <button v-on:click="toggleView()" v-bind:class="[list_view ? 'text-primary' : '', 'm-1']"><i class="fas fa-list"></i></button>
                                                    </small>
                                                </h3>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div :class="ancho_card_archivo" v-for="doc in c_trabajo.documentos" v-bind:key="doc.id">
                                                        <div class="card text-center">
                                                            <a :href="this.route('trabajo.cliente.documento.show', [doc.id, c_trabajo.codigo_trabajo])" class="link-dark"  data-bs-toggle="tooltip" data-bs-placement="bottom" :title="'Descargar '+doc.descripcion">
                                                            <div class="card-body">
                                                                    <i v-if="doc.extension == 'pdf'" class="far fa-file-pdf fa-2x"></i>
                                                                    <i v-if="doc.extension == 'png' || doc.extension == 'jpg'" class="far fa-image fa-2x"></i>
                                                                    <p class="text-truncate mb-0">
                                                                        {{ doc.nombre_original }}
                                                                    </p>
                                                            </div>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h3>Calculadora Potencias</h3>
                                            </div>
                                            <div class="col-12">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Aparato</th>
                                                            <th>Potencia (W)</th>
                                                            <th>Tiempo de Uso (h)</th>
                                                            <th>KWh</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(equipo,i) in c_trabajo.potencia.potencias" v-bind:key="i">
                                                            <td>{{ equipo.aparato }}</td>
                                                            <td>{{ equipo.potencia }}</td>
                                                            <td>{{ equipo.tiempo_uso }}</td>
                                                            <td>{{ equipo.potencia * equipo.tiempo_uso / 1000 }}</td>
                                                        </tr>
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td>Total</td>
                                                            <td>{{ totalPotencia() }}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <!-- <p>{{c_trabajo.potencia}}</p> -->
                                            </div>
                                        </div>
                                        <!-- <div class="row">
                                            <div class="col py-1 m-auto">
                                                {{c_trabajo}}
                                            </div>
                                        </div> -->
                                    </div>
                    <!-- columna derecha -->
                                    <div class="col-12 col-lg-4">
                                        <div class="row">
                                            <div class="col-12">
                                                <h3>Electricista Info
                                                </h3>
                                            </div>
                                            <div class="col-12">
                                                <div class="row">
                                                    <div class="col-2"><i class="fas fa-user fa-2x"></i> </div>
                                                    <div class="col-10">{{ c_trabajo.electricista.name }}</div>
                                                </div>
                                                <div class="row" v-for="dato in c_trabajo.electricista.metadato" v-bind:key="dato.id">
                                                    <div class="col-2" v-if="dato.key == 'telefono'"><i class="fas fa-phone-alt  fa-2x"></i> </div>
                                                    <div class="col-2" v-if="dato.key == 'email'"><i class="fas fa-envelope fa-2x"></i></div>
                                                    <div class="col-10" v-if="dato.key == 'telefono'"><a :href="'tel:'+dato.value" target="_blank">{{ dato.value }}</a></div>
                                                    <div class="col-10" v-if="dato.key == 'email'"><a :href="'mailto:'+dato.value" target="_blank">{{ dato.value }}</a></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h3>Cliente Info
                                                </h3>
                                            </div>
                                            <div class="col-12">
                                                <div class="row" v-for="dato in c_trabajo.cliente.metadatos" v-bind:key="dato.id">
                                                    <div class="col-2" v-if="dato.key == 'telefono'"><i class="fas fa-phone-alt  fa-2x"></i> </div>
                                                    <div class="col-2" v-if="dato.key == 'email'"><i class="fas fa-envelope fa-2x"></i></div>
                                                    <div class="col-10" v-if="dato.key == 'telefono'"><a :href="'tel:'+dato.value" target="_blank">{{ dato.value }}</a></div>
                                                    <div class="col-10" v-if="dato.key == 'email'"><a :href="'mailto:'+dato.value" target="_blank">{{ dato.value }}</a></div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-2"><i class="fas fa-key fa-2x"></i></div>
                                                    <div class="col-10">{{ c_trabajo.codigo_trabajo }}</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h3>Agendamientos</h3>
                                            </div>
                                            <div v-if="c_agendamientos.length > 0" class="col-12 fs-6">
                                                <div v-for="agenda in c_agendamientos" v-bind:key="agenda.id" class="row">
                                                    <div class="shadow p-3 mb-2 bg-body rounded">
                                                        {{ toMoment(agenda.fecha_hora_inicio,'LLL') }} hasta el {{ toMoment(agenda.fecha_hora_fin,'LLL') }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else class="col-12 fs-6">
                                                <div  class="row">
                                                    <div class="shadow p-3 mb-2 bg-body rounded">
                                                        No existen agendamientos
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <h3>Materiales</h3>
                                            </div>
                                            <div v-if="c_trabajo.materiales.length > 0" class="col-12 fs-6 shadow">

                                                <div class="row border bg-body rounded">
                                                    <div class="col-2 p-0">
                                                    Cantidad
                                                    </div>
                                                    <div class="col-6">
                                                    Material
                                                    </div>
                                                    <div class="col-4 p-0">
                                                    Precio unitario
                                                    </div>
                                                </div>
                                                <div v-for="material in c_trabajo.materiales" v-bind:key="material.id" class="row border bg-body rounded">
                                                    <div class="col-2 p-0">
                                                        <input class="form-control form-control-sm" v-model="material.cantidad" type="number" placeholder="Cantidad" :aria-label="'Cantidad de' + material.material.nombre" min="1">
                                                    </div>
                                                    <div class="col-6">
                                                        <p>{{material.material.nombre}} {{material.material.marca}} {{material.material.modelo}}</p>
                                                    </div>
                                                    <div class="col-3 p-0">
                                                        <div class="input-group">
                                                            <div class="input-group-prepend">
                                                                <div class="input-group-text p-1">$</div>
                                                            </div>
                                                        <input type="number" v-model="material.precio" min="1" class="form-control form-control-sm">
                                                        </div>
                                                        <img class="img-fluid" :src="route('dashboard.i') + '/storage/' + material.material.imagen.replace('public/', '') " alt="" srcset="">
                                                    </div>
                                                </div>
                                                <div class="row border bg-body rounded">
                                                    <div class="col-3 offset-3">
                                                    Total:
                                                    </div>
                                                    <div class="col-6 text-right">
                                                    {{ totalPrecio() }}
                                                    </div>
                                                </div>
                                            </div>
                                            <div v-else class="col-12 fs-6">
                                                <div  class="row">
                                                    <div class="shadow mb-2 bg-body rounded">
                                                        No existen materiales
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 fs-6">
                                                <div class="row border bg-body rounded">
                                                    <div class="col-12 text-center">
                                                    <a :href="route('trabajo.pdf.cliente.show',[c_trabajo.id, c_trabajo.codigo_trabajo])" target="_blank" class="text-dark"  data-bs-toggle="tooltip" data-bs-placement="bottom" :title="'Exportar trabajo'"><i class="fas fa-cloud-download-alt"></i> Exportar</a>
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
        </div>
    </div>
</template>

<script>
    import axios from 'axios'
    import Button from '@/Components/Button.vue'
    import { Tooltip, Toast, Popover } from 'bootstrap';
    import moment from 'moment'
    import 'moment/locale/es'

    export default {
        components: {
            Toast,
            Button},

        props: {
            auth: Object,
            errors: Object,
        },

        data() {
            return {
                form: this.$inertia.form({
                    codigo_trabajo: '',
                }),
                get_c_trabajo: false,
                c_trabajo: {
                    cliente: {
                        id:'',
                        nombres:'',
                        apellidos: ''
                    },
                    potencia:{
                        potencias:[{potencia:'',tiempo_uso:'',kwh:'',aparato:''}]
                    },
                    ubicacion: '',
                    electricista: {
                        id:'',
                        name:'',
                        metadato:[{potencia:'',tiempo_uso:'',kwh:'',aparato:''}]
                    },
                    materiales: [],
                },
                c_agendamientos: [
                    {
                        id:Number,
                        trabajo_id:Number,
                        fecha_hora_inicio:Date,
                        fecha_hora_fin:Date
                    },
                ],
                estado_avance:[
                    {key:'0',value:'Realizar visita previa'},
                    {key:'1',value:'Esperando aprobación del presupuesto'},
                    {key:'2',value:'Presupuesto aprobado'},
                    {key:'3',value:'Presupuesto rechazado'},
                    {key:'4',value:'Trabajando'},
                    {key:'5',value:'Trabajo Finalizado'}
                ],
                tipo_trabajos:[
                    {key:'1',value:'Instalación eléctrica'},
                    {key:'2',value:'Actualización de planos'},
                    {key:'3',value:'Certificación'},
                ],
                estado_cotizacion:[
                    {key:'0',value:'Obteniendo lista de materiales'},
                    {key:'1',value:'Cotizando materiales'},
                    {key:'2',value:'Esperando aprobación'},
                    {key:'3',value:'Cotizacón rechazada'},
                    {key:'4',value:'Cotizacón aceptada'},
                ],
                list_view: false,
                ancho_card_archivo:'col-6 col-lg-3 mb-1'
            }
        },

        mounted() {
            /* this.c_trabajo = this.trabajo
            this.c_agendamientos = this.agendamientos */
        },

        computed: {
        },

        methods: {
            getTrabajo(){
                axios.post(this.route('trabajos.estado.get'),this.form)
                .then(res => {
                    var trabajo = res.data.trabajo;
                    var agendamientos = res.data.agendamientos;

                    this.c_trabajo = trabajo;
                    this.c_agendamientos = agendamientos;

                    this.get_c_trabajo = true

                    this.form.reset('codigo_trabajo');
                    this.$moshaToast('Trabajo encontrado',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})

                })
                .catch((e) => {
                    this.$moshaToast('No existe ningún trabajo con ese código.',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
            },
            toggleView(){
                this.list_view == false ? this.ancho_card_archivo = 'col-12 mb-1' : this.ancho_card_archivo = 'col-6 col-lg-3 mb-1'
                this.list_view == false ? this.list_view = true : this.list_view = false
            },
            toMoment(time,formato) {
                var stillUtc = moment.utc(time).toDate();
                //var local = moment(stillUtc).local().format('YYYY-MM-DD HH:mm:ss');
                return moment(stillUtc).locale('es-mx').local().format(formato);
            },
            totalPrecio(){
                let sum = 0
                for (let i = 0; i < this.c_trabajo.materiales.length; i++) {
                    const p = this.c_trabajo.materiales[i] //material.negocio.precio
                    //const p = this.c_trabajo.potencia.potencias[i];
                    sum += parseInt(p.precio) * parseInt(p.cantidad)
                }
                return '$ ' + sum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")
            },
            totalPotencia(){
                let sum = 0
                for (let i = 0; i < this.c_trabajo.potencia.potencias.length; i++) {
                    const p = this.c_trabajo.potencia.potencias[i];
                    sum += parseInt(p.potencia) * parseInt(p.tiempo_uso)  / 1000
                }
                return sum
            },
        }
    }
</script>
