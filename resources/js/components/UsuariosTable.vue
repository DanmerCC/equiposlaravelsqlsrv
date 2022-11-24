<template>
    <span>

        <data-table :select="true" :columns="columns" :items="items">
            <template #top-options>
                <!--<button class="btn btn-primary" @click="openNewModal()">
                    Agregar
                </button>-->
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
                <!--<equipos-form
                    @changes="newEquipoOBject = $event"
                ></equipos-form>-->
            </template>
            <template #footer>
                <button class="btn btn-primary">Guardar</button>
            </template>
        </modal-component>
        <modal-component
            v-if="userEditInfo != null"
            @close="userEditInfo = null"
        >
            <template #body>
                <div class="row">
                    <asesor-selector
                        class="col-12"
                        v-model="userEditInfo.changed"
                    ></asesor-selector>
                </div>
            </template>
            <template #footer>
                <button
                    class="btn btn-primary"
                    :disabled="userEditInfoDiferent"
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

export default {
    components: {
        DataTable,
        ModalComponent,
        Paginate
    },
    computed: {
        userEditInfoDiferent() {
            if (this.userEditInfo == null) {
                return false;
            }
            if (this.userEditInfo.original == null) {
                return false;
            }
            return (
                this.userEditInfo.original.id == this.userEditInfo.changed.id
            );
        }
    },
    data() {
        return {
            userEditInfo: null,
            newEquipoOBject: null,
            search: null,
            page: 1,
            columns: [
                {
                    name: "Nombre",
                    value: "name"
                },
                {
                    name: "Correo",
                    value: "email"
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
        updateUsuario() {
            axios
                .put("/api/usuarios/" + this.userEditInfo.row.id, {
                    asesor_id: this.userEditInfo.changed.id
                })
                .then(({ data }) => {
                    this.userEditInfo = null;
                    this.loadData();
                });
        },
        editAsesor(equipo) {
            if (equipo.asesor == null) {
                this.userEditInfo = {
                    original: null,
                    changed: null,
                    row: equipo
                };
            } else {
                this.userEditInfo = {
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
                    .get("/api/usuarios", config)
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
