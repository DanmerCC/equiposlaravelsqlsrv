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
            <template #estado="{item,row}">
                <button v-if="item=='LABORANDO'" @click="changeState(row,'VACACIONES')" class="btn btn-sm btn-success">
                    {{ item}}
                </button>
                <button v-else class="btn btn-sm btn-secondary" @click="changeState(row,'LABORANDO')" >
                    {{ item }}
                </button>
            </template>
            <template #opciones="{item,row}">
                <button @click="deleteAsesor(row)" class="btn btn-sm btn-danger">
                   Eliminar
                </button>
                <button @click="editAsesores(row)" class="btn btn-sm btn-info">
                   Editar
                </button>
            </template>
        </data-table>
        <select v-model="perPage">
            <option :value="15">15</option>
            <option :value="50">50</option>
            <option :value="150">150</option>
        </select>
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
        <modal-component v-if="asesorEdit!=null" @close="asesorEdit = null">
            <template #body>
                <asesor-form :value="asesorEdit.original" @change="asesorEdit.changes = $event"></asesor-form>
            </template>
            <template #footer>
                <button @click="updateAsesor()" :disabled="!hasAsesorchanges" class="btn btn-secondary">Actualizar</button>
            </template>
        </modal-component>
    </span>
</template>

<script>
import { DataTable, ModalComponent, Paginate } from "@danmerccoscco/personal";

import AsesorSelector from "./AsesorSelector"
import AsesorForm from "./AsesorForm";
import axios from "axios";
export default {
    components: {
        DataTable,
        ModalComponent,
        Paginate,
        AsesorSelector,
        AsesorForm
    },
    computed: {
        hasAsesorchanges(){
            if(this.asesorEdit.changes == null){
                return false
            }

            return Object.keys(this.asesorEdit.changes).length != 0;
        },
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
            perPage:115,
            asesorEdit:null,
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
                    value: "apellido_materno"
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
                    name: "Opciones",
                    value: "opciones"
                },
            ],
            items: []
        };
    },
    methods: {
        changeState(asesor,state){
            axios.put('/api/asesor/'+asesor.id,{estado:state}).then((result) => {
                this.loadData()
                this.asesorEdit = null
            }).catch((err) => {

            });
        },
        updateAsesor(){

            axios.put('/api/asesor/'+this.asesorEdit.original.id,this.asesorEdit.changes).then((result) => {
                this.loadData()
                this.asesorEdit = null
            }).catch((err) => {

            });
        },
        editAsesores(asesor){
            this.asesorEdit = {
                original:Object.assign({},asesor),
                changes:null
            }
        },
        deleteAsesor(asesor){
            if(!confirm("estas seguro de eliminar?"))return;
            axios.delete("/api/asesor/"+asesor.id).then((result) => {
                this.loadData()
            }).catch((err) => {

            });
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
