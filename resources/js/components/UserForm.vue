<template>
    <span>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="">
                Nombre
            </label>
            <div class="col-sm-10">
                <input
                    v-model="nombre"
                    type="text"
                    class="form-control"
                    :id="randomId + 'nombre'"
                    :placeholder="'Nombre'"
                />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="">
                Correo
            </label>
            <div class="col-sm-10">
                <input
                    v-model="correo"
                    type="text"
                    class="form-control"
                    :id="randomId + 'correo'"
                    :placeholder="'correo'"
                />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="">
                password
            </label>
            <div class="col-sm-10">
                <input
                    v-model="password"
                    type="password"
                    class="form-control"
                    :id="randomId + 'password'"
                    :placeholder="'password'"
                />
            </div>
        </div>
    </span>
</template>

<script>
export default {
    props: {
        value: {
            type: Object,
            default:null
        },
    },
    data() {
        return {
            nombre: null,
            correo: null,
            password: null,
        }
    },
    computed: {
        randomId() {
            return Math.random().toString(36).substring(7)
        }
    },
    methods: {
        userObject() {
            return {
                name: this.nombre,
                email: this.correo,
                password: this.password
            }
        }
    },
    watch: {
        nombre(newValue, oldValue) {
            this.$emit('input',this.userObject())
        },
        email(newValue, oldValue) {
            this.$emit('input',this.userObject())
        },
        password(newValue, oldValue) {
            this.$emit('input',this.userObject())
        },
    },
}
</script>

<style>

</style>
