<template>
    <div class="mb-4 text-sm text-gray-600 text-center">
        ¿Olvidó su contraseña? <br/> No hay problema. Simplemente háganos saber su dirección de correo electrónico y le enviaremos por correo electrónico un enlace de restablecimiento de contraseña que le permitirá elegir uno nuevo.
    </div>

    <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
        {{ status }}
    </div>

    <breeze-validation-errors class="mb-4" />

    <form @submit.prevent="submit">
        <div>
            <breeze-label for="email" value="Correo electrónico" />
            <breeze-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" required autofocus autocomplete="username" />
        </div>

        <div class="row pt-2">
            <div class="col-12">
                <breeze-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Envíame un correo para restablecer mi contraseña
                </breeze-button>
            </div>
            <div class="col-12 text-end">
                <inertia-link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                    ¿Ya recordó su contraseña?
                </inertia-link>
            </div>
        </div>
    </form>
</template>

<script>
    import BreezeButton from '@/Components/Button'
    import BreezeGuestLayout from "@/Layouts/Guest"
    import BreezeInput from '@/Components/Input'
    import BreezeLabel from '@/Components/Label'
    import BreezeValidationErrors from '@/Components/ValidationErrors'

    export default {
        layout: BreezeGuestLayout,

        components: {
            BreezeButton,
            BreezeInput,
            BreezeLabel,
            BreezeValidationErrors,
        },

        props: {
            auth: Object,
            errors: Object,
            status: String,
        },

        data() {
            return {
                form: this.$inertia.form({
                    email: ''
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('password.email'))
            }
        }
    }
</script>
