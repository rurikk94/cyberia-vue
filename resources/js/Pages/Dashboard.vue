<template>
    <breeze-authenticated-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Inicio
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        Bienvenido!
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
