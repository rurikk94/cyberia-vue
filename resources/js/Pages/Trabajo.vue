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
                                            <li class="breadcrumb-item"><inertia-link :href="route('agenda')">Agenda</inertia-link></li>
                                            <li class="breadcrumb-item active" aria-current="page">Trabajo</li>
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
                                        <div class="col-8">
                                            <div class="row">
                                                <div class="col-4">
                                                    <h3>Trabajo</h3>
                                                </div>
                                                <div v-if="c_agendamientos.length > 0" class="col-8">
                                                    <h3>Fecha Inicio {{ toMoment(c_agendamientos[0].fecha_hora_inicio,'LLL') }}</h3>
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
                                                <div class="col-4">
                                                    <h3>Ubicación <small><button v-if="!editandoUbicacion" v-on:click="editarUbicacion()"><i class="fas fa-edit"></i></button></small></h3>
                                                </div>
                                                <div class="col-6">
                                                    <h4 v-if="!editandoUbicacion"> {{c_trabajo.ubicacion}} </h4>
                                                    <div v-if="editandoUbicacion" class="form-floating">
                                                        <textarea v-model="formEdit.ubicacion" class="form-control" placeholder="Ubicación del trabajo" style="height: 100px"></textarea>
                                                        <label for="floatingTextarea">Ubicación</label>
                                                    </div>
                                                    <button v-if="editandoUbicacion" type="button" class="btn btn-primary btn-sm" v-on:click="cancelarUbicacion()">Cancelar</button>
                                                    <button v-if="editandoUbicacion" type="button" class="btn btn-primary btn-sm" v-on:click="guardarUbicacion()">Guardar</button>
                                                </div>
                                                <div class="col-2 d-flex justify-content-around">
                                                    <a :href="'https://www.google.com/maps/place/'+c_trabajo.ubicacion" target="_blank" class="text-dark"><i class="fas fa-map-marked-alt  fa-2x" alt="Google Maps"></i></a>
                                                    <a :href="'https://waze.com/ul?q='+c_trabajo.ubicacion" target="_blank" class="text-dark"><i class="fab fa-waze fa-2x" alt="Waze"></i></a>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3>Descripción <small><button v-if="!editandoDescripcion" v-on:click="editarDescripcion()"><i class="fas fa-edit"></i></button></small></h3>
                                                </div>
                                                <div class="col-12">
                                                    <p v-if="!editandoDescripcion">{{c_trabajo.descripcion}}</p>
                                                    <div v-if="editandoDescripcion" class="form-floating">
                                                        <textarea v-model="formEdit.descripcion" class="form-control" placeholder="Descripción del trabajo" style="height: 100px"></textarea>
                                                        <label for="floatingTextarea">Descripción</label>
                                                    </div>
                                                    <button v-if="editandoDescripcion" type="button" class="btn btn-primary btn-sm" v-on:click="cancelarDescripcion()">Cancelar</button>
                                                    <button v-if="editandoDescripcion" type="button" class="btn btn-primary btn-sm" v-on:click="guardarDescripcion()">Guardar</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <h3>Tipo de Trabajo</h3>
                                                </div>
                                                <div class="col-8">
                                                    <select class="form-control" v-model="c_trabajo.tipo_trabajo" required>
                                                        <option v-for="tipo_trabajo in tipo_trabajos" v-bind:key="tipo_trabajo.key" :value="tipo_trabajo.key">{{tipo_trabajo.value}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <h3>Estado Cotización</h3>
                                                </div>
                                                <div class="col-8">
                                                    <select class="form-control" v-model="c_trabajo.cotizacion_estado" required>
                                                        <option v-for="estado in estado_cotizacion" v-bind:key="estado.key" :value="estado.key">{{estado.value}}</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <h3>Estado Avance</h3>
                                                </div>
                                                <div class="col-8">
                                                    <select class="form-control" v-model="c_trabajo.avance_estado" required>
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
                                                                <a :href="this.route('trabajo.documento.show', doc.id)" class="link-dark"  data-bs-toggle="tooltip" data-bs-placement="bottom" :title="'Descargar '+doc.descripcion">
                                                                <div class="card-body">
                                                                        <i v-if="doc.extension == 'pdf'" class="far fa-file-pdf fa-2x"></i>
                                                                        <i v-if="doc.extension == 'png' || doc.extension == 'jpg'" class="far fa-image fa-2x"></i>
                                                                        <p class="text-truncate mb-0">
                                                                            {{ doc.nombre_original }}
                                                                        </p>
                                                                </div>
                                                                </a>
                                                                <small><button v-on:click="deleteDocumento(doc.id)"  data-bs-toggle="tooltip" data-bs-placement="bottom" :title="'Eliminar documento'"><i class="fas fa-trash-alt"></i></button></small>
                                                            </div>
                                                        </div>
                                                        <div :class="ancho_card_archivo">
                                                            <input type="file" id="file" ref="file" v-on:change="handleFileUpload()" style="position: absolute;top: -500px;"/>
                                                            <div class="card text-center" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Subir nuevo archivo">
                                                                <div class="card-body" v-on:click="$refs.file.click()">
                                                                    <i class="fas fa-upload fa-2x" role="button" v-on:click="$refs.file.click()"></i>
                                                                    <p class="mb-0" role="button" v-on:click="$refs.file.click()"> {{ this.file !== '' ? this.file.name : 'Subir nuevo archivo' }}</p>
                                                                </div>
                                                                <button v-if="this.file !== ''" v-on:click="submitFile()">Subir</button>
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
                                                                <td></td>
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
                                        <div class="col-4">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3>Cliente Info</h3>
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
            trabajo: Object,
            agendamientos: Object,
        },

        data() {
            return {
                c_trabajo: {
                    cliente: {
                        nombres:'',
                        apellidos: ''
                    },
                    potencia:{
                        potencias:[{potencia:'',tiempo_uso:'',kwh:'',aparato:''}]
                    },
                    ubicacion: ''
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
                    {key:'1',value:'Esperando aprobación presupuesto'},
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
                    {key:'1',value:'Cotiznado materiales'},
                    {key:'2',value:'Esperando aprobación'},
                    {key:'3',value:'Cotizacón rechazada'},
                    {key:'4',value:'Cotizacón aceptada'},
                ],
                file: '',
                editandoDescripcion: false,
                editandoUbicacion: false,
                formEdit: this.$inertia.form({
                    ubicacion:'',
                    descripcion:''
                }),
                list_view: false,
                ancho_card_archivo:'col-3 mb-1'
            }
        },

        mounted() {
            this.c_trabajo = this.trabajo
            this.c_agendamientos = this.agendamientos
        },

        computed: {
        },

        methods: {
            deleteDocumento(idItem) {

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

                        axios.delete(this.route('trabajo.documento.delete',idItem),{params: {
                            'id': idItem
                        }})
                        .then(res => {
                            //var material = parseInt(res.data.material);
                            this.c_trabajo.documentos = this.c_trabajo.documentos.filter((obj) => {
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
            toggleView(){
                this.list_view == false ? this.ancho_card_archivo = 'col-12 mb-1' : this.ancho_card_archivo = 'col-3 mb-1'
                this.list_view == false ? this.list_view = true : this.list_view = false
            },
            cancelarUbicacion(){
                this.editandoUbicacion = false
            },
            guardarUbicacion(){
                axios.put(this.route('trabajo.ubicacion.update', this.c_trabajo.id),this.formEdit)
                .then(res => {
                    this.c_trabajo.ubicacion = this.formEdit.ubicacion
                    this.$moshaToast('Editado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
                this.editandoUbicacion = false
            },
            editarUbicacion(){
                this.editandoUbicacion = true
                this.formEdit.ubicacion = this.c_trabajo.ubicacion
            },
            cancelarDescripcion(){
                this.editandoDescripcion = false
            },
            guardarDescripcion(){
                axios.put(this.route('trabajo.descripcion.update', this.c_trabajo.id),this.formEdit)
                .then(res => {
                    this.c_trabajo.descripcion = this.formEdit.descripcion
                    this.$moshaToast('Editado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
                this.editandoDescripcion = false
            },
            editarDescripcion(){
                this.editandoDescripcion = true
                this.formEdit.descripcion = this.c_trabajo.descripcion
            },
            toMoment(time,formato) {
                var stillUtc = moment.utc(time).toDate();
                //var local = moment(stillUtc).local().format('YYYY-MM-DD HH:mm:ss');
                return moment(stillUtc).locale('es-mx').local().format(formato);
            },
            totalPotencia(){
                let sum = 0
                for (let i = 0; i < this.c_trabajo.potencia.potencias.length; i++) {
                    const p = this.c_trabajo.potencia.potencias[i];
                    sum += parseInt(p.potencia) * parseInt(p.tiempo_uso)  / 1000
                }
                return sum
            },
            handleFileUpload(){
                this.file = this.$refs.file.files[0];
            },
            submitFile(){
                let formData = new FormData();
                formData.append("trabajo", this.c_trabajo.id);
                formData.append('file', this.file);
                axios.post(this.route('trabajo.documento.add', this.c_trabajo.id),formData,{
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                })
                .then(res => {
                    var documento = res.data.documento;
                    this.c_trabajo.documentos = this.c_trabajo.documentos.concat(documento);
                    this.file = '';
                    this.$moshaToast('Agregado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})

                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })

            },
        }
    }
</script>
