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
                                        <div class="col-12 col-lg-8">
                                            <div class="row">
                                                <div class="col-4 d-flex">
                                                    <div class="h3">Trabajo</div>
                                                    <div class="h3 ml-auto" v-if="!editandoNombre"><small><button v-on:click="editarNombre()"><i class="fas fa-edit"></i></button></small></div>
                                                </div>
                                                <div class="col-8" v-if="!editandoNombre">
                                                    <h3>{{ c_trabajo.nombre_trabajo }}</h3>
                                                </div>
                                                <div class="col-8" v-if="editandoNombre">
                                                    <div class="form-floating">
                                                        <textarea v-model="formEdit.nombre_trabajo" class="form-control" placeholder="Trabajo en ... / Plano de ..." style="height: 100px"></textarea>
                                                        <label for="floatingTextarea">Nombre del Trabajo</label>
                                                    </div>
                                                    <button type="button" class="btn btn-primary btn-sm" v-on:click="guardarNombre()">Guardar</button>
                                                    <button type="button" class="btn btn-light btn-sm" v-on:click="cancelarNombre()">Cancelar</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4">
                                                    <h3>Cliente</h3>
                                                </div>
                                                <div class="col-8">
                                                    <inertia-link class="h3 btn btn-link btn-lg" :href="route('clientes.show',c_trabajo.cliente.id)" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver Cliente">
                                                        {{c_trabajo.cliente.nombres}} {{c_trabajo.cliente.apellidos}}
                                                    </inertia-link>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-4 d-flex">
                                                    <div class="h3">Ubicación</div>
                                                    <div class="h3 ml-auto" v-if="!editandoUbicacion"><small><button v-on:click="editarUbicacion()"><i class="fas fa-edit"></i></button></small></div>
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
                                                <div class="col-4 d-flex">
                                                    <div class="h3">Descripción</div>
                                                    <div class="h3 ml-auto" v-if="!editandoDescripcion"><small><button v-on:click="editarDescripcion()"><i class="fas fa-edit"></i></button></small></div>
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
                                                <div class="col-7 col-md-5 col-lg-6 col-xl-4">
                                                    <h3>Documentos <small>
                                                        <button v-on:click="toggleView()" v-bind:class="[!list_view ? 'text-primary' : '', 'm-1']"><i class="fas fa-th"></i></button>
                                                        <button v-on:click="toggleView()" v-bind:class="[list_view ? 'text-primary' : '', 'm-1']"><i class="fas fa-list"></i></button>
                                                        </small>
                                                    </h3>
                                                </div>
                                                <div class="col-5 col-md-7 col-lg-6 col-xl-8">
                                                    <input class="form-control form-control-sm" v-model="searchDocumento" type="text" placeholder="Filtra los documentos" aria-label="Ingresa el nombre de un documento para filtrarlo">
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div :class="ancho_card_archivo" v-for="doc in filteredDocumentos" v-bind:key="doc.id">
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
                                                                <div class="card-body" v-on:click="$refs.file.click()" role="button">
                                                                    <i class="fas fa-upload fa-2x" role="button"></i>
                                                                    <p class="mb-0" role="button"> {{ this.file !== '' ? this.file.name : 'Subir nuevo archivo' }}</p>
                                                                </div>
                                                                <div v-if="this.file !== ''" class="card-footer border-top-0 bg-white">
                                                                    <button class="btn btn-sm btn-secondary" v-on:click="submitFile()">Subir</button>
                                                                </div>
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
                                        <div class="col-12 col-lg-4">
                                            <div class="row">
                                                <div class="col-12">
                                                    <h3>Cliente Info
                                                        <inertia-link class="btn btn-link btn-sm" :href="route('clientes.show',c_trabajo.cliente.id)" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver Cliente">
                                                            <i class="fas fa-external-link-alt"></i>
                                                        </inertia-link>
                                                    </h3>
                                                </div>
                                                <div class="col-12 shadow mb-2 bg-body rounded">
                                                    <div class="row" v-for="dato in c_trabajo.cliente.metadatos" v-bind:key="dato.id">
                                                        <div class="col-2" v-if="dato.key == 'telefono'"><i class="fas fa-phone-alt  fa-2x"></i> </div>
                                                        <div class="col-2" v-if="dato.key == 'email'"><i class="fas fa-envelope fa-2x"></i></div>
                                                        <div class="col-10 align-self-center" v-if="dato.key == 'telefono'"><a :href="'tel:'+dato.value" target="_blank">{{ dato.value }}</a></div>
                                                        <div class="col-10 align-self-center" v-if="dato.key == 'email'"><a :href="'mailto:'+dato.value" target="_blank">{{ dato.value }}</a></div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-2"><i class="fas fa-key fa-2x"></i></div>
                                                        <div class="col-10 align-self-center">{{ c_trabajo.codigo_trabajo }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-flex">
                                                    <h3>Agendamientos</h3>
                                                    <div class="h3 ml-auto" v-if="!agendando"><small><button v-on:click="agendar()"><i class="fas fa-plus"></i> Agendar</button></small></div>
                                                </div>
                                                <div v-if="agendando" class="col-12 fs-6">
                                                    <div class="shadow mb-2 bg-body rounded">
                                                        <p>Al agendar se enviará un email al cliente indicando su agendamiento.</p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <label for="desde">Desde las</label>
                                                            <input type="datetime-local" id="desde" v-model="agendamiento.fecha_hora_inicio">
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                                <label for="hasta">Hasta el</label>
                                                                <input type="datetime-local" id="hasta" v-model="agendamiento.fecha_hora_fin">
                                                        </div>
                                                        <div class="d-flex justify-content-around">
                                                            <button type="button" class="btn btn-primary btn-sm" v-on:click="agendando = false">Cancelar</button>
                                                            <button type="button" class="btn btn-primary btn-sm" v-on:click="guardarAgendamiento()">Agendar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="c_agendamientos.length > 0" class="col-12 fs-6 overflow-auto shadow mb-2" style="max-height: 300px;">
                                                    <div v-for="agenda in c_agendamientos" v-bind:key="agenda.id" class="row">
                                                        <div class="shadow mb-2 bg-body rounded">
                                                            {{ toMoment(agenda.fecha_hora_inicio,'LLL') }} hasta el {{ toMoment(agenda.fecha_hora_fin,'LLL') }}
                                                            <small><button v-on:click="deleteAgendamiento(agenda.id)"  data-bs-toggle="tooltip" data-bs-placement="bottom" :title="'Eliminar documento'"><i class="fas fa-trash-alt"></i></button></small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else class="col-12 fs-6">
                                                    <div  class="row">
                                                        <div class="shadow mb-2 bg-body rounded">
                                                            No existen agendamientos
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12 d-flex">
                                                    <h3>Materiales</h3>
                                                    <div class="h3 ml-auto" v-if="!agregandoMaterial"><small><button v-on:click="material()"><i class="fas fa-plus"></i> Agregar</button></small></div>
                                                </div>
                                                <div v-if="agregandoMaterial" class="col-12 fs-6">
                                                    <div class="shadow mb-2 bg-body rounded">
                                                        <p>Al agregar un material, se agrega a la lista de materiales de este trabajo, y se agrega el precio menor que has cotizado.</p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <label for="desde">Desde las</label>
                                                            <input type="datetime-local" id="desde" v-model="agendamiento.fecha_hora_inicio">
                                                        </div>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                                <label for="hasta">Hasta el</label>
                                                                <input type="datetime-local" id="hasta" v-model="agendamiento.fecha_hora_fin">
                                                        </div>
                                                        <div class="d-flex justify-content-around">
                                                            <button type="button" class="btn btn-primary btn-sm" v-on:click="agregandoMaterial = false">Cancelar</button>
                                                            <button type="button" class="btn btn-primary btn-sm" v-on:click="guardarMaterial()">Agregar</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-if="c_materiales.length > 0" class="col-12 fs-6 overflow-auto shadow">
                                                    <div class="row border bg-body rounded">
                                                        <div class="col-3">
                                                        Cantidad
                                                        </div>
                                                        <div class="col-6">
                                                        Material
                                                        </div>
                                                        <div class="col-3">
                                                        Precio unitario
                                                        </div>
                                                    </div>
                                                    <div v-for="material in c_materiales" v-bind:key="material.id" class="row border bg-body rounded">
                                                        <div class="col-3">
                                                            <input class="form-control form-control-sm" v-model="material.cantidad" type="number" placeholder="Cantidad" :aria-label="'Cantidad de' + material.material.nombre" min="1">
                                                        </div>
                                                        <div class="col-6">
                                                        {{material.material.nombre}} {{material.material.marca}} {{material.material.modelo}}
                                                        </div>
                                                        <div class="col-3">
                                                        {{'$ ' + material.negocio.precio.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".")  }}
                                                        <small><button v-on:click="deleteMaterial(material.id)"  data-bs-toggle="tooltip" data-bs-placement="bottom" :title="'Eliminar Material'"><i class="fas fa-trash-alt"></i></button></small>
                                                        </div>
                                                    </div>
                                                    <div class="row border bg-body rounded">
                                                        <div class="col-6 offset-3">
                                                        Total:
                                                        </div>
                                                        <div class="col-3">
                                                        {{ totalPrecio() }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div v-else class="col-12 fs-6">
                                                    <div  class="row">
                                                        <div class="shadow mb-2 bg-body rounded">
                                                            No existen materiales
                                                            <br/>
                                                            {{ c_materiales}}
                                                            <br/>
                                                            {{ materiales}}
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
            materiales: Object,
        },

        data() {
            return {
                searchDocumento:'',
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
                    documentos: []
                },
                c_agendamientos: [
                    {
                        id:Number,
                        trabajo_id:Number,
                        fecha_hora_inicio:Date,
                        fecha_hora_fin:Date
                    },
                ],
                c_materiales: [
                    {

                        id:Number,
                        trabajo_id:Number,
                        material_id:Number,
                        negocio:{
                            precio:String
                            },
                        material:Object,
                        cantidad:Number
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
                editandoNombre: false,
                agendando: false,
                agregandoMaterial: false,
                formEdit: this.$inertia.form({
                    ubicacion:'',
                    descripcion:'',
                    nombre_trabajo:''
                }),
                agendamiento: this.$inertia.form({
                    trabajo_id: this.trabajo.id,
                    fecha_hora_inicio:'',
                    fecha_hora_fin:''
                }),
                formMaterial: this.$inertia.form({
                    trabajo_id: this.trabajo.id,
                    material_id:'',
                    cantidad:''
                }),
                list_view: false,
                ancho_card_archivo:'col-6 col-lg-3 mb-1'
            }
        },

        mounted() {
            this.c_trabajo = this.trabajo
            this.c_agendamientos = this.agendamientos
            this.c_materiales = this.materiales
        },

        computed: {
            filteredDocumentos() {
            return this.c_trabajo.documentos.filter(item => {
                return item.nombre_original.toLowerCase().indexOf(this.searchDocumento.toLowerCase()) > -1
            })
            }
        },

        methods: {
            material(){
                this.agregandoMaterial = true
                this.formMaterial.trabajo_id = this.c_trabajo.id
                this.formMaterial.material_id = ''
                this.formMaterial.cantidad = ''
            },
            guardarMaterial(){

                axios.post(this.route('agenda.add'),this.agendamiento)
                .then(res => {
                    var material = res.data.material;
                    this.c_materiales = this.c_materiales.concat(material);
                    this.file = '';
                    this.$moshaToast('Agregado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})

                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
                .finally((f) => {
                    this.agregandoMaterial = false
                })
            },
            deleteMaterial(idItem) {

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

                        axios.delete(this.route('agenda.delete',idItem))
                        .then(res => {
                            this.c_materiales = this.c_materiales.filter((obj) => {
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
            deleteAgendamiento(idItem) {

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

                        axios.delete(this.route('agenda.delete',idItem))
                        .then(res => {
                            this.c_agendamientos = this.c_agendamientos.filter((obj) => {
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
            guardarAgendamiento(){
                this.agendando = false

                this.agendamiento.fecha_hora_inicio = moment(this.agendamiento.fecha_hora_inicio).utc().format('YYYY-MM-DDTHH:mm')
                this.agendamiento.fecha_hora_fin = moment(this.agendamiento.fecha_hora_fin).utc().format('YYYY-MM-DDTHH:mm')


                axios.post(this.route('agenda.add'),this.agendamiento)
                .then(res => {
                    var evento = res.data.agendamiento;
                    this.c_agendamientos = this.c_agendamientos.concat(evento);
                    this.file = '';
                    this.$moshaToast('Agregado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})

                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
            },
            agendar(){
                this.agendando = true
                this.agendamiento.id = this.c_trabajo.id
                this.agendamiento.fecha_hora_inicio = moment().format('YYYY-MM-DDTHH:mm')
                this.agendamiento.fecha_hora_fin = moment().add(1, 'hours').format('YYYY-MM-DDTHH:mm')
            },
            cancelarNombre(){
                this.editandoNombre = false
            },
            guardarNombre(){
                axios.put(this.route('trabajo.nombre.update', this.c_trabajo.id),this.formEdit)
                .then(res => {
                    this.c_trabajo.nombre_trabajo = this.formEdit.nombre_trabajo
                    this.$moshaToast('Editado correctamente',{position: 'bottom-right',type: 'success', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
                .catch((e) => {
                    this.$moshaToast('Hubo un error',{position: 'bottom-right',type: 'danger', transition: 'slide', showCloseButton: 'true', showIcon: 'true', hideProgressBar: 'true', swipeClose: 'true'})
                })
                this.editandoNombre = false
            },
            editarNombre(){
                this.editandoNombre = true
                this.formEdit.nombre_trabajo = this.c_trabajo.nombre_trabajo
            },
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
                this.list_view == false ? this.ancho_card_archivo = 'col-12 mb-1' : this.ancho_card_archivo = 'col-6 col-lg-3 mb-1'
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
            totalPrecio(){
                let sum = 0
                for (let i = 0; i < this.c_materiales.length; i++) {
                    const p = this.c_materiales[i] //material.negocio.precio
                    //const p = this.c_trabajo.potencia.potencias[i];
                    sum += parseInt(p.negocio.precio) * parseInt(p.cantidad)
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
