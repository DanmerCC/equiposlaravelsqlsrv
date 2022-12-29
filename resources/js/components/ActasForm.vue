<template>
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Actas</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <!--form-->
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Fecha</label>
                        <input type="date" class="form-control" v-model="int_value.fecha">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Local</label>
                        <input type="text" class="form-control" v-model="int_value.local">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipo asignacion</label>
                        <select v-model="int_value.tipo_asignacion">
                            <option :value="'PERMANENTE'">PERMANENTE</option>
                            <option :value="'TEMPORAL'">TEMPORAL</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    //['fecha','local','fecha_entrega','tipo_asignacion']
    props: {
        source: {
            type: Object,
            default: null
        },
        value:{
            type: Object,
            default: {
                fecha: '',
                local: '',
                fecha_entrega: '',
                tipo_asignacion: ''
            }
        }
    },
    data() {
        return {
            int_value: Object.assign({}, this.source)
        }
    },
    watch: {
        int_value:{
            deep: true,
            handler: function (val) {
                this.$emit('input', this.int_value)
            }
        }
    },
}
</script>

<style>

</style>
