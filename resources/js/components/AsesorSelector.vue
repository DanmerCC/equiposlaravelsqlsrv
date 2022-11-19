<template>
    <v-select
        v-model="int_asesor"
        :options="options"
        @search="search"
    ></v-select>
</template>

<script>
import vSelect from "vue-select";
import asesorService from "./AsesorService";
export default {
    components: {
        vSelect
    },
    props: {
        value: {
            type: Object,
            default: null
        }
    },
    data() {
        return {
            int_asesor: null,
            int_asesor_original: null,
            options: [],
            asesorService
        };
    },
    methods: {
        loadData() {},
        search(search, loading) {
            loading(true);
            this.asesorService.list(1, 100, search).then(data => {
                this.options = data.data.map(z => {
                    z["label"] = z.dni + " " + z.nombres + " " + z.apellido_paterno+ " ...";
                    return z;
                });
                loading(false);
            });
        }
    },
    watch: {
        int_asesor(newValue, oldValue) {
            this.$emit("input", newValue);
        }
    },
    mounted() {
        if (this.value !=null){

            let asesorvalue = {
                label: this.value.dni + " " + this.value.full_name
            };
            this.int_asesor = asesorvalue;
        }
        this.int_asesor_original = Object.assign({}, this.value);
        if (this.options.length == 0) {
            this.options.push(...Object.values([this.int_asesor]));
        }

        this.asesorService.list().then(data => {
            console.log(data);
        });
    }
};
</script>

<style></style>
