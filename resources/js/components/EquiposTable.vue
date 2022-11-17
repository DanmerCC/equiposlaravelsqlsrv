<template>
    <span>
        <data-table
            ref="datatable"
            :select="true"
            :columns="columns"
            :items="items"
        >
            <template #top-options>
                <button class="btn btn-primary" @click="openNewModal()">
                    Agregar
                </button>
                <Chip v-if="asignadosFilter" @close="asignadosFilter = false"
                    >Asignados
                </Chip>
                <Chip
                    v-for="(grupo, index) in Object.keys(grupoFilters)"
                    :key="index"
                    @close="
                        delete grupoFilters[grupo];
                        $refs.datatable.$forceUpdate();
                    "
                    >{{ grupo }}
                </Chip>
                <Chip
                    v-if="vacacionesFilter != null"
                    @close="
                        vacacionesFilter = null;
                        $refs.datatable.$forceUpdate();
                    "
                >
                    {{ !vacacionesFilter ? "Laborando" : "Vacaciones" }}
                </Chip>

                <div class="float-right border border-primary">
                    <div
                        title="Buscar equipo"
                        class="input-group input-group-sm"
                        style="width: 300px;"
                    >
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Buscar "
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
            <template #dni="{item,row}">
                <span v-if="row.asesor != null">
                    {{ row.asesor.dni }}
                </span>
                <span v-else>
                    -
                </span>
            </template>
            <template #equipo="{item,row}">
                <span v-if="row.asesor != null">
                    {{ row.asesor.equipo.nombres }}
                    {{ row.asesor.equipo.apellido_paterno }}
                    {{ row.asesor.equipo.apellido_materno }}
                </span>
                <span v-else>
                    -
                </span>
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
            <template #supervisor="{item,row}">
                <button @click="editSupervisor(row)" class="btn btn-sm btn-info">
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
                <button class="btn btn-primary" @click="crearEquipo()">
                    Guardar
                </button>
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
        <modal-component
            v-if="supervisorEditInfo != null"
            @close="supervisorEditInfo = null"
        >
            <template #body>
                <div class="row">
                    <asesor-selector
                        class="col-12"
                        v-model="supervisorEditInfo.changed"
                    ></asesor-selector>
                </div>
            </template>
            <template #footer>
                <button
                    class="btn btn-primary"
                    :disabled="false"
                    @click="updateSupervisor()"
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
import Chip from "./Chip";

export default {
    components: {
        DataTable,
        ModalComponent,
        EquiposForm,
        AsesorSelector,
        Paginate,
        Chip
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
        },
        supervisorEditInfoDiferent() {
            if (this.supervisorEditInfo == null) {
                return false;
            }
            if (this.supervisorEditInfo.original == null) {
                return false;
            }
            return (
                this.supervisorEditInfo.original.id ==
                this.supervisorEditInfo.changed.id
            );
        }
    },
    data() {
        return {
            asignadosFilter: false,
            vacacionesFilter: null,
            grupoFilters: {},
            asesorEditInfo: null,
            supervisorEditInfo:null,
            newEquipoOBject: null,
            search: null,
            page: 1,
            columns: [
                {
                    name: "Dni",
                    value: "dni"
                },
                {
                    name: "Nombre",
                    value: "asesor"
                },
                {
                    name: "Equipo",
                    value: "supervisor"
                },
                /*{
                    name: "Equipo",
                    value: "equipo"
                },*/
                {
                    name: "Estado",
                    value: "estado"
                },
                {
                    name: "Serie",
                    value: "serie"
                },

                {
                    name: "Marca",
                    value: "marca"
                },
                {
                    name: "Modelo",
                    value: "modelo"
                },
                {
                    name: "Color",
                    value: "color"
                },
                {
                    name: "Antiguedad",
                    value: "antiguedad"
                },
                {
                    name: "Precio",
                    value: "precio"
                },
                {
                    name: "Procesador",
                    value: "procesador"
                },
                {
                    name: "Memoria",
                    value: "memoria"
                },
                {
                    name: "Disco duro",
                    value: "tipo_disco"
                },
                {
                    name: "Disco duro",
                    value: "capacidad_disco_duro"
                },
                {
                    name: "Fehca de compra",
                    value: "fecha_compra"
                },
                {
                    name: "Observacion",
                    value: "observacion"
                }
            ],
            items: []
        };
    },
    methods: {
        crearEquipo() {
            axios
                .post(`/api/equipos`, this.newEquipoOBject)
                .then(result => {
                    this.loadData();
                    this.newEquipoOBject = null;
                })
                .catch(err => {
                    console.error(err);
                });
        },
        toggleAsignacionFilter() {
            this.asignadosFilter = !this.asignadosFilter;
            this.$refs.datatable.$forceUpdate();
        },
        toggleVacacionesFilter(value) {
            if (typeof value == "boolean") {
                this.vacacionesFilter = value;
            }

            if (value === null) {
                this.vacacionesFilter = null;
            }
            this.$refs.datatable.$forceUpdate();
        },
        toggleGruposFilter(value) {
            if (typeof this.grupoFilters[value] == "undefined") {
                this.grupoFilters[value] = value;
            } else {
                delete this.grupoFilters[value];
            }
            this.$refs.datatable.$forceUpdate();
            this.loadData();
        },
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
        updateSupervisor() {
            axios
                .put("/api/equipos/" + this.supervisorEditInfo.row.id, {
                    supervisor_id: this.supervisorEditInfo.changed.id
                })
                .then(({ data }) => {
                    this.supervisorEditInfo = null;
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
        editSupervisor(equipo) {
            if (equipo.supervisor == null) {
                this.supervisorEditInfo = {
                    original: null,
                    changed: null,
                    row: equipo
                };
            } else {
                this.supervisorEditInfo = {
                    original: Object.assign({}, equipo.supervisor),
                    changed: equipo.supervisor,
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
            if (this.asignadosFilter) {
                config.params["noasigned"] = true;
            }
            if (this.vacacionesFilter != null) {
                config.params["vacaciones_filter"] = this.vacacionesFilter;
            }
            if (Object.keys(this.grupoFilters).length > 0) {
                config.params["grupo"] = Object.keys(this.grupoFilters);
            }
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
        },
        asignadosFilter(newVal) {
            this.loadData();
        },
        vacacionesFilter(newVal) {
            this.loadData();
        },
        grupoFilters: {
            handler(newVal) {
                this.loadData();
            },
            deep: true
        }
    }
};
</script>

<style></style>
