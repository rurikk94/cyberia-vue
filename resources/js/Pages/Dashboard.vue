<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inicio
            </h2>
        </template>

        <div class="pt-12 pb-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        Bienvenido!
                    </div>
                </div>
            </div>
        </div>

        <div class="py-3" v-if=" c_estadisticas.materiales == 0
        || c_estadisticas.negocios == 0 || ( c_estadisticas.materiales > 0 && c_estadisticas.negocios > 0 && c_estadisticas.negocio_materials == 0)
        || c_estadisticas.clientes == 0 || ( c_estadisticas.clientes > 0 && c_estadisticas.trabajos == 0 )
        || ( c_estadisticas.trabajos > 0 && c_estadisticas.agendamientos == 0 ) || c_estadisticas.metadata == 0
        ">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                       <p v-if="c_estadisticas.materiales == 0">
                           Hemos notado que no tienes ningún material agregado, te invitamos a ir a <strong><inertia-link class="btn btn-link btn-sm" :href="route('materiales')">Mis Materiales</inertia-link></strong>, y agregar alguno al sistema, de esta forma podrás cotizar agregandolos después a los <strong>Negocios</strong> que vayas agregando.</p>
                       <p v-if="c_estadisticas.negocios == 0">
                           Hemos notado que no tienes ningún negocio agregado, te invitamos a ir a <strong><inertia-link class="btn btn-link btn-sm" :href="route('negocios')">Mis Negocios</inertia-link></strong>, y agregar alguno al sistema, de esta forma podrás cotizar, asignandole los productos que hayas agregado.</p>
                       <p v-if="c_estadisticas.materiales > 0 && c_estadisticas.negocios > 0 && c_estadisticas.negocio_materials == 0">
                           Hemos notado que no has asignado ningún material a tus negocios. Ve a <strong><inertia-link class="btn btn-link btn-sm" :href="route('negocios')">Mis Negocios</inertia-link></strong>, elige un negocio, y agrega los materiales que has visto en los negocios, indicando su precio, y un link para que lo puedas visitar.</p>
                       <p v-if="c_estadisticas.clientes == 0">
                           Hemos notado que no tienes ningún cliente agregado, te invitamos a ir a <strong><inertia-link class="btn btn-link btn-sm" :href="route('clientes')">Mis Clientes</inertia-link></strong>, y agrega alguno para que lo puedas contactar.</p>
                       <p v-if="c_estadisticas.clientes > 0 && c_estadisticas.trabajos == 0">
                           Hemos notado que no tienes ningún trabajo agregado, te invitamos a ir a <strong><inertia-link class="btn btn-link btn-sm" :href="route('trabajos')">Mis Trabajos</inertia-link></strong>, y agrega un trabajo que realizarás.</p>
                       <p v-if="c_estadisticas.trabajos > 0 && c_estadisticas.agendamientos == 0">
                           Hemos notado que no has agendado ninguna visita, te invitamos a elegir <inertia-link class="btn btn-link btn-sm" :href="route('trabajos')">un trabajo</inertia-link> que hayas agregado y agenda una visita a tu cliente.</p>
                       <p v-if="c_estadisticas.metadata == 0">
                           Hemos notado que no has agregado tu información personal para que tus clientes te puedan contactar. Ve a <strong><inertia-link class="btn btn-link btn-sm" :href="route('profile')">Mis Datos</inertia-link></strong> y agrega tu correo electrónico o tu teléfono.</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="row">
                            <h1>Estadísticas</h1>
                            <div class="col-12 col-sm-6  col-md-4  col-lg-3">
                                <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-2">
                                    <div class="p-6 bg-white border-b border-gray-200 font-12">
                                        <div class="row">
                                            <div class="col-9">Cantidad de trabajos</div>
                                            <div class="col-3"><span class="h3 bg-naranjito text-white p-1 fw-bold">{{ c_estadisticas.trabajos }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6  col-md-4  col-lg-3">
                                <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-2">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        <div class="row">
                                            <div class="col-9">Cantidad de trabajos realizados</div>
                                            <div class="col-3"><span class="h3 bg-naranjito text-white p-1 fw-bold">{{ c_estadisticas.trabajos_realizados }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6  col-md-4  col-lg-3">
                                <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-2">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        <div class="row">
                                            <div class="col-9">Cantidad de trabajos pendientes</div>
                                            <div class="col-3"><span class="h3 bg-naranjito text-white p-1 fw-bold">{{ c_estadisticas.trabajos_por_hacer }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6  col-md-4  col-lg-3">
                                <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-2">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        <div class="row">
                                            <div class="col-9">Cantidad de agendamientos</div>
                                            <div class="col-3"><span class="h3 bg-naranjito text-white p-1 fw-bold">{{ c_estadisticas.agendamientos }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6  col-md-4  col-lg-3">
                                <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-2">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        <div class="row">
                                            <div class="col-9">Cantidad de agendamientos realizados</div>
                                            <div class="col-3"><span class="h3 bg-naranjito text-white p-1 fw-bold">{{ c_estadisticas.agendamientos_realizados }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6  col-md-4  col-lg-3">
                                <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-2">
                                    <div class="p-6 bg-white border-b border-gray-200">
                                        <div class="row">
                                            <div class="col-9">Cantidad de agendamientos pendientes</div>
                                            <div class="col-3"><span class="h3 bg-naranjito text-white p-1 fw-bold">{{ c_estadisticas.agendamientos_por_hacer }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="row">
                            <h1>Estado de avance</h1>
                            <div v-for="estado in c_estadisticas.estado_avance" v-bind:key="estado.estado_avance" class="col-12 col-sm-6  col-md-4  col-lg-3">
                                <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-2">
                                    <div class="p-6 bg-white border-b border-gray-200 font-12">
                                        <div class="row">
                                            <div class="col-9">{{ estado.nombre }}</div>
                                            <div class="col-3"><span class="h3 bg-moradito text-white p-1 fw-bold">{{ estado.cantidad }}</span></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="py-3">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="row">
                            <h1>Tipo de trabajos</h1>
                            <div v-for="tipo in c_estadisticas.tipo_trabajos" v-bind:key="tipo.tipo_trabajos" class="col-12 col-sm-6  col-md-4  col-lg-3">
                                <div class="bg-white overflow-hidden shadow sm:rounded-lg mb-2">
                                    <div class="p-6 bg-white border-b border-gray-200 font-12">
                                        <div class="row">
                                            <div class="col-9">{{ tipo.nombre }}</div>
                                            <div class="col-3"><span class="h3 bg-rojito-palido text-white p-1 fw-bold">{{ tipo.cantidad }}</span></div>
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

    export default {
        components: {
            BreezeAuthenticatedLayout,
        },

        props: {
            auth: Object,
            errors: Object,

            estado_avance: Object,
            estado_cotizacion: Object,
            tipo_trabajos: Object,
            estadisticas: Object
        },

        data() {
            return {
                c_estado_avance: Object,
                c_estado_cotizacion: Object,
                c_tipo_trabajos: Object,
                c_estadisticas: Object,
            }
        },

        mounted() {
            this.c_estado_avance = this.estado_avance
            this.c_estado_cotizacion = this.estado_cotizacion
            this.c_tipo_trabajos = this.tipo_trabajos
            this.c_estadisticas = this.estadisticas
        },
    }
</script>
