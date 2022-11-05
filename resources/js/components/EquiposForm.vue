<template>
    <div>
        <div
            v-for="(inpt, index) in inputsText"
            :key="index"
            class="form-group row"
        >
            <label
                :for="randomId + inpt.name"
                class="col-sm-2 col-form-label"
                >{{ inpt.label }}</label
            >
            <div class="col-sm-10">
                <input
                    v-model="inputsText[index].value"
                    type="text"
                    class="form-control"
                    :id="randomId + inpt.name"
                    :placeholder="inpt.label"
                />
            </div>
        </div>
        <div class="form-group row">
            <label
                :for="randomId + 'fecha_compra'"
                class="col-sm-2 col-form-label"
                >Fecha de compra</label
            >
            <div class="col-sm-10">
                <input
                    v-model="inputFechaCompra"
                    type="date"
                    class="form-control"
                    :id="randomId + 'fecha_compra'"
                    placeholder="Fecha compra"
                />
            </div>
        </div>

        <div class="form-group row">
            <label
                :for="randomId + 'observacion'"
                class="col-sm-2 col-form-label"
                >Observacion</label
            >
            <div class="col-sm-10">
                <textarea
                    v-model="input_observacion"
                    type="serie"
                    class="form-control"
                    :id="randomId + 'observacion'"
                    placeholder="Observacion"
                />
            </div>
        </div>
    </div>
</template>

<script>
/**
 *  'asesor_id',
    'grupo',
    'marca',
    'modelo',
    'color',
    'serie',
    'fecha_compra',
    'observacion',
 */
export default {
    props: {
        source: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            input_observacion: null,
            inputFechaCompra: null,
            inputsText: [
                { name: "serie", label: "Serie", value: null },
                { name: "color", label: "Color", value: null },
                { name: "modelo", label: "Modelo", value: null },
                { name: "marca", label: "marca", value: null },
                { name: "grupo", label: "grupo", value: null }
            ],
            randomId: this.generateRandomInteger(100)
        };
    },
    methods: {
        generateRandomInteger(max) {
            return Math.floor(Math.random() * max) + 1;
        },
        emitChanges() {
            if (this.source == null) {
                this.$emit("changes");
            }
        }
    },
    computed: {
        inputValues() {
            return {
                ...Object.values(this.inputsText).reduce(
                    (prev, current, index) => {
                        console.log(prev, current, index);
                        prev[current.name] = current.value;
                        return prev;
                    },
                    Object.create(null)
                ),
                observacion: this.input_observacion,
                fecha_compra: this.inputFechaCompra
            };
        }
    },
    mounted() {
        this.randomId = this.generateRandomInteger(100);
    },
    watch: {
        inputsText: {
            handler: function(newValue, oldValue) {
                console.log(newValue);
            },
            deep: true
        }
    }
};
</script>

<style></style>
