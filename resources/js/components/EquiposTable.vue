<template>
    <span>
        <data-table :select="true" :columns="columns" :items="items">
            <template #top-options>
                <button class="btn btn-primary" @click="openNewModal()">
                    Agregar
                </button>
            </template>
            <template #asesor.nombres="{item,row}">
                <button @click="editAsesor(row)" class="btn btn-sm btn-info">
                    {{ item }}
                </button>
            </template>
        </data-table>
        <modal-component
            v-if="newEquipoOBject != null"
            @close="newEquipoOBject = null"
        >
            <template #body>
                <equipos-form
                    @changes="newEquipoOBject = $event"
                ></equipos-form>
            </template>
            <template #footer>
                <button class="btn btn-primary">Guardar</button>
            </template>
        </modal-component>
        <modal-component
            v-if="asesorEditInfo != null"
            @close="asesorEditInfo = null"
        >
            <template #body>
                <div class="row">
                    <asesor-selector
                        class="col-12"
                        v-model="asesorEditInfo.changed"
                    ></asesor-selector>
                </div>
            </template>
            <template #footer>
                <button
                    class="btn btn-primary"
                    :disabled="asesorEditInfoDiferent"
                    @click="updateAsesor()"
                >
                    Guardar
                </button>
            </template>
        </modal-component>
    </span>
</template>

<script>
import { DataTable, ModalComponent } from "@danmerccoscco/personal";
import EquiposForm from "./EquiposForm.vue";
import AsesorSelector from "./AsesorSelector.vue";

export default {
    components: {
        DataTable,
        ModalComponent,
        EquiposForm,
        AsesorSelector
    },
    computed: {
        asesorEditInfoDiferent() {
            if (this.asesorEditInfo == null) {
                return false;
            }
            return (
                this.asesorEditInfo.original.id ==
                this.asesorEditInfo.changed.id
            );
        }
    },
    data() {
        return {
            asesorEditInfo: null,
            newEquipoOBject: null,

            columns: [
                {
                    name: "Asesor",
                    value: "asesor.nombres"
                },
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
        updateAsesor() {
            axios
                .put("/api/equipos/" + this.asesorEditInfo.row.id, {
                    asesor_id: this.asesorEditInfo.changed.id
                })
                .then(({ data }) => {
                    this.asesorEditInfo = null;
                    this.loadData();
                });
        },
        editAsesor(equipo) {
            this.asesorEditInfo = {
                original: Object.assign({}, equipo.asesor),
                changed: equipo.asesor,
                row: equipo
            };
        },
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
