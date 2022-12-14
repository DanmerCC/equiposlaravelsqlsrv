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
                    @change="emitChanges()"
                />
            </div>
        </div>

        <div class="form-group row">
            <label :for="randomId + 'tipo_hd'" class="col-sm-2 col-form-label"
                >Tipo HD</label
            >
            <div class="col-sm-10">
                <select
                    :id="randomId + 'tipo_hd'"
                    class="form-control"
                    v-model="inputTipoDisco"
                >
                    <option :value="null">Selecciona</option>
                    <option value="SSD">SOLIDO</option>
                    <option value="HDD">MECANICO</option>
                </select>
            </div>
        </div>


        <div class="form-group row">
            <label :for="randomId + 'size_hd'" class="col-sm-2 col-form-label"
                >Tamaño HD</label
            >
            <div class="col-sm-10">
                <input
                    v-model="inputHDSize"
                    type="number"
                    class="form-control"
                    :id="randomId + 'size_hd'"
                    placeholder="Tamaño"
                    @change="emitChanges()"
                />
            </div>
        </div>

        <div class="form-group row">
            <label :for="randomId + 'size_hd'" class="col-sm-2 col-form-label"
                >Precio</label
            >
            <div class="col-sm-10">
                <input
                    v-model="inputPrecio"
                    type="number"
                    class="form-control"
                    :id="randomId + 'precio'"
                    placeholder="Precio"
                    @change="emitChanges()"
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
                    class="form-control"
                    :id="randomId + 'observacion'"
                    placeholder="Observacion"
                    @change="emitChanges()"
                />
            </div>
        </div>
    </div>
</template>

<script>
/**
 *  'asesor_id',
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
            inputHDSize: null,
            inputTipoDisco: null,
            input_observacion: null,
            inputFechaCompra: null,
            inputPrecio: null,
            inputsText: [
                { name: "serie", label: "Serie", value: null },
                { name: "color", label: "Color", value: null },
                { name: "modelo", label: "Modelo", value: null },
                { name: "marca", label: "Marca", value: null },
                { name: "nombre_equipo", label: "Nom Equipo", value: null },
                { name: "procesador", label: "Procesador", value: null },
                { name: "generacion", label: "Generacion", value: null },
                { name: "memoria", label: "Memoria", value: null }
            ],
            randomId: this.generateRandomInteger(100)
        };
    },
    methods: {
        generateRandomInteger(max) {
            return Math.floor(Math.random() * max) + 1;
        },
        emitChanges() {
            this.$emit("changes", this.inputValues);
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
                fecha_compra: this.inputFechaCompra,
                capacidad_disco_duro: this.inputHDSize,
                tipo_disco: this.inputTipoDisco,
                precio: this.inputPrecio,
            };
        }
    },
    mounted() {
        this.randomId = this.generateRandomInteger(100);
        if(this.source !=null){
            this.inputHDSize = this.source.capacidad_disco_duro
            this.inputTipoDisco = this.source.tipo_disco
            this.input_observacion = this.source.observacion
            this.inputFechaCompra = this.source.fecha_compra
            this.inputPrecio = this.source.precio

            this.inputsText.forEach(el => {
                console.log(el.name)
                if(typeof this.source[el.name] != "undefined"){
                    el.value = this.source[el.name]
                }
            });
        }
    },
    watch: {
        inputsText: {
            handler: function(newValue, oldValue) {
                this.emitChanges();
            },
            deep: true
        },
        inputTipoDisco(value){
            this.emitChanges()
        },
        inputHDSize(value){
            this.emitChanges()
        },
        input_observacion(value){
            this.emitChanges()
        },
        inputFechaCompra(value){
            this.emitChanges()
        },
        inputPrecio(value){
            this.emitChanges()
        }
    }
};
</script>

<style></style>
