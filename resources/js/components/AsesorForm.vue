<template>
    <span>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="">
                DNI
            </label>
            <div class="col-sm-10">
                <input
                    v-model="dni"
                    type="text"
                    class="form-control"
                    :id="randomId + 'dni'"
                    :placeholder="'DNI'"
                />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="">
                Nombres
            </label>
            <div class="col-sm-10">
                <input
                    v-model="nombres"
                    type="text"
                    class="form-control"
                    :id="randomId + 'nombres'"
                    :placeholder="'NOmbres'"
                />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="">
                Apellido paterno
            </label>
            <div class="col-sm-10">
                <input
                    v-model="apellido_paterno"
                    type="text"
                    class="form-control"
                    :id="randomId + 'apellido_paterno'"
                    :placeholder="'Ap paterno'"
                />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" for="">
                Apellido materno
            </label>
            <div class="col-sm-10">
                <input
                    v-model="apellido_materno"
                    type="text"
                    class="form-control"
                    :id="randomId + 'apellido_materno'"
                    :placeholder="'apellido_materno'"
                />
            </div>
        </div>
        <div class="form-group row">
            <label class="col-sm-2 col-form-label" :for="randomId+'estado'">
                ESTADO
            </label>
            <div class="col-sm-10">
                <select v-model="estado" class="form-control" name="" :id="randomId+'estado'">
                    <option :value="null">Sin seleccionar</option>
                    <option value="LABORANDO">LABORANDO</option>
                    <option value="VACACIONES">VACACIONES</option>
                </select>
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
            dni: null,
            nombres:null,
            apellido_paterno:null,
            apellido_materno:null,
            estado:null

        }
    },
    methods: {
        emitChanges() {
            this.$emit('change',{
                dni: this.dni,
                nombres:this.nombres,
                apellido_paterno:this.apellido_paterno,
                apellido_materno:this.apellido_materno,
                estado:this.estado

            })
        }
    },
    computed: {
        randomId() {
            return Math.random() * 1.5
        }
    },
    watch: {
        dni(newValue, oldValue) {
            this.emitChanges()
        },
        nombres(newValue, oldValue) {
            this.emitChanges()
        },
        apellido_paterno(newValue, oldValue) {
            this.emitChanges()
        },
        apellido_materno(newValue, oldValue) {
            this.emitChanges()
        },
        estado(newValue, oldValue) {
            this.emitChanges()
        },
    },
    mounted () {
        if(this.value !=null){
            this.dni = this.value.dni
            this.nombres = this.value.nombres
            this.apellido_paterno = this.value.apellido_paterno
            this.apellido_materno = this.value.apellido_materno
            this.estado = this.value.estado
        }
    },
}
</script>

<style>

</style>
