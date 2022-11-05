<template>
    <span>
        <data-table :select="true" :columns="columns" :items="items">
            <template #top-options>
                <button class="btn btn-primary" @click="openNewModal()">
                    Agregar
                </button>
            </template>
        </data-table>
        <modal-component
            v-if="newEquipoOBject != null"
            @close="newEquipoOBject = null"
        >
            <template #body>
                <equipos-form></equipos-form>
            </template>
            <template #footer>
                <button class="btn btn-primary">Guardar</button>
            </template>
        </modal-component>
    </span>
</template>

<script>
import { DataTable, ModalComponent } from "@danmerccoscco/personal";
import EquiposForm from "./EquiposForm.vue";

export default {
    components: {
        DataTable,
        ModalComponent,
        EquiposForm
    },
    data() {
        return {
            newEquipoOBject: null,
            columns: [
                {
                    name: "Serie",
                    value: "serie"
                },
                {
                    name: "grupo",
                    value: "grupo"
                },
                {
                    name: "marca",
                    value: "marca"
                },
                {
                    name: "modelo",
                    value: "modelo"
                },
                {
                    name: "color",
                    value: "color"
                },
                {
                    name: "serie",
                    value: "serie"
                },
                {
                    name: "fecha_compra",
                    value: "fecha_compra"
                },
                {
                    name: "observacion",
                    value: "observacion"
                }
            ],
            items: []
        };
    },
    methods: {
        openNewModal() {
            this.newEquipoOBject = {};
        },
        loadData() {
            axios.get("/api/equipos").then(({ data }) => {
                this.items = data.data.data;
            });
        }
    },
    mounted() {
        this.loadData();
    }
};
</script>

<style></style>
