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
                                            <li class="breadcrumb-item active" aria-current="page">Calendario</li>
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
                                    <v-calendar
                                    class="custom-calendar max-w-full"
                                    :masks="masks"
                                    :attributes="attributes"
                                    is-expanded
                                    >
                                    <template v-slot:day-content="{ day, attributes }">
                                        <div class="flex flex-col h-full z-10 overflow-hidden">
                                        <span class="day-label text-sm text-gray-900">{{ day.day }}</span>
                                        <div class="flex-grow overflow-y-auto overflow-x-auto">
                                            <template
                                            v-for="attr in attributes"
                                            :key="attr.key">
                                                <inertia-link
                                                class="text-xs leading-tight rounded-sm p-1 mt-0 mb-1 "
                                                :class="attr.customData.class + ' bg-moradito'"
                                                :href="route('trabajos.show',attr.key)"
                                                data-bs-toggle="tooltip" data-bs-placement="bottom" title="Ver Trabajo">
                                                    {{ attr.customData.title }}
                                                </inertia-link><br/>
                                            </template>

                                        </div>
                                        </div>
                                    </template>
                                    </v-calendar>
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
            Button,
            },

        props: {
            auth: Object,
            errors: Object,
            agenda: Object,
            desde: String,
            hasta: String
        },

        data() {
            const month = new Date().getMonth();
            const year = new Date().getFullYear();
            return {
                fecha: new Date(),
                c_desde: '',
                c_hasta: '',
                c_agenda: [],
                masks: {
                    weekdays: 'WWW',
                },
                attributes: [
                    {
                        key: 1,
                        customData: {
                            title: 'Lunch with mom.',
                            class: 'bg-red-600 text-white',
                        },
                        dates: new Date(year, month, 1),
                    },
                ],
            }
        },

        mounted() {
            this.c_agenda = this.agenda
            this.c_desde = this.desde
            this.c_hasta = this.hasta

            this.attributes = this.agenda
        },

        computed: {
        },

        methods: {
            toMoment(time,formato) {
                var stillUtc = moment.utc(time).toDate();
                return moment(stillUtc).locale('es-mx').local().format(formato);
            },
            getMes(option){
                var desde = this.c_desde
                var hasta = this.c_hasta
                axios.get(this.route('calendario'),{params: {
                            'desde': desde,
                            'hasta': hasta,
                            'option': option
                        }}
                    )
                .then(res => {
                    this.c_agenda = res.data.agenda
                    this.c_desde = res.data.desde
                    this.c_hasta = res.data.hasta
                })
            }
        }
    }
</script>

<style>
    .custom-calendar.vc-container .vc-header {
        background-color: #f1f5f8;
        padding: 10px 0;
    }
    .vc-title {
        font-size: var(--text-lg);
        color: var(--gray-800);
        font-weight: var(--font-semibold);
        line-height: 28px;
        cursor: pointer;
        -webkit-user-select: none;
        user-select: none;
        white-space: nowrap;
    }
    .custom-calendar.vc-container .vc-weeks {
        padding: 0;
    }
    .custom-calendar.vc-container .vc-weekday {
        background-color: var(--weekday-bg);
        border-bottom: var(--weekday-border);
        border-top: var(--weekday-border);
        padding: 5px 0;
    }
    .custom-calendar.vc-container .vc-weekday {
    background-color: var(--weekday-bg);
    border-bottom: var(--weekday-border);
    border-top: var(--weekday-border);
    padding: 5px 0;
}
.vc-weekday{
    text-align: center;
    color: var(--gray-500);
    font-size: var(--text-sm);
    font-weight: var(--font-bold);
    line-height: 14px;
    padding-top: 4px;
    padding-bottom: 8px;
    cursor: default;
    -webkit-user-select: none;
    user-select: none;
}
.vc-container, .vc-container * {
    box-sizing: border-box;
}
* {
    border-radius: 0;
}
*, :after, :before {
    box-sizing: border-box;
    border: 0 solid #e2e8f0;
}
hoja de estilo del agente de usuario
div {
    display: block;
}
.custom-calendar.vc-container {
    --day-border: 1px solid #b8c2cc;
    --day-border-highlight: 1px solid #b8c2cc;
    --day-width: 90px;
    --day-height: 90px;
    --weekday-bg: #f8fafc;
    --weekday-border: 1px solid #eaeaea;
    border-radius: 0;
    width: 100%;
}
.vc-container.vc-blue {
    --accent-100: var(--blue-100);
    --accent-200: var(--blue-200);
    --accent-300: var(--blue-300);
    --accent-400: var(--blue-400);
    --accent-500: var(--blue-500);
    --accent-600: var(--blue-600);
    --accent-700: var(--blue-700);
    --accent-800: var(--blue-800);
    --accent-900: var(--blue-900);
}
.vc-container {
    --font-normal: 400;
    --font-medium: 500;
    --font-semibold: 600;
    --font-bold: 700;
    --text-xs: 12px;
    --text-sm: 14px;
    --text-base: 16px;
    --text-lg: 18px;
    --leading-snug: 1.375;
    --rounded: 0.25rem;
    --rounded-lg: 0.5rem;
    --rounded-full: 9999px;
    --shadow: 0 1px 3px 0 rgba(0,0,0,0.1),0 1px 2px 0 rgba(0,0,0,0.06);
    --shadow-lg: 0 10px 15px -3px rgba(0,0,0,0.1),0 4px 6px -2px rgba(0,0,0,0.05);
    --shadow-inner: inset 0 2px 4px 0 rgba(0,0,0,0.06);
    --slide-translate: 22px;
    --slide-duration: 0.15s;
    --slide-timing: ease;
    --day-content-transition-time: 0.13s ease-in;
    --weeknumber-offset: -34px;
    position: relative;
    display: inline-flex;
    width: -webkit-max-content;
    width: max-content;
    height: -webkit-max-content;
    height: max-content;
    font-family: BlinkMacSystemFont,-apple-system,Segoe UI,Roboto,Oxygen,Ubuntu,Cantarell,Fira Sans,Droid Sans,Helvetica Neue,Helvetica,Arial,sans-serif;
    color: var(--gray-900);
    background-color: var(--white);
    border: 1px solid;
    border-color: var(--gray-400);
    border-radius: var(--rounded-lg);
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    -webkit-tap-highlight-color: transparent;
}
.custom-calendar.vc-container .vc-day {
    padding: 0 5px 3px;
    text-align: left;
    height: var(--day-height);
    min-width: var(--day-width);
    background-color: #fff;
}
.custom-calendar.vc-container {
    --day-border: 1px solid #b8c2cc;
    --day-border-highlight: 1px solid #b8c2cc;
    --day-width: 90px;
    --day-height: 90px;
    --weekday-bg: #f8fafc;
    --weekday-border: 1px solid #eaeaea;
    border-radius: 0;
    width: 100%;
}
</style>