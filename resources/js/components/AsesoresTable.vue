<template>
    <span>
        <data-table :select="true" :columns="columns" :items="items">
            <template #top-options>
                <!--<button class="btn btn-primary" @click="openNewModal()">
                    Agregar
                </button>-->
                <div class="float-right border border-primary">
                    <div
                        title="Buscar asesor"
                        class="input-group input-group-sm"
                        style="width: 300px;"
                    >
                        <input
                            v-model="search"
                            type="text"
                            placeholder="Buscar .."
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
            <template #equipo="{item,row}">
                <button @click="editEquipo(row)" class="btn btn-sm btn-info">
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
            v-if="newAsesorObject != null"
            @close="newAsesorObject = null"
        >
            <template #body>
                <!--<equipos-form
                    @changes="newAsesorObject = $event"
                ></equipos-form>-->
            </template>
            <template #footer>
                <button class="btn btn-primary">Guardar</button>
            </template>
        </modal-component>
        <modal-component
            v-if="equipoEditInfo != null"
            @close="equipoEditInfo = null"
        >
            <template #body>
                <div class="row">
                    <asesor-selector
                        class="col-12"
                        v-model="equipoEditInfo.changed"
                    ></asesor-selector>
                </div>
            </template>
            <template #footer>
                <button
                    class="btn btn-primary"
                    :disabled="equipoEditInfoDiferent"
                    @click="updateEquipo()"
                >
                    Guardar
                </button>
            </template>
        </modal-component>
    </span>
</template>

<script>
import { DataTable, ModalComponent, Paginate } from "@danmerccoscco/personal";
import AsesorSelector from "./AsesorSelector"
export default {
    components: {
        DataTable,
        ModalComponent,
        Paginate,
        AsesorSelector
    },
    computed: {
        equipoEditInfoDiferent() {
            if (this.equipoEditInfo == null) {
                return false;
            }
            if (this.equipoEditInfo.original == null) {
                return false;
            }
            return (
                this.equipoEditInfo.original.id == this.equipoEditInfo.changed.id
            );
        }
    },
    data() {
        return {
            equipoEditInfo: null,
            newAsesorObject: null,
            search: null,
            page: 1,
            columns: [
                {
                    name: "DNI",
                    value: "dni"
                },
                {
                    name: "Nombres",
                    value: "nombres"
                },
                {
                    name: "Apellido paterno",
                    value: "apellido_paterno"
                },
                {
                    name: "Apellido materno",
                    value: "apellido_paterno"
                },
                {
                    name: "Equipo",
                    value: "equipo"
                },
                {
                    name: "Estado",
                    value: "estado"
                },
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
        updateEquipo() {
            axios
                .put("/api/asesor/" + this.equipoEditInfo.row.id, {
                    equipo_id: this.equipoEditInfo.changed.id
                })
                .then(({ data }) => {
                    this.equipoEditInfo = null;
                    this.loadData();
                });
        },
        editEquipo(asesor) {
            console.log(asesor)
            if (asesor.equipo == null) {
                this.equipoEditInfo = {
                    original: null,
                    changed: null,
                    row: asesor
                };
            } else {
                this.equipoEditInfo = {
                    original: Object.assign({}, asesor.equipo),
                    changed: asesor.equipo,
                    row: asesor
                };
            }
        },
        openNewModal() {
            this.newAsesorObject = {};
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
                    .get("/api/asesor", config)
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
