<template>
    <span>
        <data-table :select="true" :columns="columns" :items="items">
            <template #top-options>
                <button class="btn btn-primary" @click="openNewModal()">
                    Agregar
                </button>
                <div class="float-right border border-primary">
                    <div
                        title="Buscar equipo"
                        class="input-group input-group-sm"
                        style="width: 300px;"
                    >
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Buscar por programa"
                            class="form-control"
                        />
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-default">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </template>
            <template #asesor="{item,row}">
                <button @click="editAsesor(row)" class="btn btn-sm btn-info">
                    <span v-if="item == null">
                        Sin Asignar
                    </span>
                    <span v-else>
                        {{ item.nombres }}
                    </span>
                </button>
            </template>
        </data-table>
        <paginate v-model="page" @change="changePage($event)"></paginate>
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
import { DataTable, ModalComponent, Paginate } from "@danmerccoscco/personal";
import EquiposForm from "./EquiposForm.vue";
import AsesorSelector from "./AsesorSelector.vue";

export default {
    components: {
        DataTable,
        ModalComponent,
        EquiposForm,
        AsesorSelector,
        Paginate
    },
    computed: {
        asesorEditInfoDiferent() {
            if (this.asesorEditInfo == null) {
                return false;
            }
            if (this.asesorEditInfo.original == null) {
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
            search: null,
            page: 1,
            columns: [
                {
                    name: "Asesor",
                    value: "asesor"
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
                    name: "procesador",
                    value: "procesador"
                },
                {
                    name: "memoria",
                    value: "memoria"
                },
                {
                    name: "disco_duro",
                    value: "disco_duro"
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
        changePage($event) {
            console.log($event);
            let lastPage = this.page;
            this.page = $event;
            this.loadData()
                .then(result => {
                    //this.page = $event;
                })
                .catch(() => {
                    this.page = lastPage;
                });
        },
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
            if (equipo.asesor == null) {
                this.asesorEditInfo = {
                    original: null,
                    changed: null,
                    row: equipo
                };
            } else {
                this.asesorEditInfo = {
                    original: Object.assign({}, equipo.asesor),
                    changed: equipo.asesor,
                    row: equipo
                };
            }
        },
        openNewModal() {
            this.newEquipoOBject = {};
        },
        loadData() {
            let config = {
                params: {
                    page: this.page
                }
            };
            if (this.search != null && this.search != "") {
                config.params["search"] = this.search;
            }

            return new Promise((resolve, reject) => {
                axios
                    .get("/api/equipos", config)
                    .then(({ data }) => {
                        this.items = data.data.data;
                        resolve();
                    })
                    .catch(error => {
                        reject();
                    });
            });
        }
    },
    mounted() {
        this.loadData();
    },
    watch: {
        search(newVal) {
            this.loadData();
        }
    }
};
</script>

<style></style>
